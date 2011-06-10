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
    public class MSNTestSend
    {
        private TTwaitMsg Msg = null;
        ConsoleCtrl cc = new ConsoleCtrl();
        public string testSender = ConfigurationManager.AppSettings["testSender"];
        private string testTo = ConfigurationManager.AppSettings["testTo"];

        public string TestTo
        {
            get { return testTo; }
            set { testTo = value; }
        }
        string path = "";

        
        MSNClient client = null;
        int testNum = 5;

        public int TestNum
        {
            get { return testNum; }
            set { testNum = value; }
        }

        public MSNTestSend(string path)
        {
            setPath(path);
            Msg = new TTwaitMsg(this.path);

            cc.ControlEvent += new ConsoleCtrl.ControlEventHandler(cc_ControlEvent);
            AppDomain.CurrentDomain.UnhandledException += new UnhandledExceptionEventHandler(CurrentDomain_UnhandledException);
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
            Settings.NoSave = true;
            //Settings.SavePath = "had/" + p;
            //Settings.MSNTicketLifeTime = 20000;
        }



        void CurrentDomain_UnhandledException(object sender, UnhandledExceptionEventArgs e)
        {
            Console.WriteLine(e.ExceptionObject);
        }



        void cc_ControlEvent(ConsoleCtrl.ConsoleEvent consoleEvent)
        {
            Console.WriteLine("Ctrl+C to exit");
            System.Environment.Exit(-1);
            
        }

        private void createMSN()
        {
            
            client = new MSNClient(testSender, "846266");
            client.Msg = Msg;
            client.Prefix = "1: ";
            client.SendFinish += new SendFinishEventHandler(client_SendFinish);
            client.HadSomeError += new HadSomeErrorEventHandler(client_HadSomeError);
            client.SendOneOfflineFinish += new SendOneOfflineFinishEventHandler(client_SendOneFinish);
            client.SendOneOnlineFinish += new SendOneOnlineFinishEventHandler(client_SendOneFinish);
            client.SynchronizationCompleted += new SynchronizationCompletedEventHandler(client_SynchronizationCompleted);
            client.Login();
        }

        void client_SynchronizationCompleted(MSNClient m)
        {
            //Thread.Sleep(3000);
            m.TestSend();
            testNum--;
        }

        void client_SendOneFinish(MSNClient m, OIMSendCompletedEventArgs e)
        {
            if (e.Error != null)
            {
                Console.WriteLine("{0} Error", testNum);
            }
            else
            {
                Console.WriteLine("{0} Offline Success", testNum);
            }
            if (testNum == 0)
            {
                finish(m);
            }
            else
            {
                //Thread.Sleep(2000);
                m.TestSend();
                testNum--;
            }
        }

        void client_SendOneFinish(MSNClient m, Contact c)
        {
            
            Console.WriteLine("{0} Online Success", testNum);
            if (testNum == 0)
            {
                finish(m);
            }
            else
            {
                //Thread.Sleep(2000);
                m.TestSend();
                testNum--;
            }
        }

        void client_HadSomeError(MSNClient msn)
        {
            finish(msn);
        }

        void client_SendFinish(MSNClient msn)
        {
            finish(msn);
        }

        void finish(MSNClient msn)
        {
            msn.LoginOff();
            System.Environment.Exit(-1);
        }
        public void run()
        {
            if (Msg.Count == 0)
            {
                Console.WriteLine("Not Message to Send");
                return;
            }
            Console.WriteLine("Msg : {0}", Msg.Count);
            createMSN();
            while (true)
            {
                Thread.Sleep(1000);

            }
            Console.ReadLine();
        }
    }
}
