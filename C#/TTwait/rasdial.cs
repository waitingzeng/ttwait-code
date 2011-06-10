using System;
using System.Collections.Generic;
using System.Text;
using System.Net;
using System.Diagnostics;
namespace TTwait
{
    public class Rasdial
    {
        string name;
        string account;
        string psw;
        string connCmd;
        string disconnCmd;
        List<string> iplist = new List<string>();
        string current = null;
        public string Current
        {
            get { return current; }
        }

        private bool distinct = true;

        public bool Distinct
        {
            get { return distinct; }
            set { distinct = value; }
        }
        

        public Rasdial(string name, string account, string psw)
        {
            this.name = name;
            this.account = account;
            this.psw = psw;
            this.connCmd = string.Format("rasdial {0} {1} {2}", name, account, psw);
            this.disconnCmd = string.Format("rasdial {0} /DISCONNECT", name);
        }
       

        public bool connect()
        {
            Rasdial.Execute(this.connCmd);
            string ip = Rasdial.getIPAddress();
            if (ip != current)
            {
                current = ip;
                return true;
            }
            else
            {
                return false;
            }
        }

        public bool disConnect()
        {
            string s = Rasdial.Execute(this.disconnCmd);
            if (s.Contains("命令已完成"))
                return true;
            else
                return false;
        }

        public bool changeIP()
        {
            while (true)
            {
                while (true)
                {
                    this.disConnect();
                    if (this.testdis())
                    {
                        break;
                    }
                }
                while (true)
                {
                    if (connect())
                    {
                        if (this.Distinct && iplist.Contains(current))
                        {
                            break;
                        }
                        else
                        {
                            if (this.Distinct)
                            {
                                iplist.Add(current);
                            }
                            return true;
                        }
                    }
                }
            }
        }

        public bool testdis()
        {
            string s = Rasdial.Execute("ipconfig /all");
            if (s.Contains(string.Format("PPP adapter {0}", this.name)))
                return false;
            return true;
        }

        public static string Execute(string dosCommand)
        {
            return Execute(dosCommand, 0);
        }

        public static string getIPAddress()
        {
            // 获得本机局域网IP地址
            IPAddress[] addrs = Dns.GetHostAddresses(Dns.GetHostName());
            return addrs[addrs.Length - 1].ToString();
        }

        public static string Execute(string dosCommand, int milliseconds)
        {
            string output = "";     //输出字符串
            if (dosCommand != null && dosCommand != "")
            {
                Process process = new Process();     //创建进程对象
                ProcessStartInfo startInfo = new ProcessStartInfo();
                startInfo.FileName = "cmd.exe";      //设定需要执行的命令
                startInfo.Arguments = "/C " + dosCommand;   //设定参数，其中的“/C”表示执行完命令后马上退出
                startInfo.UseShellExecute = false;     //不使用系统外壳程序启动
                startInfo.RedirectStandardInput = false;   //不重定向输入
                startInfo.RedirectStandardOutput = true;   //重定向输出
                startInfo.CreateNoWindow = true;     //不创建窗口
                process.StartInfo = startInfo;
                try
                {
                    if (process.Start())       //开始进程
                    {
                        if (milliseconds == 0)
                            process.WaitForExit();     //这里无限等待进程结束
                        else
                            process.WaitForExit(milliseconds);  //这里等待进程结束，等待时间为指定的毫秒
                        output = process.StandardOutput.ReadToEnd();//读取进程的输出
                    }
                }
                catch
                {
                }
                finally
                {
                    if (process != null)
                        process.Close();
                }
            }
            return output;
        }
    }
}
