using System;
using System.IO;
using System.Drawing;
using System.Windows.Forms;
using mshtml;
using System.Collections.Generic;
namespace TTwait
{
	public class OCR2
	{

		public static void GetBytesFromInt(int thevalue, byte[] thebuff)
		{
			long v1 = 0; long v2 = 0; long v3 = 0; long v4 = 0;
			uint b1 = (uint)4278190080; uint b2 = (uint)16711680; uint b3 = (uint)65280; uint b4 = (uint)255;
			v1 = thevalue & b1;
			v2 = thevalue & b2;
			v3 = thevalue & b3;
			v4 = thevalue & b4;
			thebuff[0] = (byte)(v1 >> 24);
			thebuff[1] = (byte)(v2 >> 16);
			thebuff[2] = (byte)(v3 >> 8);
			thebuff[3] = (byte)v4;
		}
		
		public static int GetIntFromByte(byte[] thebuff)
		{
			int jieguo = 0;
			long mid = 0;
			long m1 = 0; long m2 = 0; long m3 = 0; long m4 = 0;
			m1 = (thebuff[0] << 24);
			m2 = (thebuff[1] << 16);
			m3 = (thebuff[2] << 8);
			m4 = thebuff[3];
			mid = m1 + m2 + m3 + m4;
			jieguo = (int)mid;
			return jieguo;
		}
		
		public static void WriteToFile(string thefile)
		{
			FileStream fs = new FileStream(thefile, FileMode.OpenOrCreate, FileAccess.ReadWrite);
			byte[] buff0 = new byte[4];
			GetBytesFromInt(dataNum, buff0);
			fs.Write(buff0, 0, 4);
			int imageHeight = dataP.GetUpperBound(1);
			for (int ii = 0; ii < dataNum; ii++)
			{
				for (int jj = 0; jj < imageHeight; jj++)
				{
					byte[] buff = new byte[4];
					GetBytesFromInt(dataP[ii, jj], buff);
					fs.Write(buff, 0, 4);
				}
				fs.WriteByte(dataChar[ii]);
			}
			fs.Close();
		}
		public static void WriteToFile()
		{
			WriteToFile(dataFile);
		}

		public static void ReadFromFile(string thefile)
		{
			if (File.Exists(thefile))
			{
				int allnum = 0;
				byte[] buff = new byte[4];
				FileStream fs = new FileStream(thefile, FileMode.Open, FileAccess.Read);
				fs.Read(buff, 0, 4);
				if (buff.Length == 0)
				{
					allnum = 0;
				}
				else
				{
					allnum = GetIntFromByte(buff);
				}
				byte[] buff0 = new byte[4];
			    int imageHeight = dataP.GetUpperBound(1);
				for (int ii = 0; ii < allnum; ii++)
				{
					for (int jj = 0; jj < imageHeight; jj++)
					{
						fs.Read(buff0, 0, 4);
						dataP[ii, jj] = GetIntFromByte(buff0);
					}
					fs.Read(buff0, 0, 1);
					dataChar[ii] = buff0[0];
				}
				dataNum = allnum;
				fs.Close();
			}
		}

		public static void ReadFromFile()
		{
			ReadFromFile(dataFile);
		}

		public static string VeryFy(Bitmap pic)
		{
			OCR2 ocr = new OCR2(pic);
			string s = ocr.OCRPic();
			if (s == "")
			{
				s = " ";
			}
			return s;
		}

		public static string VeryFy(Image pic)
		{
			return VeryFy((Bitmap)pic);
		}

		/// <summary> 
		/// 特征库的长度 
		/// </summary> 
		public static int dataNum = 0;

		/// <summary> 
		/// 特征库数据 
		/// </summary> 
		public static int[,] dataP = null;
		
		/// <summary> 
		/// 对应的字符 
		/// </summary> 
		public static byte[] dataChar = new byte[100000];

		public static int exact = 4;
		

		public static string dataFile = "venshop.dat";

		public OCR2(Bitmap pic)
		{
			init(pic);
		}

		public OCR2(Image pic)
		{
			init((Bitmap)pic);
		}
		private void init(Bitmap pic)
		{
			this.bp = ImageEffect.Gray(pic);

			if (OCR2.dataP == null)
			{
				OCR2.dataP = new int[10000, bp.Height];
			}
			datapic = new int[bp.Height];
			picPixel = new bool[bp.Width, bp.Height];
			for (int ii = 0; ii < bp.Width; ii++)
			{
				for (int jj = 0; jj < bp.Height; jj++)
				{
					if (bp.GetPixel(ii, jj).ToArgb() == Color.Black.ToArgb())
					{
						picPixel[ii, jj] = true;
					}
				}
			}
		}

		/// <summary> 
		/// 验证码图片 
		/// </summary> 
		private Bitmap bp = null;
		
		/// <summary> 
		/// 等待处理的数据 
		/// </summary> 
		private int[] datapic = null;

		/// <summary>
		/// 某个位置是否黑色的数组
		/// </summary>
		private bool[,] picPixel = null;

		/// <summary>
		/// 特征值
		/// </summary>
		private static int[] addin = new int[32];

		static OCR2()
		{
			for (int i = 0; i < 32; i++)
			{
				addin[i] = (int)Math.Pow(2, i);
			}
		}
		/// <summary> 
		/// 检索特征库中存在的记录 
		/// </summary> 
		private string GetChar()
		{
			string jieguo = "";
			int miniNotSameNum = 100;
			int miniIndex = -1;
			for (int ii = 0; ii < dataNum; ii++)
			{
				int notsamenum = 0;
				for (int jj = 0; jj < bp.Height; jj++)
				{
					if (dataP[ii, jj] != datapic[jj])
					{
						notsamenum++;
					}
				}
				if (notsamenum < miniNotSameNum)
				{
					miniNotSameNum = notsamenum;
					miniIndex = ii;
				}
			}
			if (miniIndex >= 0)
			{
				char cj = (char)dataChar[miniIndex];
				return cj.ToString();
			}
			return " ";
		}
	
		public string OCRPic()
		{
			GetDataPic();
			return this.GetChar();
		}

		private bool GetDataPic()
		{
			for (int jj = 0; jj < bp.Height; jj++)
			{
				this.datapic[jj] = 0;
			}

			for (int jj = 0; jj < bp.Height; jj++)
			{
				for (int kk = 0; kk < bp.Width; kk++)
				{
					if (picPixel[kk, jj])
					{
						this.datapic[jj] = this.datapic[jj] + addin[kk];
					}
				}
			}
			return true;
		}

		private static string GetFileName(string file)
		{
			int index = file.LastIndexOf("\\");
			return file.Substring(index + 1, 1);
		}

		public static void GenData(string path)
		{
			string[] files = Directory.GetFiles(path, "*.bmp");
			for (int i = 0; i < files.Length;i++ )
			{
				string file = files[i];
				string c = GetFileName(file);
				Bitmap bp = (Bitmap)Bitmap.FromFile(file);
				OCR2 ocr = new OCR2(bp);
				ocr.GetDataPic();
				dataChar[i] = (byte)c[0];
				for (int j = 0; j < bp.Height; j++)
				{
					dataP[i, j] = ocr.datapic[j];
				}
				dataNum++;
			}
			//WriteToFile();
		}
	}
}
