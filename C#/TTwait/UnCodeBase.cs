using System;
using System.Collections.Generic;
using System.Text;
using System.Collections;
using System.Drawing;
using System.Drawing.Imaging;
using System.Runtime.InteropServices;
using System.IO;
namespace TTwait
{
    public class UnCodebase
    {
        public Bitmap bmpobj;
		private string codStr = "";
		private int[,] codData = new int[10000, 25];
        public UnCodebase(Bitmap pic)
        {
            bmpobj = new Bitmap(pic);
        }

		private byte[] GetBytesFromInt(int thevalue, byte[] thebuff)
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
			return thebuff;
		}

		private int GetIntFromByte(byte[] thebuff)
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

		public void Save(string thefile)
		{
			FileStream fs = new FileStream(thefile, FileMode.OpenOrCreate, FileAccess.ReadWrite);
			byte[] buff = new byte[4];
			GetBytesFromInt(codStr.Length, buff);
			fs.Write(buff,0,4);
			byte[] array = Encoding.Default.GetBytes(codStr);
			fs.Write(GetBytesFromInt(array.Length, buff), 0, 4);
			fs.Write(array, 0, array.Length);
			for (int i = 0; i < codStr.Length; i++)
			{
				for (int j = 0; j < 25; j++)
				{
					fs.Write(GetBytesFromInt(codData[i, j], buff), 0, 4);
				}
			}
		}

		public void Load(string thefile)
		{
			if (File.Exists(thefile))
			{
				FileStream fs = new FileStream(thefile, FileMode.Open, FileAccess.Read);
				byte[] buff = new byte[4];
				fs.Read(buff, 0, 4);
				int l = GetIntFromByte(buff);
				byte[] array = new byte[l];
				fs.Read(array, 0, l);
				codStr = Encoding.Default.GetString(array);
				for (int i = 0; i < codStr.Length; i++)
				{
					for (int j = 0; j < 25; j++)
					{
						fs.Read(buff, 0, 4);
						codData[i, j] = GetIntFromByte(buff);
					}
				}
			}
		}

        /// <summary>
        /// 平均分割图片
        /// </summary>
        /// <param name="RowNum">水平上分割数</param>
        /// <param name="ColNum">垂直上分割数</param>
        /// <returns>分割好的图片数组</returns>
        public virtual Bitmap [] GetSplitPics()
        {
			return new Bitmap[1];
        }


        public int[] GetSingleBmpData(Bitmap singlepic, int w, int h)
        {
			int col = singlepic.Width - 1 / w + 1;
			int row = singlepic.Height - 1 / h + 1;
			int[] a = new int[col * row];
			for (int i = 0; i < col; i++)
			{
				for (int j = 0; j < row; j++)
				{
					int t = 0;
					for (int x = i * w; x < w && x < singlepic.Width; x++)
					{
						for (int y = j * h; y < h && y < singlepic.Height; j++)
						{
							if (singlepic.GetPixel(x, j) == Color.Black)
							{
								t++;
							}
						}
					}
					a[i * row + j] = t;
				}
			}
			return a;
        }
		
		private void AddData(string code, int[] data)
		{

		}
	}

}
