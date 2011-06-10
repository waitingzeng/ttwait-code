using System;
using System.Collections.Generic;
using System.Text;
using System.Net;
using System.IO;
using System.Drawing;
using System.Web;
using System.Net.Security;
using System.Security.Authentication;
using System.Security.Cryptography.X509Certificates;
namespace TTwait
{
	public class SingleWeb
	{
		public CookieContainer cookies = new CookieContainer();
        public HttpWebResponse res = null;
		public string GetPage(String url, Encoding encode)
		{
            return GetPage(url, "", encode);
		}

		public static string UrlEncode(string data)
		{
			return HttpUtility.UrlEncode(data);
		}

		public static string UrlDecode(string data)
		{
			return HttpUtility.UrlDecode(data);
		}
		public string GetPage(string url, string data, Encoding encode)
		{
            string strResult = "";
            Stream s = getStream(url, encode.GetBytes(data));
            if (s != null)
            {
                StreamReader sr = new StreamReader(s, encode);
                strResult = sr.ReadToEnd();
            }
            return strResult;
		}

        private Stream getStream(string url, byte[] data)
        {
            res = null;
            
            try
            {
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "GET";
                req.KeepAlive = true;
                req.AllowAutoRedirect = true;
                req.Accept = "*/*";
                req.UserAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";
                if (cookies != null)
                {
                    req.CookieContainer = cookies;
                }
                if (data !=null && data.Length > 0)
                {
                    req.ContentType = "application/x-www-form-urlencoded";
                    req.Method = "POST";
                    Stream reqStream = req.GetRequestStream();
                    if (reqStream.CanWrite)
                    {
                        reqStream.Write(data, 0, data.Length);
                    }
                    reqStream.Close();
                }
                res = (HttpWebResponse)req.GetResponse();
                Stream ReceiveStream = res.GetResponseStream();
                return ReceiveStream;
            }
            catch (Exception e)
            {
                ;
            }
            return null;
        }
        private Stream getStream(string url)
        {
            return getStream(url, null);
        }

		public string GetPage(String url)
		{
            return this.GetPage(url, Encoding.UTF8);
		}

        public string GetPage(String url, string data)
        {
            return this.GetPage(url, data, Encoding.UTF8);
        }

		public string UploadFile(string address, string method, string formname, string fileName)
		{
			string text1;
			string text2;
			HttpWebRequest request1;
			string text3;
			byte[] buffer1;
			byte[] buffer2;
			long num1;
			byte[] buffer3;
			int num2;
			HttpWebResponse response1;
			byte[] buffer4;
			DateTime time1;
			long num3;
			string[] textArray1;
			FileStream stream1 = null;
			try
			{
				fileName = Path.GetFullPath(fileName).ToLower();
				time1 = DateTime.Now;
				num3 = time1.Ticks;
				text1 = "---------------------" + num3.ToString("x");
				text2 = "application/octet-stream";
				if (fileName.EndsWith(".jpg"))
				{
					text2 = "image/jpeg";
				}
				else if (fileName.EndsWith(".gif"))
				{
					text2 = "image/gif";
				}
				request1 = (HttpWebRequest)WebRequest.Create(address);
				request1.ContentType = "multipart/form-data; boundary=" + text1;
				request1.Method = method;
				request1.CookieContainer = cookies;
				stream1 = new FileStream(fileName, FileMode.Open, FileAccess.Read);


				textArray1 = new string[7];
				textArray1[0] = "--";
				textArray1[1] = text1;
				textArray1[2] = "\r\nContent-Disposition: form-data; name=\"" + formname + "\"; filename=\"";
				textArray1[3] = Path.GetFileName(fileName);
				textArray1[4] = "\"\r\nContent-Type: ";
				textArray1[5] = text2;
				textArray1[6] = "\r\n\r\n";
				text3 = string.Concat(textArray1);
				buffer1 = Encoding.UTF8.GetBytes(text3);
				buffer2 = Encoding.ASCII.GetBytes("\r\n--" + text1 + "\r\n");
				num1 = 9223372036854775807;
				try
				{
					num1 = stream1.Length;
					request1.ContentLength = ((num1 + ((long)buffer1.Length)) + ((long)buffer2.Length));
				}
				catch
				{
				}
				buffer3 = new byte[Math.Min(((int)8192), ((int)num1))];
				using (Stream stream2 = request1.GetRequestStream())
				{
					stream2.Write(buffer1, 0, buffer1.Length);
					do
					{
						num2 = stream1.Read(buffer3, 0, buffer3.Length);
						if (num2 != 0)
						{
							stream2.Write(buffer3, 0, num2);
						}
					}
					while ((num2 != 0));
					stream2.Write(buffer2, 0, buffer2.Length);
				}
				stream1.Close();
				stream1 = null;
				response1 = (HttpWebResponse)request1.GetResponse();
				StreamReader sr = new StreamReader(response1.GetResponseStream());
				return sr.ReadToEnd();
			}
			catch (Exception exception1)
			{
				if (stream1 != null)
				{
					stream1.Close();
					stream1 = null;
				}
				Console.WriteLine(exception1.Message);
			}
			return "";
		}


		public Image getImage(string url)
		{
            Stream s = getStream(url);
            if (s != null)
            {
                return Image.FromStream(s);
            }
            return null;
		}


	}
}
