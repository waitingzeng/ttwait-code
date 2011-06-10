using System;
using System.IO;
using System.Drawing;
using System.Windows.Forms;
using mshtml;
using System.Collections.Generic;
namespace TTwait
{
	public class OCR
	{
		/// <summary> 
		/// 将一个int值存入到4个字节的字节数组(从高地址开始转换，最高地址的值以无符号整型参与"与运算") 
		/// </summary> 
		/// <param name="thevalue">要处理的int值</param> 
		/// <param name="thebuff">存放信息的字符数组</param> 
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
		/// <summary> 
		/// 将一个ushort值存入到2个字节的字节数组(从高地址开始转换，最高地址的值以无符号整型参与"与运算") 
		/// </summary> 
		/// <param name="thevalue">要处理的ushort值</param> 
		/// <param name="thebuff">存放信息的字符数组</param> 
		public static void GetBytesFromuShort(ushort thevalue, byte[] thebuff)
		{
			ushort v1 = 0; ushort v2 = 0;
			ushort b1 = (ushort)65280; ushort b2 = (ushort)255;
			v1 = (ushort)(thevalue & b1);
			v2 = (ushort)(thevalue & b2);
			thebuff[0] = (byte)(v1 >> 8);
			thebuff[1] = (byte)(v2);
		}
		/// <summary> 
		/// 将4个字节的字节数组转换成一个int值 
		/// </summary> 
		/// <param name="thebuff">字符数组</param> 
		/// <returns></returns> 
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
		/// <summary> 
		/// 将2个字节的字节数组转换成一个ushort值 
		/// </summary> 
		/// <param name="thebuff">字符数组</param> 
		/// <returns></returns> 
		public static ushort GetUshortFromByte(byte[] thebuff)
		{
			int jieguo1 = 0;
			jieguo1 = (thebuff[0] << 8) + thebuff[1];
			ushort jieguo = (ushort)jieguo1;
			return jieguo;
		}
		/// <summary> 
		/// 将内存中的数据写入硬盘（保存特征库） 
		/// </summary> 
		/// <param name="thefile">保存的位置</param> 
		public static void WriteToFile(string thefile)
		{
			FileStream fs = new FileStream(thefile, FileMode.OpenOrCreate, FileAccess.ReadWrite);
			byte[] buff0 = new byte[4];
			GetBytesFromInt(dataNum, buff0);
			fs.Write(buff0, 0, 4);
			for (int ii = 0; ii < dataNum; ii++)
			{
				for (int jj = 0; jj < imageHeight; jj++)
				{
					byte[] buff = new byte[4];
					GetBytesFromInt(dataP[ii, jj], buff);
					fs.Write(buff, 0, 4);
				}
				fs.WriteByte(dataXY[ii, 0]);
				fs.WriteByte(dataXY[ii, 1]);
				fs.WriteByte(dataChar[ii]);
			}
			fs.Close();
		}
		public static void WriteToFile()
		{
			WriteToFile(dataFile);
		}

		/// <summary> 
		/// 从文件中读取信息，并保存在内存中相应的位置 
		/// </summary> 
		/// <param name="thefile">特征库文件</param> 
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
				for (int ii = 0; ii < allnum; ii++)
				{
					for (int jj = 0; jj < imageHeight; jj++)
					{
						fs.Read(buff0, 0, 4);
						dataP[ii, jj] = GetIntFromByte(buff0);
					}
					fs.Read(buff0, 0, 1);
					dataXY[ii, 0] = buff0[0];
					fs.Read(buff0, 0, 1);
					dataXY[ii, 1] = buff0[0];
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

		public static Image GetImage(WebBrowser wbMail, string ImgName, string Src, string Alt)
		{
			HTMLDocument doc = (HTMLDocument)wbMail.Document.DomDocument;
			HTMLBody body = (HTMLBody)doc.body;
			IHTMLControlRange rang = (IHTMLControlRange)body.createControlRange();
			IHTMLControlElement Img;

			if (ImgName == "") //如果没有图片的名字,通过Src或Alt中的关键字来取
			{
				int ImgNum = GetPicIndex(wbMail, Src, Alt);
				if (ImgNum == -1) return null;
				Img = (IHTMLControlElement)wbMail.Document.Images[ImgNum].DomElement;
			}
			else
				Img = (IHTMLControlElement)wbMail.Document.All[ImgName].DomElement;


			rang.add(Img);
			rang.execCommand("Copy", false, null);
			Image RegImg = Clipboard.GetImage();
			Clipboard.Clear();
			return RegImg;
		}

		private static int GetPicIndex(WebBrowser wbMail, string Src, string Alt)
		{
			int imgnum = -1;
			for (int i = 0; i < wbMail.Document.Images.Count; i++)　//获取所有的Image元素
			{
				IHTMLImgElement img = (IHTMLImgElement)wbMail.Document.Images[i].DomElement;
				if (Alt == "")
				{
					if (img.src.Contains(Src)) return i;
				}
				else
				{
					if (!string.IsNullOrEmpty(img.alt))
					{
						if (img.alt.Contains(Alt)) return i;
					}
				}
			}
			return imgnum;
		}


		public static int Study(Bitmap pic, string code)
		{
			OCR ocr = new OCR(pic);
			ocr.WriteToData(code);
			return dataNum;
		}

		public static int Study(Image pic, string code)
		{
			return Study((Bitmap)pic, code);
		}

		public static string VeryFy(Bitmap pic)
		{
			OCR ocr = new OCR(pic);
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

		public static string VeryFy(WebBrowser wbMail, string ImgName, string Src, string Alt)
		{
			return VeryFy(GetImage(wbMail, ImgName, Src, Alt));
		}
		public static string VeryFy(WebBrowser wbMail, string ImgName)
		{
			return VeryFy(GetImage(wbMail, ImgName, "", ""));
		}
		/// <summary> 
		/// 特征库的长度 
		/// </summary> 
		public static int dataNum = 0;

		/// <summary>
		/// 验证码图片宽度
		/// </summary>
		public static int imageWidth = 40;

		/// <summary>
		/// 验证码图片高度
		/// </summary>
		private static int _imageHeight = 10;

		public static int imageHeight
		{
			get { return OCR._imageHeight; }
			set
			{
				OCR._imageHeight = value;
				dataP = new int[100000, _imageHeight];
			}
		}

		/// <summary> 
		/// 特征库数据 
		/// </summary> 
		public static int[,] dataP = new int[100000, imageHeight];
		/// <summary> 
		/// 长度与高度 
		/// </summary> 
		public static byte[,] dataXY = new byte[100000, 2];
		/// <summary> 
		/// 对应的字符 
		/// </summary> 
		public static byte[] dataChar = new byte[100000];


		public static int exact = 4;
		

		/// <summary>
		/// 验证码字符数量
		/// </summary>
		public static int imageCount = 4;

		public static string dataFile = "venshop.dat";

		public OCR(Bitmap pic)
		{
			init(pic);
		}

		public OCR(Image pic)
		{
			init((Bitmap)pic);
		}
		private void init(Bitmap pic)
		{
			this.bp = ImageEffect.Gray(pic);

			for (int ii = 0; ii < imageWidth; ii++)
			{
				for (int jj = 0; jj < imageHeight; jj++)
				{
					if (bp.GetPixel(ii, jj).ToArgb() == Color.Black.ToArgb())
					{
						picPixel[ii, jj] = true;
					}
				}
			}
			
			int indexnum = 0;
			bool black = false;
			for (int ii = 0; ii < imageWidth; ii++)
			{
				if (indexnum >= imageCount*2)
					return;
				bool haveblack = false;
				for (int jj = 0; jj < imageHeight; jj++)
				{
					if (picPixel[ii, jj])
					{
						haveblack = true;
						break;
					}
				}
				if (haveblack && black == false)
				{
					index[indexnum] = ii;
					indexnum++;
					black = true;
				}
				if (!haveblack && black)
				{
					index[indexnum] = ii;
					indexnum++;
					black = false;
				}
			}
			if (indexnum < imageCount * 2 - 1)
			{
				return;
			}
			if (indexnum == imageCount * 2 - 1)
			{
				index[imageCount * 2 - 1] = imageWidth;
			}
			
		}

		/// <summary> 
		/// 验证码图片 
		/// </summary> 
		private Bitmap bp = new Bitmap(imageWidth, imageHeight);
		
		/// <summary> 
		/// 等待处理的数据 
		/// </summary> 
		private int[] datapic = new int[imageHeight];
		/// <summary> 
		/// 有效长度 
		/// </summary> 
		private byte xlpic = 0;
		/// <summary> 
		/// 有效宽度 
		/// </summary> 
		private byte ylpic = 0;

		/// <summary>
		/// 某个位置是否黑色的数组
		/// </summary>
		private bool[,] picPixel = new bool[imageWidth, imageHeight];

		/// <summary>
		/// 各字符边缘X坐标数组
		/// </summary>
		private int[] index = new int[imageCount * 2];

		/// <summary>
		/// 特征值
		/// </summary>
		private static int[] addin = new int[32];

		static OCR()
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
			//如果查找不到，就返回空串
			string jieguo = "";
			for (int ii = 0; ii < dataNum; ii++)
			{
				//统计一共有多少行的像素有差异，如果在4行以内就认为是存在该记录 
				//这种方法比较原始，但比较适合多线程时的运行，因为程序只进行简单的逻辑比较 
				//如果能够收集更多的特征库，识别率可以达到80％以上 
				//（此时可能需要将特征库的容量提高到15w个或以上） 
				//当然也可以改进品配算法（如使用关键点品配），以用较少的特征库达到较高的识别率，但 
				//那样有比较大的机会造成识别错误并且多线程时占用较多cpu时间。 
				int notsamenum = 0;
				if (dataXY[ii, 0] != xlpic || dataXY[ii, 1] != ylpic)
				{
					continue;
				}
				for (int jj = 0; jj < imageHeight; jj++)
				{
					if (dataP[ii, jj] != datapic[jj])
					{
						notsamenum++;
					}
				}
				if (notsamenum < OCR.exact)
				{
					char cj = (char)dataChar[ii];
					return cj.ToString();
				}
			}
			return jieguo;
		}
		/// <summary> 
		/// 检查特征库中是否已经存在相关记录 
		/// </summary> 
		private int IsCharDataIn()
		{
			for (int ii = 0; ii < dataNum; ii++)
			{
				//统计一共有多少行的像素有差异，如果在4行以内就认为是存在该记录 
				//这种方法比较原始，但比较适合多线程时的运行，因为程序只进行简单的逻辑比较 
				//如果能够收集更多的特征库，识别率可以达到80％以上 
				//（此时可能需要将特征库的容量提高到15w个或以上） 
				//当然也可以改进品配算法（如使用关键点品配），以用较少的特征库达到较高的识别率，但 
				//那样有比较大的机会造成识别错误并且多线程时占用较多cpu时间。 
				int notsamenum = 0;
				if (Math.Abs(dataXY[ii, 0] - xlpic) > 1 || Math.Abs(dataXY[ii, 1] - ylpic) > 1)
				{
					continue;
				}
				for (int jj = 0; jj < imageHeight; jj++)
				{
					if (dataP[ii, jj] != datapic[jj])
					{
						notsamenum++;
					}
				}
				if (notsamenum < OCR.exact)
				{
					return ii;
				}
			}
			return -1;
		}
		/// <summary> 
		/// 添加到特征库中，并暂时将对应的字符置为空格以待人工识别 
		/// </summary> 
		private void AddDataWithChar(Byte b)
		{
			int i = this.IsCharDataIn();
			if (i >= 0)
			{
				dataChar[i] = b;
				return;
			}
			else
			{
				for (int ii = 0; ii < imageHeight; ii++)
				{
					dataP[dataNum, ii] = this.datapic[ii];
				}
				//暂时将对应的字符置为空格以待人工识别 
				dataChar[dataNum] = b;
				dataXY[dataNum, 0] = this.xlpic;
				dataXY[dataNum, 1] = this.ylpic;
				dataNum++;
			}
		}
		private void AddDataWithNullChar()
		{
			AddDataWithChar((Byte)32);
		}

		/// <summary> 
		/// 检查验证码图片是否能分成4个部分，如果可以就检查4个字符在特征库中是否已经存在，如果不存在， 
		/// 就添加到特征库中，并暂时将对应的字符置为空格以待人工识别 
		/// </summary> 
		public void WriteToData(string code)
		{
			char[] codeArray = code.ToCharArray();
			if (codeArray.Length != imageCount)
			{
				return;
			}
			
			for (int ii = 0; ii < imageCount; ii++)
			{
				if (GetDataPic(ii))
				{
					this.AddDataWithChar((Byte)codeArray[ii]);
				}
			}
			//**** 
		}
		/// <summary> 
		/// 识别图片 
		/// </summary> 
		/// <returns>返回识别结果(如果返回的字符串长度小于4就说明识别失败)</returns> 
		public string OCRPic()
		{
			string jieguo = "";
			for (int ii = 0; ii < imageCount; ii++)
			{
				if (GetDataPic(ii))
				{
					jieguo = jieguo + this.GetChar();
				}
			}
			return jieguo;
		}
		private bool GetDataPic(int ii)
		{
			if (ii < 0 || ii >= imageCount)
				return false;
			int x1 = index[ii * 2];
			int x2 = index[ii * 2 + 1];
			int y1 = 0, y2 = imageHeight - 1;
			bool mb = false;
			for (int jj = 0; jj < imageHeight; jj++)
			{
				for (int kk = x1; kk < x2; kk++)
				{
					if (picPixel[kk, jj])
					{
						mb = true;
						break;
					}
				}
				if (mb)
				{
					y1 = jj;
					break;
				}
			}
			mb = false;
			for (int jj = imageHeight - 1; jj >= 0; jj--)
			{
				for (int kk = x1; kk < x2; kk++)
				{
					if (picPixel[kk, jj])
					{
						mb = true;
						break;
					}
				}
				if (mb)
				{
					y2 = jj;
					break;
				}
			}
			//**以上是获取有效区域的范围 
			for (int jj = 0; jj < imageHeight; jj++)
			{
				this.datapic[jj] = 0;
			}
			this.xlpic = (byte)(x2 - x1);
			//如果字符宽度超过16个像素就不予处理 
			if (xlpic > 16)
			{
				return false;
			}
			this.ylpic = (byte)(y2 - y1 + 1);
			int ys = -1;
			for (int jj = y1; jj <= y2; jj++)
			{
				ys++;
				int xs = -1;
				for (int kk = x1; kk < x2; kk++)
				{
					xs++;
					if (picPixel[kk, jj])
					{
						this.datapic[ys] = (ushort)(this.datapic[ys] + addin[xs]);
					}
				}
			}
			return true;
		}
	}
}
