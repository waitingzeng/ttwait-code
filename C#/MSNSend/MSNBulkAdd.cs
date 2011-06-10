using System;
using System.Collections.Generic;
using System.Text;
using System.IO;
using System.Threading;
using MSNPSharp;
using MSNPSharp.Core;
using MSNPSharp.DataTransfer;
using System.Configuration;
using TTwait;
namespace MSNSend
{
    public class MSNBulkAdd
    {
        private bool running = true;
        private AccountText senders = null;
        private AccountText tos = null;
        private int count = 0;
        private int total = 0;
        private int threadcount = int.Parse(ConfigurationManager.AppSettings["addthreadcount"]);
        ConsoleCtrl cc = new ConsoleCtrl();
        private Dictionary<string, MSNClient> msnList = new Dictionary<string, MSNClient>();
        private Dictionary<string, bool> exclude = new Dictionary<string,bool>();
        private string path = "";
        private int min = 0;
        private int max = 0;
        private Random rnd = new Random();

        private string cidFileName = null;
        private string authFailFileName = null;
        private string senderCountFileName = null;

        public MSNBulkAdd(string p)
        {
            Settings.NoSave = true;

            setPath(p);
            AccountText.Directory = path;
            senders = new AccountText("sender");
            tos = new AccountText("tos");
            this.senders.Once = false;

            threadcount = int.Parse(ConfigurationManager.AppSettings["addThreadCount"]);

            min = int.Parse(ConfigurationManager.AppSettings["addMin"]);
            max = int.Parse(ConfigurationManager.AppSettings["addMax"]);

            cc.ControlEvent += new ConsoleCtrl.ControlEventHandler(cc_ControlEvent);
            AppDomain.CurrentDomain.UnhandledException += new UnhandledExceptionEventHandler(CurrentDomain_UnhandledException);


            openFile();
        }

        void setPath(string p)
        {
            p = p.Trim();
            if (p.Length == 0)
            {
                p = ConfigurationManager.AppSettings["addFriendDefault"];
                if (p == null || p.Length == 0)
                {
                    p = "addFriend";
                }
            }
            this.path = p;
        }

        void openFile()
        {

            string filename = "";

            if (ConfigurationManager.AppSettings["addExclude"].Length > 0)
            {
                filename = string.Format("{0}/{1}", path, ConfigurationManager.AppSettings["addExclude"]);
                if (File.Exists(filename))
                {
                    foreach (string line in File.ReadAllLines(filename))
                    {
                        exclude[line.Trim()] = true;
                    }
                }
            }
           
            cidFileName = string.Format("had/cid_{0}_{1}.txt", path, DateTime.Now.ToShortDateString());
            authFailFileName = "had/authfail.txt";
            senderCountFileName = string.Format("had/{0}_count.txt", path);
            Dictionary<string, bool> authFail = new Dictionary<string, bool>();
            if (File.Exists(authFailFileName))
            {
                foreach (string line in File.ReadAllLines(authFailFileName))
                {
                    authFail[line.Trim()] = true;
                }
                this.senders.clear(authFail.Keys);
            }
        }

        void closeFile()
        {
            this.senders.sync();
        }

        void CurrentDomain_UnhandledException(object sender, UnhandledExceptionEventArgs e)
        {
            Console.WriteLine(e.ExceptionObject);
        }



        void cc_ControlEvent(ConsoleCtrl.ConsoleEvent consoleEvent)
        {
            running = false;
            closeFile();
            Console.WriteLine("Ctrl+C to exit");
            System.Environment.Exit(-1);
            
        }

        private void createMSN()
        {
            if (!running)
                return;
            if (msnList.Count > threadcount)
                return;
            string name;
            try
            {
                name = this.senders.get();
            }
            catch (NotDataException)
            {
                Console.WriteLine("All Sender Finish");
                running = false;
                return;
            }
            count ++;
            MSNClient client = new MSNClient(name, "846266");
            client.Prefix = string.Format("{0} ", count);
            client.HadSomeError += new HadSomeErrorEventHandler(client_HadSomeError);
            client.SynchronizationCompleted += new SynchronizationCompletedEventHandler(client_SynchronizationCompleted);
            client.ContactService_AfterCompleted+=new ContactService_AfterCompletedEventHandler(client_ContactService_AfterCompleted);
            client.ContactService_ServiceOperationFailed+=new ContactService_ServiceOperationFailedEventHandler(client_ContactService_ServiceOperationFailed);
            lock (this)
            {
                this.msnList[name] = client;
            }
            client.Login();
        }

        void  client_ContactService_ServiceOperationFailed(MSNClient m, ServiceOperationFailedEventArgs e)
        {
            if (m.addto.Length == 0) return;
            if (e.Exception.Message.ToLower().Contains("quota limit reached"))
            {
                finish(m);
            }
        }

        void  client_ContactService_AfterCompleted(MSNClient m, ServiceOperationEventArgs e)
        {
            if (m.addto.Length == 0) return;
            Add(m);
        }

        void Add(MSNClient m)
        {
            if (m.addto.Length > 0)
            {
                total++;
                Console.WriteLine("{0}{1} Add {2} {3} {4}", m.Prefix, m.Name, m.addto, m.addct, total);
            }
            Thread.Sleep(rnd.Next(3, 5));
            string to = getTo();
            if (to == null)
            {
                finish(m);
            }
            m.AddContact(to);
        }

        void client_HadSomeError(MSNClient m)
        {
            finish(m);
        }

        void finish(MSNClient msn)
        {
            msn.LoginOff();
            if (msnList.ContainsKey(msn.Name))
            {
                lock (this)
                {
                    msnList.Remove(msn.Name);
                }
                createMSN();
            }
        }
        void client_SynchronizationCompleted(MSNClient m)
        {
            lock (this)
            {
                try
                {
                    StringBuilder cids = new StringBuilder();
                    foreach (Contact c in m.Messenger.ContactList.All)
                    {
                        //mails.AppendFormat("{0}\r\n", c.Mail);
                        if (c.IsMessengerUser && c.CID != 0)
                        {
                            cids.AppendFormat("{0}|{1}|{2}\r\n", c.CID, c.Mail, m.Messenger.Owner.Mail);
                        }
                    }
                    //File.AppendAllText(this.thisFileName, mails.ToString());
                    File.AppendAllText(this.cidFileName, cids.ToString());
                    File.AppendAllText(this.senderCountFileName, string.Format("{0}:{1}\r\n", m.Messenger.Owner.Mail, m.Messenger.ContactList.Count));
                }catch{}
            }
            Add(m);
        }

        private string getTo()
        {
            while (true)
            {
                string to;
                try
                {
                    to = tos.get();
                }
                catch (NotDataException)
                {
                    Console.WriteLine("Not Data To Add");
                    running = false;
                    return null;
                }
                if (exclude.ContainsKey(to))
                {
                    Console.WriteLine("Had Add");

                }
                return to;
            }
        }


        public void run()
        {
            try
            {
                this.senders.load();
                this.tos.load();
            }
            catch (NotDataException)
            {
                Console.WriteLine("Not Sender Data");
                return;
            }
            if (tos.Count == 0)
            {
                Console.WriteLine("Not Tos Data");
                return;
            }
            Console.WriteLine("Sender : {0}, Tos : {1}", this.senders.Count, tos.Count);
            createMSN();
            int i = 0;
            while (running)
            {
                i++;
                if (i >= 100)
                {
                    this.senders.sync();
                    this.tos.sync();
                }
                List<MSNClient> need = new List<MSNClient>();
                lock (this)
                {
                    foreach (MSNClient client in msnList.Values)
                    {
                        if (client.checkTimeOut())
                        {
                            need.Add(client);
                        }
                    }
                }
                foreach (MSNClient client in need)
                {
                    client.OnHadSomeError();
                }
                Console.WriteLine("Current Running MSN: {0}", msnList.Count);
                if (msnList.Count < this.threadcount && tos.Count > 0)
                {
                    createMSN();
                }
                Thread.Sleep(1000);
            }
            closeFile();
            Console.WriteLine("All Finish");
            
        }
    }
}
