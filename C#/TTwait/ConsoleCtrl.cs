using System;
using System.Collections.Generic;
using System.Text;
using System.Runtime.InteropServices;

namespace TTwait
{
    /// <summary>
    /// Class to catch console control events (ie CTRL-C) in C#. 
    /// Calls SetConsoleCtrlHandler() in Win32 API
    /// </summary>
    public class ConsoleCtrl : IDisposable
    {
        /// <summary>
        /// The event that occurred. 
        /// </summary>
        public enum ConsoleEvent
        {
            CtrlC = 0, CtrlBreak = 1, CtrlClose = 2, CtrlLogoff = 5, CtrlShutdown = 6
        }

        /// <summary>
        /// Handler to be called when a console event occurs.
        /// </summary>
        public delegate void ControlEventHandler(ConsoleEvent consoleEvent);

        /// <summary>
        /// Event fired when a console event occurs
        /// </summary>
        public event ControlEventHandler ControlEvent; ControlEventHandler eventHandler;

        public ConsoleCtrl()
        {
            // save this to a private var so the GC doesn't collect it...
            eventHandler = new ControlEventHandler(Handler);
            SetConsoleCtrlHandler(eventHandler, true);
        }

        public void Dispose()
        {
            Dispose(true);
            GC.SuppressFinalize(this);
        }
        void Dispose(bool disposing)
        {
            if (eventHandler != null)
            {
                SetConsoleCtrlHandler(eventHandler, false);
                eventHandler = null;
            }
        }

        private void Handler(ConsoleEvent consoleEvent)
        {
            if (ControlEvent != null)
                ControlEvent(consoleEvent);
        }

        [DllImport("kernel32.dll")]
        static extern bool SetConsoleCtrlHandler(ControlEventHandler e, bool add);
    }

}
