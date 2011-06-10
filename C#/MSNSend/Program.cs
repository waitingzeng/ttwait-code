using System;
using System.Collections.Generic;
using System.Text;
using System.Threading;
using System.Configuration;
using TTwait;

namespace MSNSend
{
    class Program
    {
        static void Main(string[] args)
        {
            Getopt g = new Getopt("MSNSend", args, "ap:tn:s:");
            string p = "";
            bool addFriend = false;
            bool test = false;
            string testAccount = "";
            int testNum = 5;
            int c;
            while ((c = g.getopt()) != -1)
            {
                switch (c)
                {
                    case 'a':
                        addFriend = true;
                        break;
                    case 'p':
                        p = g.Optarg;
                        break;
                    case 't':
                        test = true;
                        break;
                    case 's':
                        testAccount = g.Optarg;
                        break;
                    case 'n':
                        testNum = int.Parse(g.Optarg);
                        break;
                       
                }
            }
            if (test)
            {
                MSNTestSend app = new MSNTestSend(p);
                app.TestNum = testNum;
                if (testAccount.Length > 0)
                {
                    app.TestTo = testAccount;
                }
                app.run();
                return;
            }
            else if (addFriend)
            {
                MSNBulkAdd app = new MSNBulkAdd(p);
                app.run();
                return;
            }
            else
            {
                MSNBulk app = new MSNBulk(p);
                app.run();
            }
        }
    }
}
