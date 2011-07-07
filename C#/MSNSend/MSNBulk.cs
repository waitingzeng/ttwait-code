using System;
using System.Collections.Generic;
using System.Collections;
using System.Text;
using System.IO;
using System.Threading;
using MSNPSharp;
using MSNPSharp.Core;
using MSNPSharp.DataTransfer;
using System.Configuration;
using TTwait;
using System.Diagnostics;
namespace MSNSend
{
    public class MSNBulk
    {
        private bool running = true;
        private AccountText senders = null;
        private AccountText names = null;
        private int count = 0;
        private Dictionary<string, MSNClient> msnList = new Dictionary<string, MSNClient>();
        
        private TTwaitMsg Msg = null;
        private string cidFileName = null;
        private string authFailFileName = null;
        private int ct = 0;
        private int errCt = 0;
        ConsoleCtrl cc = new ConsoleCtrl();
        private Exclude exclude = null;
        private bool online = false;
        private string path = "";
        private bool autoReload = false;

        private int threadcount = int.Parse(ConfigurationManager.AppSettings["threadcount"]);
        private bool needExclude = ConfigurationManager.AppSettings["exclude"] == "1";
        private string senderCountFileName = null;
        private FileTraceListener filetrace = null;
        private bool onLoging = false;
        private int failcount = 0;
        private int failtoexit = int.Parse(ConfigurationManager.AppSettings["failtoexit"]);
        public MSNBulk(string p)
        {
            

            setPath(p);

            Msg = new TTwaitMsg(path);
            senders = new AccountText(path);
            senders.Once = false;
            names = new AccountText("names");
            names.Once = false;
            if (ConfigurationManager.AppSettings["order"] == "1")
            {
                this.senders.Order = true;
            }

            if (ConfigurationManager.AppSettings["autoReLoad"] == "1")
            {
                this.senders.Once = false;
            }

            if (ConfigurationManager.AppSettings["online"] == "1")
            {
                this.online = true;
            }

            if (ConfigurationManager.AppSettings["autoReload"] == "1")
            {
                this.autoReload = true;
            }

            if (ConfigurationManager.AppSettings["trace"] == "1")
            {
                string tracefile = string.Format("had/trace_{0}.txt", this.path);
                if (File.Exists(tracefile))
                {
                    File.Delete(tracefile);
                }
                filetrace = new FileTraceListener(tracefile);
                Trace.Listeners.Add(filetrace);
            }
            //Settings.SavePath = "mcl";
            Settings.NoSave = true;//ConfigurationManager.AppSettings["nosave"] == "1";
 

            cc.ControlEvent += new ConsoleCtrl.ControlEventHandler(cc_ControlEvent);
            AppDomain.CurrentDomain.UnhandledException += new UnhandledExceptionEventHandler(CurrentDomain_UnhandledException);


            setFileName();
        }

        void setPath(string p)
        {
            p = p.Trim();
            if (p.Length == 0)
            {
                p = ConfigurationManager.AppSettings["default"];
                if (p == null || p.Length == 0)
                {
                    p = "all";
                }
            }
            this.path = p;
            
            //Settings.MSNTicketLifeTime = 20000;
        }

        void setFileName()
        {
            //thisFileName = string.Format("had/{0}_{1}.txt", path, DateTime.Now.ToShortDateString());

            exclude = new Exclude(string.Format("had/{0}.txt", this.path), this.needExclude);

            /**save cid*/
            cidFileName = string.Format("had/cid_{0}_{1}.txt", path, DateTime.Now.ToShortDateString());
            authFailFileName = "had/authfail.txt";
            senderCountFileName = "had/count.txt";
            if (ConfigurationManager.AppSettings["clearauthfail"] == "1")
            {
                Dictionary<string, bool> authFail = new Dictionary<string, bool>();
                if (File.Exists(authFailFileName))
                {
                    foreach (string line in File.ReadAllLines(authFailFileName))
                    {
                        authFail[line.Trim()] = true;
                    }
                    this.senders.Clear(authFail.Keys);
                }
            }
            
            
        }

        void closeFile()
        {
            exclude.Flush();
            this.senders.Sync();
        }

        void CurrentDomain_UnhandledException(object sender, UnhandledExceptionEventArgs e)
        {
            File.WriteAllText("error.txt", e.ToString());
            Console.WriteLine(e.ExceptionObject);
        }



        void cc_ControlEvent(ConsoleCtrl.ConsoleEvent consoleEvent)
        {
            running = false;
            msnList.Clear();
            closeFile(); 
            Console.WriteLine("Ctrl+C to exit");
            System.Environment.Exit(-1);
            
        }

        private void CreateMSN()
        {
            if (!running || msnList.Count >= this.threadcount)
                return;
            if (msnList.Count > 0 && onLoging)
                return;
            string name;
            try
            {
                name = this.senders.Get();
            }
            catch (NotDataException)
            {
                if (this.autoReload)
                {
                    exclude.Clear();
                    this.senders.ReLoad();
                    Console.WriteLine("reload");
                    CreateMSN();
                    return;
                }
                Console.WriteLine("All Sender Finish");
                running = false;
                return;
            }
            count ++;
            MSNClient client = new MSNClient(name, "846266");
            client.Msg = Msg;
            client.Prefix = string.Format("{0} ", count);
            client.Exclude = exclude;
            client.Online = online;
            client.SendFinish += new SendFinishEventHandler(client_SendFinish);
            client.HadSomeError += new HadSomeErrorEventHandler(client_HadSomeError);
            client.SendOneOfflineFinish += new SendOneOfflineFinishEventHandler(client_SendOneFinish);
            client.SendOneOnlineFinish += new SendOneOnlineFinishEventHandler(client_SendOneFinish);
            client.SynchronizationCompleted += new SynchronizationCompletedEventHandler(client_SynchronizationCompleted);
            client.ContactService_AfterCompleted += new ContactService_AfterCompletedEventHandler(client_ContactService_AfterCompleted);
            client.ContactService_ServiceOperationFailed += new ContactService_ServiceOperationFailedEventHandler(client_ContactService_ServiceOperationFailed);
            lock (this)
            {
                this.msnList[name] = client;
            }
            onLoging = true;
            client.Login();
            
            
        }

        void client_ContactService_ServiceOperationFailed(MSNClient m, ServiceOperationFailedEventArgs e)
        {
            
        }

        void client_ContactService_AfterCompleted(MSNClient m, ServiceOperationEventArgs e)
        {
        }
        void client_SynchronizationCompleted(MSNClient m)
        {
            onLoging = false;
            
            lock (this)
            {
                try
                {
                    //StringBuilder mails = new StringBuilder();
                    StringBuilder cids = new StringBuilder();
                    foreach (Contact c in m.Messenger.ContactList.All)
                    {
                        //mails.AppendFormat("{0}\r\n", c.Mail);
                        if(c.IsMessengerUser){
                            cids.AppendFormat("{0}|{1}|{2}\r\n", c.CID.Value, c.Mail, m.Messenger.Owner.Mail);
                        }
                    }
                    //File.AppendAllText(this.thisFileName, mails.ToString());
                    //File.AppendAllText(this.cidFileName, cids.ToString());
                    //File.AppendAllText(this.senderCountFileName, string.Format("{0}:{1}\r\n", m.Messenger.Owner.Mail, m.Messenger.ContactList.Count));
                }catch{}
            }
            m.Messenger.Owner.Name = names.Get();
            //Thread.Sleep(2000);
            if (m.UserListLeft > 0)
            {
                m.SendMsg();
            }
            else
            {
                m.OnSendFinish();
            }
        }

        void SendMsg(MSNClient m)
        {
            failcount = 0;
            if (m.UserListLeft > 0)
            {
                if (MSNClient.SendWait > 0)
                {
                    Thread.Sleep(MSNClient.SendWait);
                }
                m.SendMsg();
            }
            else
            {
                m.OnSendFinish();
            }
        }

        void SaveHad(long Receiver)
        {
            ct++;
            if (this.needExclude)
            {
                exclude.Add(Receiver);
            }
        }

        void client_SendOneFinish(MSNClient m, OIMSendCompletedEventArgs e)
        {
            if (e.Error != null)
            {
                errCt++;
                Console.WriteLine("{4}{0}:{1}, {2}, Error {3}", e.Sender, e.Receiver, e.Error, errCt, m.Prefix);
            }
            else
            {
                Contact c = m.Messenger.ContactList.GetContact(e.Receiver);
                if(c != null && c.CID.HasValue){
                    SaveHad(c.CID.Value);
                }
                failcount = 0;
                Console.WriteLine("{0,6} {1,-30}: {2,-4} Offline {3,-6}", m.Prefix, e.Sender, m.UserListLeft, ct);
            }
            SendMsg(m);
        }

        void client_SendOneFinish(MSNClient m, Contact c)
        {
            SaveHad(c.CID.Value);
            Console.WriteLine("{4} {0}: {1} Online Success {3}", m.Name, m.UserListLeft, c.Mail, ct, m.Prefix);
            SendMsg(m);
        }

        void client_HadSomeError(MSNClient msn)
        {
            failcount++;
            Console.WriteLine("had some error");
            finish(msn);
            if (!msn.AuthFail)
            {
                this.senders.Append(msn.Name);
            }
        }

        void client_SendFinish(MSNClient msn)
        {
            finish(msn);
        }

        void finish(MSNClient msn)
        {
            onLoging = false;
            msn.LoginOff();
            if (msnList.ContainsKey(msn.Name))
            {
                lock (this)
                {
                    msnList.Remove(msn.Name);
                }
                Console.WriteLine("finish");
            }
        }
        public void run()
        {
            try
            {
                this.senders.ReLoad();
            }
            catch (NotDataException)
            {
                Console.WriteLine("Not Sender Data");
                return;
            }
            if (this.senders.Count < this.threadcount)
            {
                this.senders.Clear();
                Console.WriteLine("Account Too little! All Finish");
            }
            if (Msg.Count == 0)
            {
                Console.WriteLine("Not Message to Send");
                return;
            }
            Console.WriteLine("Sender : {0}, Msg : {1}", this.senders.Count, Msg.Count);
            CreateMSN();
            while (running || msnList.Count > 0 || failcount < failtoexit)
            {
                List<MSNClient> need = new List<MSNClient>();
                lock (this)
                {
                    foreach (MSNClient client in msnList.Values)
                    {
                        if (client.CheckTimeOut())
                        {
                            need.Add(client);
                        }
                    }
                }
                foreach (MSNClient client in need)
                {
                    Console.WriteLine("time out to remove");
                    client.OnHadSomeError();
                }
                Console.WriteLine("Current Running MSN: {0}", msnList.Count);
                CreateMSN();
                Thread.Sleep(1000);
            }
            msnList.Clear();
            closeFile();
            Console.WriteLine("All Finish");
            
        }
    }
}
