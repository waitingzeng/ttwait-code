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
		/// ��һ��intֵ���뵽4���ֽڵ��ֽ�����(�Ӹߵ�ַ��ʼת������ߵ�ַ��ֵ���޷������Ͳ���"������") 
		/// </summary> 
		/// <param name="thevalue">Ҫ�����intֵ</param> 
		/// <param name="thebuff">�����Ϣ���ַ�����</param> 
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
		/// ��һ��ushortֵ���뵽2���ֽڵ��ֽ�����(�Ӹߵ�ַ��ʼת������ߵ�ַ��ֵ���޷������Ͳ���"������") 
		/// </summary> 
		/// <param name="thevalue">Ҫ�����ushortֵ</param> 
		/// <param name="thebuff">�����Ϣ���ַ�����</param> 
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
		/// ��4���ֽڵ��ֽ�����ת����һ��intֵ 
		/// </summary> 
		/// <param name="thebuff">�ַ�����</param> 
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
		/// ��2���ֽڵ��ֽ�����ת����һ��ushortֵ 
		/// </summary> 
		/// <param name="thebuff">�ַ�����</param> 
		/// <returns></returns> 
		public static ushort GetUshortFromByte(byte[] thebuff)
		{
			int jieguo1 = 0;
			jieguo1 = (thebuff[0] << 8) + thebuff[1];
			ushort jieguo = (ushort)jieguo1;
			return jieguo;
		}
		/// <summary> 
		/// ���ڴ��е�����д��Ӳ�̣����������⣩ 
		/// </summary> 
		/// <param name="thefile">�����λ��</param> 
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
		/// ���ļ��ж�ȡ��Ϣ�����������ڴ�����Ӧ��λ�� 
		/// </summary> 
		/// <param name="thefile">�������ļ�</param> 
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

			if (ImgName == "") //���û��ͼƬ������,ͨ��Src��Alt�еĹؼ�����ȡ
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
			for (int i = 0; i < wbMail.Document.Images.Count; i++)��//��ȡ���е�ImageԪ��
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
		/// ������ĳ��� 
		/// </summary> 
		public static int dataNum = 0;

		/// <summary>
		/// ��֤��ͼƬ���
		/// </summary>
		public static int imageWidth = 40;

		/// <summary>
		/// ��֤��ͼƬ�߶�
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
		/// ���������� 
		/// </summary> 
		public static int[,] dataP = new int[100000, imageHeight];
		/// <summary> 
		/// ������߶� 
		/// </summary> 
		public static byte[,] dataXY = new byte[100000, 2];
		/// <summary> 
		/// ��Ӧ���ַ� 
		/// </summary> 
		public static byte[] dataChar = new byte[100000];


		public static int exact = 4;
		

		/// <summary>
		/// ��֤���ַ�����
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
		/// ��֤��ͼƬ 
		/// </summary> 
		private Bitmap bp = new Bitmap(imageWidth, imageHeight);
		
		/// <summary> 
		/// �ȴ���������� 
		/// </summary> 
		private int[] datapic = new int[imageHeight];
		/// <summary> 
		/// ��Ч���� 
		/// </summary> 
		private byte xlpic = 0;
		/// <summary> 
		/// ��Ч��� 
		/// </summary> 
		private byte ylpic = 0;

		/// <summary>
		/// ĳ��λ���Ƿ��ɫ������
		/// </summary>
		private bool[,] picPixel = new bool[imageWidth, imageHeight];

		/// <summary>
		/// ���ַ���ԵX��������
		/// </summary>
		private int[] index = new int[imageCount * 2];

		/// <summary>
		/// ����ֵ
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
		/// �����������д��ڵļ�¼ 
		/// </summary> 
		private string GetChar()
		{
			//������Ҳ������ͷ��ؿմ�
			string jieguo = "";
			for (int ii = 0; ii < dataNum; ii++)
			{
				//ͳ��һ���ж����е������в��죬�����4�����ھ���Ϊ�Ǵ��ڸü�¼ 
				//���ַ����Ƚ�ԭʼ�����Ƚ��ʺ϶��߳�ʱ�����У���Ϊ����ֻ���м򵥵��߼��Ƚ� 
				//����ܹ��ռ�����������⣬ʶ���ʿ��Դﵽ80������ 
				//����ʱ������Ҫ���������������ߵ�15w�������ϣ� 
				//��ȻҲ���ԸĽ�Ʒ���㷨����ʹ�ùؼ���Ʒ�䣩�����ý��ٵ�������ﵽ�ϸߵ�ʶ���ʣ��� 
				//�����бȽϴ�Ļ������ʶ������Ҷ��߳�ʱռ�ý϶�cpuʱ�䡣 
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
		/// ������������Ƿ��Ѿ�������ؼ�¼ 
		/// </summary> 
		private int IsCharDataIn()
		{
			for (int ii = 0; ii < dataNum; ii++)
			{
				//ͳ��һ���ж����е������в��죬�����4�����ھ���Ϊ�Ǵ��ڸü�¼ 
				//���ַ����Ƚ�ԭʼ�����Ƚ��ʺ϶��߳�ʱ�����У���Ϊ����ֻ���м򵥵��߼��Ƚ� 
				//����ܹ��ռ�����������⣬ʶ���ʿ��Դﵽ80������ 
				//����ʱ������Ҫ���������������ߵ�15w�������ϣ� 
				//��ȻҲ���ԸĽ�Ʒ���㷨����ʹ�ùؼ���Ʒ�䣩�����ý��ٵ�������ﵽ�ϸߵ�ʶ���ʣ��� 
				//�����бȽϴ�Ļ������ʶ������Ҷ��߳�ʱռ�ý϶�cpuʱ�䡣 
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
		/// ��ӵ��������У�����ʱ����Ӧ���ַ���Ϊ�ո��Դ��˹�ʶ�� 
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
				//��ʱ����Ӧ���ַ���Ϊ�ո��Դ��˹�ʶ�� 
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
		/// �����֤��ͼƬ�Ƿ��ֳܷ�4�����֣�������Ծͼ��4���ַ������������Ƿ��Ѿ����ڣ���������ڣ� 
		/// ����ӵ��������У�����ʱ����Ӧ���ַ���Ϊ�ո��Դ��˹�ʶ�� 
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
		/// ʶ��ͼƬ 
		/// </summary> 
		/// <returns>����ʶ����(������ص��ַ�������С��4��˵��ʶ��ʧ��)</returns> 
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
			//**�����ǻ�ȡ��Ч����ķ�Χ 
			for (int jj = 0; jj < imageHeight; jj++)
			{
				this.datapic[jj] = 0;
			}
			this.xlpic = (byte)(x2 - x1);
			//����ַ���ȳ���16�����ؾͲ��账�� 
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
