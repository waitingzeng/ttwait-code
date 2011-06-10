using System;
using System.Collections.Generic;
using System.Text;
using System.Collections;
using System.IO;

namespace MSNSend
{
    public class Exclude : IDisposable
    {
        string filename = null;
        StreamWriter f = null;
        bool effect = false;
        Dictionary<string, bool> table = new Dictionary<string,bool>();

        public Exclude(string name, bool effect)
        {
            this.filename = name;
            this.effect = effect;
            if (effect)
            {
                //this.load();
                //f = new StreamWriter(File.Open(this.filename, FileMode.Append | FileMode.Create));
            }
        }

        public void load()
        {
            if(!File.Exists(this.filename))
                return;
            /*StreamReader sr = File.OpenText(this.filename);
            while (!sr.EndOfStream)
            {
                table[sr.ReadLine().Trim()] = null;
            }
            sr.Close();*/
        }

        public void Dispose()
        {
            table.Clear();
            //f.Close();
        }

        public void Add(long line)
        {
            if (this.effect)
            {
                lock (this)
                {
                    try
                    {
                        //f.WriteLine(line);
                    }
                    catch { }
                }
            }
        }

        public void Flush()
        {
            if (this.effect)
            {
                //f.Flush();
            }
        }

        public bool ContainsKey(string key)
        {
            return this.effect && table.ContainsKey(key);
        }

        public void Clear()
        {
            this.table.Clear();
        }
    }
}
