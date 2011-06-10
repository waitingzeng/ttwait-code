using System;
using System.Collections.Generic;
using System.Text;

namespace TTwait
{
	public class Code
	{
		public static string ReadHdId()
		{
			String HDid = "";
			System.Management.ManagementClass cimobject = new System.Management.ManagementClass("Win32_PhysicalMedia");
			System.Management.ManagementObjectCollection moc = cimobject.GetInstances();
			foreach (System.Management.ManagementObject mo in moc)
			{
				HDid += (string)mo.Properties["SerialNumber"].Value;
			}
			return HDid.Trim();
		}

		public static string Encode(string hdid)
		{
			string en = "";
			int ln = hdid.Length;
			for(int i=0;i<ln;i++)
			{
				char a = hdid[i];
				int aa = (int)a * (int)a;
				en += aa.ToString();
			}
			for (int i = 0; i < ln; i++)
			{
				char a = hdid[i];
				int aa = (int)a * 7;
				en += aa.ToString();
			}
			return en;
		}
	}
}
