using System;
using System.Collections.Generic;
using System.Text;
using System.Diagnostics;
using System.Security.Permissions;
using System.IO;

namespace MSNSend
{
    class TextTrace
    {
    }

    
    [HostProtection(SecurityAction.LinkDemand, Synchronization = true)]
    public class FileTraceListener : TraceListener
    {
        // Fields
        private StreamWriter writer = null;
        private object syncObject = new object();
        private bool stop = false;

        // Methods
        public FileTraceListener()
            : base()
        {
        }

        public FileTraceListener(string filename)
            : base(string.Empty)
        {
            writer = new StreamWriter(filename);
        }


        public override void Close()
        {
            if (this.writer != null)
            {
                this.writer.Close();
            }
            this.writer = null;
            this.stop = true;
        }

        private bool EnsureWriter()
        {
            lock (syncObject)
            {
                if (writer == null || stop == true) return false;
                return true;
            }
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                this.Close();
            }
        }

        public override void Flush()
        {
            if (!EnsureWriter()) return;
            this.writer.Flush();
        }

        private static Encoding GetEncodingWithFallback(Encoding encoding)
        {
            Encoding encoding2 = (Encoding)encoding.Clone();
            encoding2.EncoderFallback = EncoderFallback.ReplacementFallback;
            encoding2.DecoderFallback = DecoderFallback.ReplacementFallback;
            return encoding2;
        }

        public override void Write(string message)
        {
            if (!EnsureWriter()) return;
            if (base.NeedIndent)
            {
                this.WriteIndent();
            }
            this.writer.Write("[" + DateTime.Now.ToString("u") + "] " + message);
            this.writer.Flush();
        }

        public override void WriteLine(string message)
        {
            if (!EnsureWriter()) return;
            if (base.NeedIndent)
            {
                this.WriteIndent();
            }
            this.writer.WriteLine("[" + DateTime.Now.ToString("u") + "] " + message);
            this.writer.Flush();
            base.NeedIndent = true;
        }

        public void Stop()
        {
            lock (syncObject)
            {
                stop = true;
            }
        }

        public void Resume()
        {
            lock (syncObject)
            {
                stop = false;
            }
        }

        // Properties
        public StreamWriter Writer
        {
            get
            {
                return this.writer;
            }
            set
            {
                this.writer = value;
            }
        }
    }
}
