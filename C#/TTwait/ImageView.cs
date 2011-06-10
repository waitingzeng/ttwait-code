namespace TTwait
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel;
    using System.Drawing;
    using System.IO;
    using System.Runtime.CompilerServices;
    using System.Windows.Forms;

    public class ImageView : UserControl
    {
        public event ImgModifyEventHandler ImgModify;
		private string defaultFileName = "";

		public string DefaultFileName
		{
			get { return defaultFileName; }
			set { defaultFileName = value; }
		}

        public ImageView()
        {
            this.imgPath = "";
            this.showPic = new PictureBox();
            this.picArray = new List<string>();
            this.picIndex = 0;
            this.InitializeComponent();
        }

        private void add_Click(object sender, EventArgs e)
        {
            this.selectImg.ShowDialog();
            addPic(this.selectImg.FileNames);
        }

		public bool addPic(string[] fileNames)
		{
			int num1 = 0;
			for (; num1 < fileNames.Length; num1++)
			{
				string filename = fileNames[num1];
				if (!addAPic(filename))
				{
					MessageBox.Show("添加图片" + filename + "出错，请确保你所添加的文件是正确的。", "错误警告", MessageBoxButtons.OK);
					break;
				}
			}
			if (num1 < fileNames.Length)
				return false;
			return true;
		}

		public bool addAPic(string filename)
		{
			if (!filename.EndsWith(".jpg", StringComparison.OrdinalIgnoreCase))
			{
				return false;
			}
			
			string text1 = "backup/"+filename.Substring(filename.LastIndexOf('\\')+1);
			string text2 = "pic/" + this.makeFileName() + ".jpg";
			try
			{
				File.WriteAllBytes(text2, File.ReadAllBytes(filename));
				File.Move(filename, text1);
			}
			catch (Exception ee)
			{
				return false;
			}
			this.picArray.Add(text2);
			this.picIndex = this.picArray.Count - 1;
			this.Show();
			this.OnImgModify(EventArgs.Empty);
			return true;
		}
        private void delete_Click(object sender, EventArgs e)
        {

			deleteAPic();
            this.Show();
            this.OnImgModify(EventArgs.Empty);
        }

		public void deleteAPic()
		{
			if (picArray.Count <= 0)
				return;
			File.Delete(this.picArray[this.picIndex]);
			this.picArray.Remove(this.picArray[this.picIndex]);
			this.picIndex--;
		}

		public void deleteAllPic()
		{
			while (picArray.Count > 0)
			{
				deleteAPic();
			}
		}

        protected override void Dispose(bool disposing)
        {
            if (disposing && (this.components != null))
            {
                this.components.Dispose();
            }
            base.Dispose(disposing);
        }

        private void ImageView_Load(object sender, EventArgs e)
        {
        }

        private void InitializeComponent()
        {
			this.showPic = new System.Windows.Forms.PictureBox();
			this.prev = new System.Windows.Forms.Button();
			this.next = new System.Windows.Forms.Button();
			this.add = new System.Windows.Forms.Button();
			this.delete = new System.Windows.Forms.Button();
			this.selectImg = new System.Windows.Forms.OpenFileDialog();
			this.state = new System.Windows.Forms.Label();
			((System.ComponentModel.ISupportInitialize)(this.showPic)).BeginInit();
			this.SuspendLayout();
			// 
			// showPic
			// 
			this.showPic.Location = new System.Drawing.Point(1, 2);
			this.showPic.Name = "showPic";
			this.showPic.Size = new System.Drawing.Size(171, 125);
			this.showPic.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.showPic.TabIndex = 0;
			this.showPic.TabStop = false;
			// 
			// prev
			// 
			this.prev.Enabled = false;
			this.prev.Location = new System.Drawing.Point(4, 147);
			this.prev.Name = "prev";
			this.prev.Size = new System.Drawing.Size(75, 23);
			this.prev.TabIndex = 1;
			this.prev.Text = "前一张";
			this.prev.UseVisualStyleBackColor = true;
			this.prev.Click += new System.EventHandler(this.prev_Click);
			// 
			// next
			// 
			this.next.Enabled = false;
			this.next.Location = new System.Drawing.Point(85, 147);
			this.next.Name = "next";
			this.next.Size = new System.Drawing.Size(75, 23);
			this.next.TabIndex = 2;
			this.next.Text = "后一张";
			this.next.UseVisualStyleBackColor = true;
			this.next.Click += new System.EventHandler(this.next_Click);
			// 
			// add
			// 
			this.add.Location = new System.Drawing.Point(4, 176);
			this.add.Name = "add";
			this.add.Size = new System.Drawing.Size(75, 23);
			this.add.TabIndex = 3;
			this.add.Text = "添加";
			this.add.UseVisualStyleBackColor = true;
			this.add.Click += new System.EventHandler(this.add_Click);
			// 
			// delete
			// 
			this.delete.Location = new System.Drawing.Point(85, 176);
			this.delete.Name = "delete";
			this.delete.Size = new System.Drawing.Size(75, 23);
			this.delete.TabIndex = 4;
			this.delete.Text = "删除";
			this.delete.UseVisualStyleBackColor = true;
			this.delete.Click += new System.EventHandler(this.delete_Click);
			// 
			// selectImg
			// 
			this.selectImg.DefaultExt = "jpg";
			this.selectImg.Filter = "JPEG files|*.jpg|GIF files|*.gif";
			this.selectImg.Multiselect = true;
			this.selectImg.RestoreDirectory = true;
			this.selectImg.SupportMultiDottedExtensions = true;
			// 
			// state
			// 
			this.state.AutoSize = true;
			this.state.Location = new System.Drawing.Point(3, 131);
			this.state.Name = "state";
			this.state.Size = new System.Drawing.Size(41, 12);
			this.state.TabIndex = 5;
			this.state.Text = "label1";
			// 
			// ImageView
			// 
			this.AllowDrop = true;
			this.Controls.Add(this.state);
			this.Controls.Add(this.delete);
			this.Controls.Add(this.add);
			this.Controls.Add(this.next);
			this.Controls.Add(this.prev);
			this.Controls.Add(this.showPic);
			this.Name = "ImageView";
			this.Size = new System.Drawing.Size(173, 204);
			this.Load += new System.EventHandler(this.ImageView_Load);
			this.DragDrop += new System.Windows.Forms.DragEventHandler(this.ImageView_DragDrop);
			this.DragEnter += new System.Windows.Forms.DragEventHandler(this.ImageView_DragEnter);
			((System.ComponentModel.ISupportInitialize)(this.showPic)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

        }

		private string makeFileName()
		{
			if (defaultFileName != "")
			{
				DateTime time1 = DateTime.Now;
				return string.Format("{0}{1}{2}{3}{4}{5}{6}", new object[] { time1.Year, time1.Month, time1.Day, time1.Hour, time1.Minute, time1.Second, time1.Millisecond });
			}
			else
			{
				return defaultFileName;
			}
		}

        private void next_Click(object sender, EventArgs e)
        {
            if (this.picIndex < (this.picArray.Count-1))
            {
                this.picIndex++;
                this.Show();
            }
        }

        protected virtual void OnImgModify(EventArgs e)
        {
            if (this.ImgModify != null)
            {
                this.ImgModify(this, e);
            }
        }

        private void prev_Click(object sender, EventArgs e)
        {
            if (this.picIndex > 0)
            {
                this.picIndex--;
                this.Show();
            }
        }

        public new void Show()
        {
			if (this.picArray.Count == 0)
			{
				this.delete.Enabled = false;
				this.prev.Enabled = false;
				this.next.Enabled = false;
				this.picIndex = 0;
				this.state.Text = "暂无图片";
				this.showPic.Image = this.showPic.InitialImage;
			}
			else
			{
				this.delete.Enabled = true;
				this.prev.Enabled = true;
				this.next.Enabled = true;
				if (this.picIndex == 0)
				{
					this.prev.Enabled = false;
				}
				if (this.picIndex >= (this.picArray.Count-1))
				{
					this.next.Enabled = false;
				}
				this.showPic.ImageLocation = this.picArray[this.picIndex];
				this.state.Text = string.Format("共有{0},第{1},{2}", this.picArray.Count, this.picIndex + 1, this.picArray[this.picIndex]);
			}
        }


        public bool CanEdit
        {
            get
            {
                return this.canEdit;
            }
            set
            {
                this.canEdit = value;
                this.add.Visible = this.canEdit;
                this.delete.Visible = this.canEdit;
            }
        }

        public string ImgPath
        {
            get
            {
                string text1 = "";
                foreach (string text2 in this.picArray)
                {
                    text1 = text1 + "*" + text2;
                }
                return text1;
            }
            set
            {
                this.picArray.Clear();
                this.imgPath = value;
                char[] chArray1 = new char[] { '*' };
                string[] textArray1 = this.imgPath.Split(chArray1);
                for (int num1 = 1; num1 < textArray1.Length; num1++)
                {
                    this.picArray.Add(textArray1[num1]);
                }
                if (this.picArray.Count != 0)
                {
                    this.picIndex = 0;
                }
                this.Show();
            }
        }


        private Button add;
        private bool canEdit;
        private IContainer components;
        private Button delete;
        private string imgPath;
        private Button next;
        private List<string> picArray;
        private int picIndex;
        private Button prev;
        private OpenFileDialog selectImg;
        private PictureBox showPic;
        private Label state;


        public delegate void ImgModifyEventHandler(object sender, EventArgs e);

		private void ImageView_DragEnter(object sender, DragEventArgs e)
		{
			if (canEdit&&e.Data.GetDataPresent(DataFormats.FileDrop))
			{
				addPic((string[])e.Data.GetData(DataFormats.FileDrop));
				e.Effect = DragDropEffects.None;
			}
		}

		private void ImageView_DragDrop(object sender, DragEventArgs e)
		{
			
		}

    }
}

