using System;
using System.Collections.Generic;
using System.Text;
using System.IO;
using MSNPSharp;
using MSNPSharp.Core;
using MSNPSharp.DataTransfer;
using System.Threading;
using System.Configuration;
using TTwait;
namespace MSNSend
{
    public delegate void SendFinishEventHandler(MSNClient m);
    public delegate void SendOneOfflineFinishEventHandler(MSNClient m, OIMSendCompletedEventArgs e);
    public delegate void SendOneOnlineFinishEventHandler(MSNClient m,  Contact e);
    public delegate void HadSomeErrorEventHandler(MSNClient m);
    public delegate void SynchronizationCompletedEventHandler(MSNClient m);
    public delegate void ContactService_ServiceOperationFailedEventHandler(MSNClient m, ServiceOperationFailedEventArgs e);
    public delegate void ContactService_AfterCompletedEventHandler(MSNClient m, ServiceOperationEventArgs e);

    public class MSNClient
    {
        public bool limit = false;
        private string name;

        public string Name
        {
            get { return name; }
        }
        private string psw;
        public string addto = "";
        public int addct = 0;
        private Messenger messenger = null;

        public Messenger Messenger
        {
            get { return messenger; }
        }
        private List<string> userList = new List<string>();

        public int UserListLeft
        {
            get { return userList.Count; }
        }
        public event SendFinishEventHandler SendFinish;
        public event HadSomeErrorEventHandler HadSomeError;
        public event SendOneOfflineFinishEventHandler SendOneOfflineFinish;
        public event SendOneOnlineFinishEventHandler SendOneOnlineFinish;
        public event SynchronizationCompletedEventHandler SynchronizationCompleted;
        public event ContactService_AfterCompletedEventHandler ContactService_AfterCompleted;
        public event ContactService_ServiceOperationFailedEventHandler ContactService_ServiceOperationFailed;

        private string prefix = " ";
        private DateTime actionTime;
        private static int sendWait = int.Parse(ConfigurationManager.AppSettings["sendSpan"]);

        public static int SendWait
        {
            get { return MSNClient.sendWait; }
            set { MSNClient.sendWait = value; }
        }

        private static int connectTimeout = int.Parse(ConfigurationManager.AppSettings["connectTimeout"]);

        public static int ConnectTimeout
        {
            get { return MSNClient.connectTimeout; }
            set { MSNClient.connectTimeout = value; }
        }


        public string Prefix
        {
            get { return prefix; }
            set { prefix = value; }
        }

        private TTwaitMsg msg = null;

        public TTwaitMsg Msg
        {
            get { return msg; }
            set { msg = value; }
        }

        private Exclude exclude = null;

        public Exclude Exclude
        {
            get {
                if (this.exclude == null)
                {
                    this.exclude = new Exclude("", false);
                }
                return exclude; }
            set { exclude = value; }
        }

        private bool online = false;

        public bool Online
        {
            get { return online; }
            set { online = value; }
        }

        Conversation conversation = null;
        public bool AuthFail = false;

        private string testAccount = ConfigurationManager.AppSettings["testTo"];
        private bool needExclude = ConfigurationManager.AppSettings["exclude"] == "1";
        private bool proxy = ConfigurationManager.AppSettings["proxy"] == "1";
        private string proxyhost = ConfigurationManager.AppSettings["proxyhost"];
        private string proxyport = ConfigurationManager.AppSettings["proxyport"];
        private Random rnd = new Random();

        public MSNClient(string name, string psw)
        {
            this.name = name;
            this.psw = psw;
            //this.SetEvent();
        }

        private void SetEvent()
        {
            // set the events that we will handle
            // remember that the nameserver is the server that sends contact lists, notifies you of contact status changes, etc.
            // a switchboard server handles the individual conversation sessions.
            messenger.Nameserver.SignedIn += new EventHandler<EventArgs>(Nameserver_SignedIn);
            messenger.Nameserver.SignedOff += new EventHandler<SignedOffEventArgs>(Nameserver_SignedOff);
            messenger.NameserverProcessor.ConnectingException += new EventHandler<ExceptionEventArgs>(NameserverProcessor_ConnectingException);
            messenger.Nameserver.ExceptionOccurred += new EventHandler<ExceptionEventArgs>(Nameserver_ExceptionOccurred);
            messenger.Nameserver.AuthenticationError += new EventHandler<ExceptionEventArgs>(Nameserver_AuthenticationError);
            messenger.Nameserver.ServerErrorReceived += new EventHandler<MSNErrorEventArgs>(Nameserver_ServerErrorReceived);
            messenger.ContactService.SynchronizationCompleted += new EventHandler<EventArgs>(ContactService_SynchronizationCompleted);
            messenger.OIMService.OIMSendCompleted += new EventHandler<OIMSendCompletedEventArgs>(OIMService_OIMSendCompleted);
            messenger.ContactService.ReverseAdded += new EventHandler<ContactEventArgs>(ContactService_ReverseAdded);
            messenger.ContactService.ContactAdded += new EventHandler<ListMutateEventArgs>(ContactService_ContactAdded);
            messenger.Nameserver.ContactOnline += new EventHandler<ContactEventArgs>(Nameserver_ContactOnline);
            messenger.OIMService.OIMReceived += new EventHandler<OIMReceivedEventArgs>(OIMService_OIMReceived);

            // Handle Service Operation Errors
            //In most cases, these error are not so important.

            messenger.ContactService.ServiceOperationFailed += Contact_ServiceOperationFailed;
            messenger.OIMService.ServiceOperationFailed += ServiceOperationFailed;
            messenger.StorageService.ServiceOperationFailed += ServiceOperationFailed;
            messenger.WhatsUpService.ServiceOperationFailed += ServiceOperationFailed;
            messenger.ContactService.AfterCompleted +=new EventHandler<ServiceOperationEventArgs>(Contact_AfterCompleted);
        }

        void OIMService_OIMReceived(object sender, OIMReceivedEventArgs e)
        {
            SetStatus(string.Format("{0} : {1}", e.Email, e.Message));
            e.IsRead = true;
        }

        void Contact_AfterCompleted(object sender, ServiceOperationEventArgs e)
        {
            ContactService_AfterCompleted(this, e);

        }

        void Contact_ServiceOperationFailed(object sender, ServiceOperationFailedEventArgs e)
        {
            string info = e.Exception.Message;
            SetStatus("ServiceOperationFailed  " + e.Method + ": " + info + sender.GetType().Name);

            ContactService_ServiceOperationFailed(this, e);

        }


        void ServiceOperationFailed(object sender, ServiceOperationFailedEventArgs e)
        {
            string info = e.Exception.Message;
            SetStatus("ServiceOperationFailed  " + e.Method + ": " + info + sender.GetType().Name);
        }

        void Nameserver_ContactOnline(object sender, ContactEventArgs e)
        {
            //SetStatus(e.Contact + "Had Online");
            action();
            if (this.Online)
            {
                if (!this.exclude.ContainsKey(e.Contact.Mail))
                {
                    conversation = messenger.CreateConversation();
                    conversation.ContactJoined += new EventHandler<ContactEventArgs>(conversation_ContactJoined);
                    conversation.Invite(e.Contact);
                }
                else
                {
                    SetStatus(string.Format("{0} had send", e.Contact.Mail));
                }
            }
        }

        void conversation_ContactJoined(object sender, ContactEventArgs e)
        {
            if (conversation.Contacts.Count > 0)
            {
                TextMessage text = new TextMessage(this.msg.get(getName(e.Contact)));
                //if (e.Contact.Mail == testAccount)
                //{
                //    text.Text += "\r\n\r\n" + this.prefix;
                //}
                conversation.SendTextMessage(text);
                conversation.End();
                conversation = null;
                action();
                SendOneOnlineFinish(this, e.Contact);
            }
        }

        void ContactService_ContactAdded(object sender, ListMutateEventArgs e)
        {
            if (e.Contact != null)
            {
                //e.Contact.OnForwardList = true;
                if (e.Contact.Blocked)
                {
                    e.Contact.Blocked = false;
                    SetStatus(e.Contact.Mail + " had been unblock.");
                }
                
            }
        }

        void ContactService_ReverseAdded(object sender, ContactEventArgs e)
        {
            try
            {
                Contact contact = e.Contact;
                if (contact.OnPendingList || (contact.OnReverseList && !contact.OnAllowedList && !contact.OnBlockedList && !contact.OnPendingList))
                {
                    messenger.ContactService.AddNewContact(contact.Mail);

                }
                SetStatus(contact.Mail + " accepted your invitation and added you their contact list.");
            }
            catch { }
        }

        public void SetStatus(string m)
        {
            //MessageBox.Show(msg);
            Console.WriteLine("{0}{1} : {2}", this.Prefix, this.name, m);
        }

        public void action()
        {
            actionTime = DateTime.Now;
        }

        public void Login()
        {
            messenger = new Messenger();
            SetEvent();
            /*
            if (messenger.Connected)
            {
                SetStatus("Disconnecting from server");
                messenger.Disconnect();
            }
            */
            // set the credentials, this is ofcourse something every MSNPSharp program will need to implement.
            
            messenger.Credentials = new Credentials(this.name, this.psw, MsnProtocol.MSNP18);
            if (proxy)
            {
                messenger.ConnectivitySettings.ProxyHost = this.proxyhost;
                messenger.ConnectivitySettings.ProxyPort = int.Parse(this.proxyport);
            }

            // inform the user what is happening and try to connecto to the messenger network.
            SetStatus("Connecting to server");
            action();
            
            messenger.Connect();
        }

        public void LoginOff()
        {
            try
            {
                if (messenger.Connected)
                    messenger.Disconnect();
                
            }
            catch { }
        }

        public void AddContact(string mail)
        {
            AddContact(mail, "");
        }

        public void AddContact(string mail, string invitation)
        {
            //SetStatus("Add " + mail);
            action();
            addct++;
            addto = mail;
            messenger.ContactService.AddNewContact(mail, invitation);
        }

        private string getName(Contact c)
        {
            if(c.NickName != null)
                return c.NickName;
            if (c.Name != null)
                return c.Name;
            return "";
        }

        public void TestSend()
        {
            if (!messenger.Connected)
            {
                this.Login();
            }
            Contact contact = messenger.ContactList.GetContact(testAccount);
            if (contact == null)
            {
                SetStatus("Not Friend");
                return;
            }
            if (contact.Status == PresenceStatus.Online || contact.Status == PresenceStatus.BRB || contact.Status == PresenceStatus.Away)
            {
                conversation = messenger.CreateConversation();
                conversation.ContactJoined +=new EventHandler<ContactEventArgs>(conversation_ContactJoined);
                conversation.Invite(contact);
            }
            else
            {
                messenger.OIMService.SendOIMMessage(testAccount, this.msg.get());
            }
        }

        public Contact getNeedToSend()
        {
            while (userList.Count > 0)
            {
                int index = rnd.Next(userList.Count);
                string c = userList[index];
                userList.RemoveAt(index);
                if (!this.needExclude || !this.Exclude.ContainsKey(c))
                {
                    Contact contact = messenger.ContactList.GetContact(c);
                    return contact;
                    /*
                    if (contact != null)
                    {

                        return contact;
                    }
                    else
                    {
                        SetStatus(string.Format("{0} can not find contact, left {}", c, userList.Count));
                        continue;
                    }
                     * */
                }
                SetStatus(string.Format("{0} had send", c));
            }
            return null;
        }

        public void SendMsg()
        {
            /*
            if (userList.Count == 0)
            {
                this.OnSendFinish();
                return;
            }
             * */
            if (!messenger.Connected)
            {
                this.Login();
            }
            Contact c = getNeedToSend();
            if (c == null)
            {
                SetStatus("get need to send get null");
                this.OnSendFinish();
                return;
            }
            action();
            if (c.Status == PresenceStatus.Online || c.Status == PresenceStatus.BRB || c.Status == PresenceStatus.Away)
            {
                conversation = messenger.CreateConversation();
                conversation.ContactJoined += new EventHandler<ContactEventArgs>(conversation_ContactJoined);
                conversation.Invite(c);
            }
            else
            {
                //messenger.Nameserver.OIMService.SendOIMMessage("ttwaitttwait@hotmail.com", this.msg.get(c.NickName));
                TextMessage text = new TextMessage(this.msg.get(getName(c)));
                if (c.Mail == testAccount)
                {
                    text.Text += "\r\n\r\n" + this.prefix;
                }
                messenger.OIMService.SendOIMMessage(c, text);
            }
        }


        public void OnSendFinish()
        {
            SendFinish(this);
        }

        public void OnHadSomeError()
        {
            HadSomeError(this);
        }

        private void Nameserver_SignedIn(object sender, EventArgs e)
        {
            action();
            SetStatus("Signed into the messenger network as " + messenger.Owner.Name);
            messenger.Owner.Status = PresenceStatus.Online;
        }

        private void Nameserver_SignedOff(object sender, SignedOffEventArgs e)
        {
            
            SetStatus(string.Format("Signed off from the messenger network, left {0}", userList.Count));
            //this.OnSendFinish();
            //if (userList.Count > 0)
            //{
            //    this.Login();
            //}
        }


        private void Nameserver_AuthenticationError(object sender, ExceptionEventArgs e)
        {
            SetStatus("Authentication failed");
            //Console.WriteLine("auth fail");
            AuthFail = true;
            OnHadSomeError();
        }

        private void NameserverProcessor_ConnectingException(object sender, ExceptionEventArgs e)
        {
            SetStatus("Connecting failed");

            OnHadSomeError();
        }

        void ContactService_SynchronizationCompleted(object sender, EventArgs e)
        {
            action();
            
            //if (messenger.ContactList.GetContact(testAccount) == null)
            //{
            //    AddContact(testAccount);
            //}
            while (userList.Count == 0)
            {
                try
                {
                    userList.Clear();
                    foreach (Contact c in messenger.ContactList.All)
                    {
                        if (c.IsMessengerUser)
                        {
                            userList.Add(c.Mail);
                        }
                        else
                        {
                            if (c.Mail == null)
                            {
                                messenger.ContactService.RemoveContact(c);
                            }
                        }
                    }
                    break;
                }
                catch { }
                
            }
            SetStatus(string.Format("friend sync finish, total is {0}", userList.Count));
            SynchronizationCompleted(this);
           
        }

        void OIMService_OIMSendCompleted(object sender, OIMSendCompletedEventArgs e)
        {
            action();
            SendOneOfflineFinish(this, e);
        }

        private void Nameserver_ExceptionOccurred(object sender, ExceptionEventArgs e)
        {
            SetStatus(e.Exception.ToString() + " Nameserver exception");
            //OnHadSomeError();
        }

        /// <summary>
        /// Notifies the user of errors which are send by the MSN server.
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Nameserver_ServerErrorReceived(object sender, MSNErrorEventArgs e)
        {
            // when the MSN server sends an error code we want to be notified.
            SetStatus("Server error received");
            OnHadSomeError();
        }

        public bool checkTimeOut()
        {
            TimeSpan span = DateTime.Now.Subtract(actionTime);

            if (span.TotalSeconds >= MSNClient.ConnectTimeout)
            {
                SetStatus("Time Out");
                return true;
            }
            return false;
        }

    }
}
