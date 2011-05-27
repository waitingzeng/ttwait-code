#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
SITE = 'http://taokemen.appspot.com'

oldtaokeid = '12055528'
newtaokeid = '12317283'  #my

REPLACE = (('taokemen', 'taogouke'), ('淘客门', '淘购客'), (oldtaokeid, newtaokeid), ('logo1.png', 'http://pic.caatashoes.com/logo/taogouke.jpg'), ('123123416', '1216992142'), ('Gtalk:neatchenheng@gmail.com', ''), ('MSN:neatchenheng@gmail.com', """<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-791706-32']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
"""),)

funcs = []



class MainHandler(webapp.RequestHandler):
    def get(self):
        s = str(globals())
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write(s)
            

def main():
    application = webapp.WSGIApplication([('/config.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)
