using System;
using System.Collections.Generic;
using System.Text;
using System.IO;
using System.Configuration;

namespace TTwait
{
    public class Urls
    {
        private List<string> urllist = new List<string>();
        private Random rnd = new Random();
        public Urls(string path)
        {
            string realfilename = "urls.txt";
            string filename = string.Format("{0}/urls.txt", path);
            if (File.Exists(filename))
            {
                realfilename = filename;
            }
            else
            {
                if (!File.Exists(realfilename))
                {
                    return;
                }
            }

            foreach (string line in File.ReadAllLines(realfilename))
            {
                string line1 = line.Trim();
                if (line1.Length > 0)
                {
                    urllist.Add(line1);
                }
            }
        }

        public string get()
        {
            if (urllist.Count > 0)
            {
                return urllist[rnd.Next(urllist.Count)];
            }
            return "";
        }
    }

    public class TTwaitMsg
    {
        private string path;
        private List<string> mailList = new List<string>();
        private Random rnd = new Random();
        private Urls url = null;
        private bool interference = true;

        public TTwaitMsg(string path)
        {
            this.path = path;
            url = new Urls(path);
            this.load();
            this.interference = ConfigurationManager.AppSettings["msgInter"] == "1";
        }

        public void load()
        {
            if (!Directory.Exists(path))
                return;
            foreach (string file in Directory.GetFiles(path))
            {
                if (file.EndsWith(".html") && !file.StartsWith("_"))
                {
                    string s = File.ReadAllText(file).Trim();
                    if (s.Length > 0)
                    {
                        mailList.Add(s);
                    }
                }
            }
        }

        public string get(string name)
        {
            lock (this)
            {
                if (mailList.Count == 0)
                    return "";
                string msg = mailList[rnd.Next(mailList.Count)];

                msg = msg.Replace("{url}", url.get()).Replace("{name}", name);
                if (this.interference)
                {
                    msg += string.Format("\r\n\r\n {0}", rnd.Next(int.MaxValue / 10, int.MaxValue));
                }
                return msg;
            }
        }

        public string get()
        {
            return get("");
        }

        public int Count
        {
            get
            {
                return mailList.Count;
            }
        }
    }
}
