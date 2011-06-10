using System;
using System.Collections.Generic;
using System.Text;
using System.IO;

namespace TTwait
{
    [Serializable()]
    public class NotDataException : System.Exception
    {
        public NotDataException() { }
        public NotDataException(string message) { }
        public NotDataException(string message, System.Exception inner) { }

        // Constructor needed for serialization 
        // when exception propagates from a remoting server to the client.
        protected NotDataException(System.Runtime.Serialization.SerializationInfo info,
            System.Runtime.Serialization.StreamingContext context) { }
    }

    public class AccountText
    {
        private string name;
        private string localfile;
        private string cachefile;
        private bool once = true;

        public bool Once
        {
            get { return once; }
            set { once = value; }
        }
        private bool order = false;

        public bool Order
        {
            get { return order; }
            set { order = value; }
        }

        private bool change = false;
        private List<string> data = new List<string>();
        private Random rnd = new Random();
        private static string directory = "data";

        public static string Directory
        {
            get { return AccountText.directory; }
            set { AccountText.directory = value; }
        }

        public AccountText(string name)
        {
            this.name = name;
            this.localfile = string.Format("{0}/{1}.txt", AccountText.Directory,  name);
            this.cachefile = string.Format("{0}/cache_{1}.txt", AccountText.Directory, name);
        }

        public void createCache()
        {
            if(File.Exists(this.cachefile)){
                this.updateCache();
            }else{
                throw new NotDataException();
            }
        }
    
        private void updateCache()
        {
            if(File.Exists(this.localfile)){
                DateTime a = File.GetLastWriteTime(this.cachefile);
                DateTime b = File.GetLastWriteTime(this.localfile);
                if(b.ToFileTime() < a.ToFileTime())
                {
                    File.Delete(this.localfile);
                    this.change = true;
                }
            }
        }
        public void reLoad()
        {
            this.data.Clear();
            File.Delete(this.localfile);
            this.load();
        }

        public void load()
        {
            if(this.data.Count > 0)
            {
                return;
            }
            this.createCache();
            string[] lines = new string[]{};
            if(File.Exists(this.localfile))
            {
                lines = File.ReadAllLines(this.localfile);
            }
            if(lines.Length == 0){
                lines = File.ReadAllLines(this.cachefile);
            }
            if(lines.Length == 0)
            {
                throw new NotDataException();
            }
            this.data = new List<string>(lines);
            this.sync();
        }
    
        public string get()
        {
            return this.get(1)[0];
        }
        public List<string> get(int limit)
        {
            lock(this)
            {
                this.change = true;
                return this._get(limit);
            }
        }
        
        private List<string> _get(int limit)
        {
            if(limit <= 0)
            {
                return null;
            }
            List<string> list = new List<string>();
            for(int i = 0; i < limit; i++)
            {
                if(this.data.Count == 0)
                    break;
                int index = 0;
                if (!this.order)
                {
                    index = rnd.Next(this.data.Count);
                }
                list.Add(this.data[index].Trim());
                this.data.RemoveAt(index);
            }
            if(list.Count == 0)
            {
                if (this.once)
                {
                    throw new NotDataException();
                }
                this.sync();
                this.load();
                return this._get(limit);
            }
            return list;
        }

        public void append(string item)
        {
            if (!this.data.Contains(item))
            {
                this.data.Add(item);
                this.change = true;
            }
        }
        public void clear()
        {
            this.data.Clear();
        }

        public void clear(string[] items)
        {
            foreach (string item in items)
            {
                this.clear(item);
            }
            this.sync();
        }

        public void clear(string item)
        {
            if (this.data.Contains(item))
            {
                this.data.Remove(item);
                this.change = true;
            }
        }

        public void clear(Dictionary<string, bool>.KeyCollection items)
        {
            foreach (string item in items)
            {
                this.clear(item);
            }
            this.sync();
        }

        public void sync()
        {
            if(this.change)
            {
                lock(this){
                    File.WriteAllLines(this.localfile, this.data.ToArray());
                }
            }
        }

        public int Count
        {
            get{
                return this.data.Count;
            }
        }

    }
}
