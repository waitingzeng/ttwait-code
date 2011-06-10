using System;
using System.Collections.Generic;
using System.Text;

namespace TTwait
{
	static public class Unicode
	{

		static public string NormalC2U(string input, bool all)
		{
			Encoding encoding1 = Encoding.BigEndianUnicode;
			char[] chArray1 = input.ToCharArray();
			string text1 = "";
			foreach (char ch1 in chArray1)
			{
				if (ch1.Equals('\r') || ch1.Equals('\n'))
				{
					text1 = text1 + ch1;
				}
				else
				{
					byte[] buffer1 = encoding1.GetBytes(new char[] { ch1 });
					
					if (buffer1[0] != (byte)0)
					{
						text1 = text1 + @"\u";
						text1 = text1 + string.Format("{0:X2}", buffer1[0]);
						text1 = text1 + string.Format("{0:X2}", buffer1[1]);
					}
					else
					{
						if (all)
						{
							text1 = text1 + @"\" + string.Format("{0:X2}", buffer1[1]);
						}
						else
						{
							text1 = text1 + ch1.ToString();
						}
					}
				}
			}
			return text1;
		}

		static public string NormalC2U(string input)
		{
			return NormalC2U(input, false);
		}

		static public string NormalU2C(string input)
		{
			string text1 = "";
			char[] chArray1 = input.ToCharArray();
			Encoding encoding1 = Encoding.BigEndianUnicode;
			for (int num1 = 0; num1 < chArray1.Length; num1++)
			{
				char ch1 = chArray1[num1];
				if (ch1.Equals('\\'))
				{
					num1++;
					num1++;
					char[] chArray2 = new char[4];
					int num2 = 0;
					num2 = 0;
					while ((num2 < 4) && (num1 < chArray1.Length))
					{
						chArray2[num2] = chArray1[num1];
						num2++;
						num1++;
					}
					if (num2 == 4)
					{
						try
						{
							text1 = text1 + Unicode.UnicodeCode2Str(chArray2);
						}
						catch (Exception)
						{
							text1 = text1 + @"\u";
							for (int num3 = 0; num3 < num2; num3++)
							{
								text1 = text1 + chArray2[num3];
							}
						}
						num1--;
					}
					else
					{
						text1 = text1 + @"\u";
						for (int num4 = 0; num4 < num2; num4++)
						{
							text1 = text1 + chArray2[num4];
						}
					}
				}
				else
				{
					text1 = text1 + ch1.ToString();
				}
			}
			return text1;
		}
		static private string UnicodeCode2Str(char[] u4)
		{
			if (u4.Length < 4)
			{
				throw new Exception("It's not a unicode code array");
			}
			string text1 = "0123456789ABCDEF";
			char ch1 = char.ToUpper(u4[0]);
			char ch2 = char.ToUpper(u4[1]);
			char ch3 = char.ToUpper(u4[2]);
			char ch4 = char.ToUpper(u4[3]);
			int num1 = text1.IndexOf(ch1);
			int num2 = text1.IndexOf(ch2);
			int num3 = text1.IndexOf(ch3);
			int num4 = text1.IndexOf(ch4);
			if (((num1 == -1) || (num2 == -1)) || ((num3 == -1) || (num4 == -1)))
			{
				throw new Exception("It's not a unicode code array");
			}
			byte num5 = (byte)(((num1 * 0x10) + num2) & 0xff);
			byte num6 = (byte)(((num3 * 0x10) + num4) & 0xff);
			byte[] buffer1 = new byte[] { num5, num6 };
			return Encoding.BigEndianUnicode.GetString(buffer1);
		}


	}
}
