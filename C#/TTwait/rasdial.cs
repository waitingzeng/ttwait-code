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
            if (s.Contains("���������"))
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
            // ��ñ���������IP��ַ
            IPAddress[] addrs = Dns.GetHostAddresses(Dns.GetHostName());
            return addrs[addrs.Length - 1].ToString();
        }

        public static string Execute(string dosCommand, int milliseconds)
        {
            string output = "";     //����ַ���
            if (dosCommand != null && dosCommand != "")
            {
                Process process = new Process();     //�������̶���
                ProcessStartInfo startInfo = new ProcessStartInfo();
                startInfo.FileName = "cmd.exe";      //�趨��Ҫִ�е�����
                startInfo.Arguments = "/C " + dosCommand;   //�趨���������еġ�/C����ʾִ��������������˳�
                startInfo.UseShellExecute = false;     //��ʹ��ϵͳ��ǳ�������
                startInfo.RedirectStandardInput = false;   //���ض�������
                startInfo.RedirectStandardOutput = true;   //�ض������
                startInfo.CreateNoWindow = true;     //����������
                process.StartInfo = startInfo;
                try
                {
                    if (process.Start())       //��ʼ����
                    {
                        if (milliseconds == 0)
                            process.WaitForExit();     //�������޵ȴ����̽���
                        else
                            process.WaitForExit(milliseconds);  //����ȴ����̽������ȴ�ʱ��Ϊָ���ĺ���
                        output = process.StandardOutput.ReadToEnd();//��ȡ���̵����
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
