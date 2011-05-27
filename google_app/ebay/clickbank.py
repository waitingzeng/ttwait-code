#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from google.appengine.api import memcache
from random import random, randint
from model import get_item, get_value
from datetime import datetime, timedelta
from apps import getApp


google_analytics = """<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-791706-34']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>"""
class MainHandler(webapp.RequestHandler): 
    def get(self, url=None):
        item = get_item('clickbank', '0')
        item.value = str(int(item.value) + 1)
        item.put()
        target_url = 'http://%s.hop.clickbank.net/' % url
        res = """<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yisec-One Second To Eary Money</title>
</head>
<body style="margin:0px;background-color:#fff;" bgcolor="#ffffff">
%s
<iframe id="iF" src="%s" border="0" framespacing="0" marginheight="0" marginwidth="0" vspace="0" hspace="0" frameborder="0" height="100%%" scrolling="yes" width="100%%" style="overflow:auto;background-color:#fff"></iframe>
</body>
</html>
""" % (google_analytics, target_url)
        self.response.out.write(res)
        

def main():
    application = webapp.WSGIApplication([('/click/(.*)', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
