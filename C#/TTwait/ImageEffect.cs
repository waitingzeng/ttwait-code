using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;
using System.Drawing.Imaging;
using System.Drawing.Drawing2D;
namespace TTwait
{
	public static class ImageEffect
	{
		/// <summary>
		/// 将图片处理成黑白色的
		/// </summary>
		/// <param name="image"></param>
		/// <returns></returns>
		public static Bitmap Gray(Bitmap image)
		{
			Bitmap bitmap = null;
			try
			{
				bitmap = new Bitmap(image.Width, image.Height);
				for (int w = 0; w < image.Width - 1; w++)
				{
					for (int h = 0; h < image.Height - 1; h++)
					{
						Color cc = image.GetPixel(w, h);
						int itest = (int)Math.Round(((cc.R * 0.299) + (cc.G * 0.587) + (cc.B * 0.114)) / 255);
						bitmap.SetPixel(w, h, itest == 0 ? Color.Black : Color.White);
					}
				}

			}
			catch (Exception ex)
			{
				throw ex;
			}
			finally
			{
				//bitmap.Dispose();
			}
			return bitmap;
		}


		private static void seed(int x, int y, List<int[]> tab, Rectangle r, bool[,] tchked, Bitmap image)
		{
			if (x < r.Left || y < r.Top || x >= r.Right || y >= r.Bottom)
				return;
			if (image.GetPixel(x, y).ToArgb() == Color.White.ToArgb())
				return;
			if (tchked[x, y])
				return;
			else
			{
				tab.Add(new int[] { x, y });
				tchked[x, y] = true;
				seed(x + 1, y - 1, tab, r, tchked, image);
				seed(x, y - 1, tab, r, tchked, image);
				seed(x - 1, y - 1, tab, r, tchked, image);
				seed(x - 1, y, tab, r, tchked, image);
				seed(x + 1, y, tab, r, tchked, image);
				seed(x - 1, y + 1, tab, r, tchked, image);
				seed(x, y + 1, tab, r, tchked, image);
				seed(x + 1, y + 1, tab, r, tchked, image);
				return;
			}
		}
		/// <summary>
		/// 将图片分成几部分，对每一部分进行最长连通处理，只处理单色图片
		/// </summary>
		/// <param name="image"></param>
		/// <param name="count"></param>
		/// <returns></returns>
		public static Bitmap ClearPoint(Bitmap image, int count)
		{
			Bitmap jieguo = (Bitmap)image.Clone();
			bool[,] tchked = new bool[image.Width, image.Height];
			for (int ii = 0; ii < image.Width; ii++)
			{
				for (int jj = 0; jj < image.Height; jj++)
				{
					tchked[ii, jj] = false;
				}
			}
			int spe = (int)image.Width / count;
			int w = spe;
			int h = image.Height;

			for (int i = 0; i < count; i++)
			{
				List<List<int[]>> tlines = new List<List<int[]>>();
				Rectangle r = new Rectangle(spe * i, 0, w, h);
				for (int x = r.Left; x < r.Right; x++)
				{
					for (int y = r.Top; y < r.Bottom; y++)
					{
						if (image.GetPixel(x, y).ToArgb() == Color.Black.ToArgb() && !tchked[x, y])
						{
							List<int[]> tab = new List<int[]>();
							seed(x, y, tab, r, tchked, image);
							tlines.Add(tab);
						}
					}
				}
				int max = 0;
				for (int kk = 0; kk < tlines.Count; kk++)
				{
					if (tlines[kk].Count > max)
					{
						max = tlines[kk].Count;
					}
				}
				for (int kk = 0; kk < tlines.Count; kk++)
				{
					if (tlines[kk].Count < max)
					{
						for (int tt = 0; tt < tlines[kk].Count; tt++)
						{
							jieguo.SetPixel(tlines[kk][tt][0], tlines[kk][tt][1], Color.White);
						}
					}
				}
				/*
				for (int tt = 0; tt < max.Count; tt++)
				{
					jieguo.SetPixel(max[tt][0], max[tt][1], Color.Black);
				}
				 * */
			}
			return jieguo;
		}

		/// <summary>
		/// 中值滤波
		/// </summary>
		/// <param name="image"></param>
		/// <returns></returns>
		public static Bitmap Middle(Bitmap image)
		{
			Bitmap jieguo = new Bitmap(image.Width, image.Height);
			for (int x = 1; x < image.Width-1; x++)
			{
				for (int y = 1; y < image.Height-1; y++)
				{
					Color[] sort_tmp = new Color[9];
					int pos = 0;
					for (int ii = -1; ii < 2; ii++)
					{
						for (int jj = -1; jj < 2; jj++)
						{
							sort_tmp[pos] = image.GetPixel(x + ii, y + jj);
							pos++;
						}
					}
					
					int[] r= new int[]{0,0,0};
					int[] g = new int[] { 0, 0, 0 };
					int[] b = new int[] { 0, 0, 0 };
					for (int ii = 0; ii < 9; ii++)
					{
						for (int jj = 0; jj < 9; jj++)
						{
							if (jj == ii)
								continue;
							if (sort_tmp[jj].ToArgb() > sort_tmp[jj].ToArgb())
							{
								r[1]++;
							}
							else if (sort_tmp[jj].ToArgb() < sort_tmp[jj].ToArgb())
							{
								r[2]++;
							}
							
						}
						if (Math.Abs(r[1] - r[2]) <= 1)
						{
							r[0] = ii;
							break;
						}
					}
					//Color c = Color.FromArgb(r / 9, g / 9, b / 9);
					jieguo.SetPixel(x, y, sort_tmp[r[0]]);

				}
			}
			return jieguo;
		}

		/// <summary>
		///  将指定的颜色设为白色，其他设为黑色
		/// </summary>
		/// <param name="image"></param>
		/// <param name="color"></param>
		/// <returns></returns>
		public static Bitmap ClearColor(Bitmap image, uint[] colorList)
		{
			Bitmap jieguo = new Bitmap(image.Width, image.Height);
			for (int x = 0; x < image.Width; x++)
			{
				for (int y = 0; y < image.Height; y++)
				{
					bool has = false;
					uint color = (uint)image.GetPixel(x,y).ToArgb();
					for (int i = 0; i < colorList.Length; i++)
					{
						if (colorList[i] == color)
						{
							has = true;
							break;
						}
					}
					if (has)
					{
						jieguo.SetPixel(x, y, Color.White);
					}
					else
					{
						jieguo.SetPixel(x, y, Color.Black);
					}
				}
			}
			return jieguo;
		}

		/// <summary>
		/// 
		/// </summary>
		/// <param name="image"></param>
		/// <returns></returns>
		public static Bitmap ClearPoint(Bitmap image)
		{
			Bitmap jieguo = (Bitmap)image.Clone();
			for (int x = 1; x < image.Width - 1; x++)
			{
				for (int y = 1; y < image.Height - 1; y++)
				{
					if (image.GetPixel(x, y) == Color.Black)
					{
						int count = 0;
						for (int jj = -1; jj < 1; jj++)
						{
							for (int ii = -1; ii < 1; ii++)
							{
								if (image.GetPixel(x + jj, y + ii) == Color.Black)
									count++;
							}
						}
						if (count <= 5)
						{
							jieguo.SetPixel(x, y, Color.White);
						}
					}
				}
			}
			return jieguo;
		}

		public static Bitmap ClearThinLine(Bitmap image)
		{
			Bitmap j = (Bitmap)image.Clone();
			for (int y = 0; y < image.Height; y++)
			{
				j.SetPixel(0, y, Color.White);
				j.SetPixel(image.Width -1, y, Color.White);
			}
			for (int x = 0; x < image.Width; x++)
			{
				j.SetPixel(x, 0, Color.White);
				j.SetPixel(x, image.Height - 1, Color.White);
			}
			for (int x = 1; x < image.Width-1; x++)
			{
				for (int y = 1; y < image.Height-1; y++)
				{
					if (j.GetPixel(x, y) == Color.Black && j.GetPixel(x, y - 1) == Color.White && j.GetPixel(x, y + 1) == Color.White)
					{
						j.SetPixel(x, y, Color.White);
					}
					else if (j.GetPixel(x, y) == Color.Black && j.GetPixel(x-1, y) == Color.White && j.GetPixel(x+1, y) == Color.White)
					{
						j.SetPixel(x, y, Color.White);
					}
				}
			}
			return j;
		}

		/// <summary>
		/// 去图形边框
		/// </summary>
		/// <param name="borderWidth"></param>
		public static Bitmap ClearPicBorder(Bitmap image, int borderWidth)
		{
			Bitmap b = (Bitmap)image.Clone();
			for (int i = 0; i < image.Height; i++)
			{
				for (int j = 0; j < image.Width; j++)
				{
					if (i < borderWidth || j < borderWidth || j > image.Width - 1 - borderWidth || i > image.Height - 1 - borderWidth)
						b.SetPixel(j, i, Color.White);
				}
			}
			return b;
		}

		/// <summary>
		/// 任意角度旋转
		/// </summary>
		/// <param name="bmp">原始图Bitmap</param>
		/// <param name="angle">旋转角度</param>
		/// <param name="bkColor">背景色</param>
		/// <returns>输出Bitmap</returns>
		public static Bitmap KiRotate(Bitmap bmp, float angle, Color bkColor)
		{
			int w = bmp.Width + 2;
			int h = bmp.Height + 2;

			PixelFormat pf;

			if (bkColor == Color.Transparent)
			{
				pf = PixelFormat.Format32bppArgb;
			}
			else
			{
				pf = bmp.PixelFormat;
			}

			Bitmap tmp = new Bitmap(w, h, pf);
			Graphics g = Graphics.FromImage(tmp);
			g.Clear(bkColor);
			g.DrawImageUnscaled(bmp, 1, 1);
			g.Dispose();

			GraphicsPath path = new GraphicsPath();
			path.AddRectangle(new RectangleF(0f, 0f, w, h));
			Matrix mtrx = new Matrix();
			mtrx.Rotate(angle);
			RectangleF rct = path.GetBounds(mtrx);

			Bitmap dst = new Bitmap((int)rct.Width, (int)rct.Height, pf);
			g = Graphics.FromImage(dst);
			g.Clear(bkColor);
			g.TranslateTransform(-rct.X, -rct.Y);
			g.RotateTransform(angle);
			g.InterpolationMode = InterpolationMode.HighQualityBilinear;
			g.DrawImageUnscaled(tmp, 0, 0);
			g.Dispose();

			tmp.Dispose();

			return dst;
		}
	}
}
