#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'http://www.chahaoma.net/'

REPLACE = (
    ('http://www.ip-look-up.com', ''),
    ('http://www.chahaoma.net', ''),
    ('http://Nphone.chahaoma.net', ''), 
    ('http://qq.chahaoma.net', ''), 
    ('window.google_analytics_uacct = "UA-12938927-3";', ''),
    ('window.google_analytics_uacct = "UA-12938927-1";', ''),
    ('UA-12938927-3', 'UA-791706-33'), 
    ('UA-12938927-1', 'UA-791706-33'), 
    ('欢迎来到IP Look UP!', '欢迎来到查号吧!'), 
    ('查号码', '查号吧'), 
    ('/image/logo.jpg', 'http://pic.caatashoes.com/logo/chahaoba.jpg'), 
    ('IPLookUp定位', '查号吧'), 
    ('terryZhu@chahaoma.net', 'ttwait@chahaoba.appspot.com'), 
    ('zmwgfh@163.com', 'ttwait@chahaoba.appspot.com'), 
     
    ('google.load("jquery", "1.4.2");', ''), 
    ('google.load("maps", "2");', ''), 
    ('<a href="http://www.yuanchanyoga.com" title="源禅瑜伽馆" target="_blank">源禅瑜伽馆</a>', '<a href="http://make-money-home.appspot.com" title="Make Money At Home" target="_blank">Make Money At Home</a>'), 
    ('<div id="ClientMap" style="width: 672px; height:260px"></div>', '')
   )

funcs = []
def bodyLeft(content):
    key1 = '<div class="containerBodyLeft">'
    key2 = '</script>'
    b = content.find(key1)
    if b == -1:
        return content
    b = b+len(key1)
    e = content.find(key2, b)
    content = content.replace(content[b:e], """<script type="text/javascript"><!--
google_ad_client = "pub-2153651206088577";
/* 手机详细页 */
google_ad_slot = "5415984878";
google_ad_width = 728;
google_ad_height = 90;
//-->
""")
    return content
funcs.append(bodyLeft)


def bodyRight(content):
    key1 = '<div class="containerBodyRight">'
    key2 = '<div class="info">'
    key3 = '</div>'
    b = content.find(key1)
    if b == -1:
        return content
    b = content.find(key2, b + len(key1))
    if b == -1:
        return content
    b = b+len(key2)
    e = content.find(key3, b)
    content = content.replace(content[b:e], """<script type="text/javascript"><!--
google_ad_client = "pub-2153651206088577";
/* 查号吧 页面 侧服广告 */
google_ad_slot = "6246406123";
google_ad_width = 160;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
""")
    return content
funcs.append(bodyRight)

def searchTop(content):
    key1 = '<div class="search_subject">'
    key2 = '</div>'
    b = content.find(key1)
    if b == -1:
        return content
    b = content.find(key1, b+len(key1))
    if b == -1:
        return content
    b = b+len(key1)
    e = content.find(key2, b)
    content = content.replace(content[b:e], """<div style="float: left;">
<script type="text/javascript"><!--
  google_ad_client = "pub-2153651206088577";
  google_ad_format = "js_sdo";
  google_cts_mode ="rs";
  google_num_cts = "2";
  google_searchbox_width = 215;
  google_searchbox_height = 26;
  google_link_target = 2;
  google_ad_channel = "9541963867";
  google_logo_pos = "left";
  google_rs_pos = "right";
  google_ad_height = 35;
  google_ad_width = 500;
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_sdo.js">
</script>
    """)
    return content
funcs.append(searchTop)

def jsapi(content):
    key1= 'src="http://www.google.com/jsapi?'
    b = content.find(key1)
    if b == -1:
        return content
    e = content.find('>', b)
    content = content.replace(content[b:e], '')
    return content
funcs.append(jsapi)


NOURL = []
NOTREPLACEEXT = {
    'gif' : 1,
    'jpg' : 1
}

REDIRECTURL = {
    
    }


class MainHandler(webapp.RequestHandler):
    def get(self):
        s = str(globals())
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write(s)
            

def main():
    application = webapp.WSGIApplication([('/config.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)
