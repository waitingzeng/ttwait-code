using System;
using System.Collections.Generic;
using System.Text;
using System.Windows.Forms;

namespace TTwait
{
    public class SimpleDocument
    {
        private WebBrowser web = null;
        private static Random rnd = new Random();
        public SimpleDocument(WebBrowser w)
        {
            web = w;
        }

        public static string RndNext()
        {
            return rnd.Next(0x5f5e100, 0x3b9ac9ff).ToString();
        }

        public static mshtml.IHTMLDocument2 execScript(HtmlDocument doc,  string evalStr)
        {
            
            mshtml.IHTMLDocument2 domDocument = (mshtml.IHTMLDocument2)doc.DomDocument;
            domDocument.parentWindow.execScript(evalStr, "JavaScript");
            return domDocument;
        }

        public static void fireChange(HtmlElement elm)
        {
            fireEvent(elm, "onchange");
        }

        public static void fireEvent(HtmlElement elm, string ev)
        {
            if (elm.Id == "")
            {
                elm.Id = RndNext();
            }
            string evalStr = string.Format("document.getElementById('{0}').fireEvent('{1}');", elm.Id, ev);
            execScript(elm.Document, evalStr);
        }

        public static HtmlElement[] getHtmlElement(HtmlElementCollection collection, string[] attrs, string[] values)
        {
            if (attrs.Length != values.Length)
            {
                return null;
            }
            List<HtmlElement> list = new List<HtmlElement>();
            foreach (HtmlElement element in collection)
            {
                bool flag = true;
                for (int i = 0; i < attrs.Length; i++)
                {
                    if (element.GetAttribute(attrs[i]).IndexOf(values[i]) == -1)
                    {
                        flag = false;
                    }
                }
                if (flag)
                {
                    list.Add(element);
                }
            }
            return list.ToArray();
        }

        public static HtmlElement getHtmlElement(HtmlElementCollection collection, string attr, string value)
        {
            HtmlElement[] elementArray =  getHtmlElement(collection, new string[] { attr }, new string[] { value });
            if (elementArray.Length == 0)
            {
                return null;
            }
            return elementArray[0];
        }

        public void set(string id, string value)
        {
            HtmlElement elm = web.Document.GetElementById(id);
            set(elm, value);
        }

        public void set(HtmlElement elm, string value)
        {
            if (elm == null)
                return;
            elm.SetAttribute("value", value);
            SimpleDocument.fireChange(elm);
        }

        public void click(string id)
        {
            HtmlElement elm = web.Document.GetElementById(id);
            click(elm);
        }

        public void click(HtmlElement elm)
        {
            if (elm == null)
                return;
            elm.InvokeMember("click");
        }

    }
}
