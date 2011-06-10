using System;
using System.Collections.Generic;
using System.Text;

namespace TTwait
{
	/// <SUMMARY>   
	/// 自定义随机字符串生成器   
	/// </SUMMARY>   
	public class Randomizer
	{
        private static Random ranA = new Random();
        private static void resetRandom()
        {
            ranA = new Random(ranA.Next() * unchecked((int)DateTime.Now.Ticks) + ranA.Next());
        }
		public static string Next(int intLength)
		{
			return Next(intLength, false, false, true, false);
		}

        public static string Password(int intLength)
        {
            return Next(intLength, true, false, true,false);
        }

        public static string Number(int intLength)
        {
            return Next(intLength, true, false, false, false);
        }

        /* 参数：intLength，代表需要产生的汉字个数   */
        public static string Chinese(int intLength)
        {

            byte[] bytes = new byte[intLength * 2];
            for (int i = 0; i < intLength * 2; i += 2)
            {
                int r1 = ranA.Next(11, 14);
                int r2 = 0;
                if (r1 == 13) r2 = ranA.Next(0, 7);
                else r2 = ranA.Next(0, 16);
                bytes[i] = (byte)(r1*16+r2);

                r1 = ranA.Next(10, 16);
                if (r1 == 10) r2 = ranA.Next(1, 16);
                else if (r1 == 15) r2 = ranA.Next(0, 15);
                else r2 = ranA.Next(0, 16);
                bytes[i + 1] = (byte)(r1 * 16 + r2);
            }
            return Encoding.GetEncoding("gb2312").GetString(bytes);

        }
		/// <SUMMARY>   
		/// 自定义随机字符串(其中可包含数字,符号,大小写字母)的生成方法.   
		/// </SUMMARY>   
		/// <PARAM name="intLength">需要位数</PARAM>   
		/// <PARAM name="booNumber">是否生成数字</PARAM>   
		/// <PARAM name="booSign">是否生成符号</PARAM>   
		/// <PARAM name="booSmallword">是否生成小写字母</PARAM>   
		/// <PARAM name="booBigword">是否生成大写字母</PARAM>   
		/// <RETURNS></RETURNS>   
		public static string Next(int intLength, bool booNumber, bool booSign, bool booSmallword, bool booBigword)
		{

			int intResultRound = 0;
			int intA = 0;
			string strB = "";

			while (intResultRound < intLength)
			{

				//生成随机数A，表示生成类型   
				//1=数字，2=符号，3=小写字母，4=大写字母
				intA = ranA.Next(1, 5);

				//如果随机数A=1，则运行生成数字   
				//生成随机数A，范围在0-10   
				//把随机数A，转成字符   
				//生成完，位数+1，字符串累加，结束本次循环   
				if (intA == 1 && booNumber)
				{
					intA = ranA.Next(0, 10);
					strB = intA.ToString() + strB;
					intResultRound = intResultRound + 1;
					continue;
				}

				//如果随机数A=2，则运行生成符号   
				//生成随机数A，表示生成值域   
				//1：33-47值域，2：58-64值域，3：91-96值域，4：123-126值域   
				if (intA == 2 && booSign == true)
				{
					intA = ranA.Next(1, 5);



					//如果A=1   
					//生成随机数A，33-47的Ascii码   
					//把随机数A，转成字符   
					//生成完，位数+1，字符串累加，结束本次循环   
					if (intA == 1)
					{
						intA = ranA.Next(33, 48);
						strB = ((char)intA).ToString() + strB;
						intResultRound = intResultRound + 1;
						continue;
					}



					//如果A=2   
					//生成随机数A，58-64的Ascii码   
					//把随机数A，转成字符   
					//生成完，位数+1，字符串累加，结束本次循环   
					if (intA == 2)
					{
						intA = ranA.Next(58, 65);
						strB = ((char)intA).ToString() + strB;
						intResultRound = intResultRound + 1;
						continue;
					}



					//如果A=3   
					//生成随机数A，91-96的Ascii码   
					//把随机数A，转成字符   
					//生成完，位数+1，字符串累加，结束本次循环   
					if (intA == 3)
					{
						intA = ranA.Next(91, 97);
						strB = ((char)intA).ToString() + strB;
						intResultRound = intResultRound + 1;
						continue;
					}



					//如果A=4   
					//生成随机数A，123-126的Ascii码   
					//把随机数A，转成字符   
					//生成完，位数+1，字符串累加，结束本次循环   
					if (intA == 4)
					{
						intA = ranA.Next(123, 127);
						strB = ((char)intA).ToString() + strB;
						intResultRound = intResultRound + 1;
						continue;
					}
				}

				//如果随机数A=3，则运行生成小写字母   
				//生成随机数A，范围在97-122   
				//把随机数A，转成字符   
				//生成完，位数+1，字符串累加，结束本次循环   
				if (intA == 3 && booSmallword == true)
				{
					intA = ranA.Next(97, 123);
					strB = ((char)intA).ToString() + strB;
					intResultRound = intResultRound + 1;
					continue;
				}



				//如果随机数A=4，则运行生成大写字母   
				//生成随机数A，范围在65-90   
				//把随机数A，转成字符   
				//生成完，位数+1，字符串累加，结束本次循环   
				if (intA == 4 && booBigword == true)
				{
					intA = ranA.Next(65, 89);
					strB = ((char)intA).ToString() + strB;
					intResultRound = intResultRound + 1;
					continue;
				}
			}

			return strB;
		}

	}  

}
