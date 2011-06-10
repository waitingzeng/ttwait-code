namespace TTwait
{
    using System;
    using System.ComponentModel;
    using System.Windows.Forms;

    public class TextBoxNumEx : TextBox
    {
        public TextBoxNumEx()
        {
            this.InitializeComponent();
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing && (this.components != null))
            {
                this.components.Dispose();
            }
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            base.SuspendLayout();
            base.Name = "TextBoxNumEx";
            base.ResumeLayout(false);
        }

        private bool MatchNumber(string ClipboardText)
        {
            int num1 = 0;
            string text1 = "-0.123456789";
            num1 = ClipboardText.IndexOf(text1[0]);
            if (num1 >= 0)
            {
                if (num1 > 0)
                {
                    return false;
                }
                if (base.SelectionStart > 0)
                {
                    return false;
                }
            }
            num1 = ClipboardText.IndexOf(text1[2]);
            if (num1 != -1)
            {
                num1 = this.Text.IndexOf(text1[2]);
                if (num1 != -1)
                {
                    return false;
                }
            }
            for (int num2 = 0; num2 < ClipboardText.Length; num2++)
            {
                num1 = text1.IndexOf(ClipboardText[num2]);
                if (num1 < 0)
                {
                    return false;
                }
            }
            return true;
        }

        private void TextBoxNumEx_Load(object sender, EventArgs e)
        {
			this.Text = "0";
        }

        protected override void WndProc(ref Message m)
        {
            switch (m.Msg)
            {
                case 0x102:
                {
                    Console.WriteLine(m.WParam);
                    bool flag1 = ((int) m.WParam) == 0x2d;
                    bool flag2 = (((int) m.WParam) >= 0x30) && (((int) m.WParam) <= 0x39);
                    bool flag3 = ((int) m.WParam) == 8;
                    bool flag4 = ((int) m.WParam) == 0x2e;
                    bool flag5 = (((((int) m.WParam) == 0x18) || (((int) m.WParam) == 0x16)) || (((int) m.WParam) == 0x1a)) || (((int) m.WParam) == 3);
                    if ((flag2 || flag3) || flag5)
                    {
                        base.WndProc(ref m);
                    }
                    if (flag1)
                    {
                        if (base.SelectionStart == 0)
                        {
                            base.WndProc(ref m);
                        }
                        return;
                    }
                    if (flag4 && (this.Text.IndexOf(".") < 0))
                    {
                        base.WndProc(ref m);
                    }
                    if (((int) m.WParam) == 1)
                    {
                        base.SelectAll();
                    }
                    return;
                }
                case 770:
                {
                    IDataObject obj1 = Clipboard.GetDataObject();
                    if (obj1.GetDataPresent(DataFormats.Text))
                    {
                        string text1 = (string) obj1.GetData(DataFormats.Text);
                        if (this.MatchNumber(text1))
                        {
                            base.WndProc(ref m);
                            return;
                        }
                    }
                    m.Result = IntPtr.Zero;
                    return;
                }
            }
            base.WndProc(ref m);
        }

		public int Value
		{
			set
			{
				this.Text = value.ToString();
			}
			get { return Convert.ToInt32(this.Text); }
		}

        private IContainer components;
        public const int WM_CHAR = 0x102;
        public const int WM_CLEAR = 0x303;
        public const int WM_CONTEXTMENU = 0x7b;
        public const int WM_COPY = 0x301;
        public const int WM_CUT = 0x300;
        public const int WM_PASTE = 770;
        public const int WM_UNDO = 0x304;
    }
}

