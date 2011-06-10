using System;
using System.Collections.Generic;
using System.Text;

namespace TTwait
{
	/// <SUMMARY>   
	/// �Զ�������ַ���������   
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

        /* ������intLength��������Ҫ�����ĺ��ָ���   */
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
		/// �Զ�������ַ���(���пɰ�������,����,��Сд��ĸ)�����ɷ���.   
		/// </SUMMARY>   
		/// <PARAM name="intLength">��Ҫλ��</PARAM>   
		/// <PARAM name="booNumber">�Ƿ���������</PARAM>   
		/// <PARAM name="booSign">�Ƿ����ɷ���</PARAM>   
		/// <PARAM name="booSmallword">�Ƿ�����Сд��ĸ</PARAM>   
		/// <PARAM name="booBigword">�Ƿ����ɴ�д��ĸ</PARAM>   
		/// <RETURNS></RETURNS>   
		public static string Next(int intLength, bool booNumber, bool booSign, bool booSmallword, bool booBigword)
		{

			int intResultRound = 0;
			int intA = 0;
			string strB = "";

			while (intResultRound < intLength)
			{

				//���������A����ʾ��������   
				//1=���֣�2=���ţ�3=Сд��ĸ��4=��д��ĸ
				intA = ranA.Next(1, 5);

				//��������A=1����������������   
				//���������A����Χ��0-10   
				//�������A��ת���ַ�   
				//�����꣬λ��+1���ַ����ۼӣ���������ѭ��   
				if (intA == 1 && booNumber)
				{
					intA = ranA.Next(0, 10);
					strB = intA.ToString() + strB;
					intResultRound = intResultRound + 1;
					continue;
				}

				//��������A=2�����������ɷ���   
				//���������A����ʾ����ֵ��   
				//1��33-47ֵ��2��58-64ֵ��3��91-96ֵ��4��123-126ֵ��   
				if (intA == 2 && booSign == true)
				{
					intA = ranA.Next(1, 5);



					//���A=1   
					//���������A��33-47��Ascii��   
					//�������A��ת���ַ�   
					//�����꣬λ��+1���ַ����ۼӣ���������ѭ��   
					if (intA == 1)
					{
						intA = ranA.Next(33, 48);
						strB = ((char)intA).ToString() + strB;
						intResultRound = intResultRound + 1;
						continue;
					}



					//���A=2   
					//���������A��58-64��Ascii��   
					//�������A��ת���ַ�   
					//�����꣬λ��+1���ַ����ۼӣ���������ѭ��   
					if (intA == 2)
					{
						intA = ranA.Next(58, 65);
						strB = ((char)intA).ToString() + strB;
						intResultRound = intResultRound + 1;
						continue;
					}



					//���A=3   
					//���������A��91-96��Ascii��   
					//�������A��ת���ַ�   
					//�����꣬λ��+1���ַ����ۼӣ���������ѭ��   
					if (intA == 3)
					{
						intA = ranA.Next(91, 97);
						strB = ((char)intA).ToString() + strB;
						intResultRound = intResultRound + 1;
						continue;
					}



					//���A=4   
					//���������A��123-126��Ascii��   
					//�������A��ת���ַ�   
					//�����꣬λ��+1���ַ����ۼӣ���������ѭ��   
					if (intA == 4)
					{
						intA = ranA.Next(123, 127);
						strB = ((char)intA).ToString() + strB;
						intResultRound = intResultRound + 1;
						continue;
					}
				}

				//��������A=3������������Сд��ĸ   
				//���������A����Χ��97-122   
				//�������A��ת���ַ�   
				//�����꣬λ��+1���ַ����ۼӣ���������ѭ��   
				if (intA == 3 && booSmallword == true)
				{
					intA = ranA.Next(97, 123);
					strB = ((char)intA).ToString() + strB;
					intResultRound = intResultRound + 1;
					continue;
				}



				//��������A=4�����������ɴ�д��ĸ   
				//���������A����Χ��65-90   
				//�������A��ת���ַ�   
				//�����꣬λ��+1���ַ����ۼӣ���������ѭ��   
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
