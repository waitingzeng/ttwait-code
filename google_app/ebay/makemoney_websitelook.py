#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
SITE = 'http://www.websiteoutlook.com'

REPLACE = (('http://www.websiteoutlook.com', 'http://websitelook.appspot.com'), ('www.websiteoutlook.com', 'websitelook.appspot.com'), ('Websiteoutlook', 'Websitelook'), ('WebsiteOutlook', 'WebsiteLook'), ('websiteoutlook', 'websitelook'), ('pub-4018335132104035', 'pub-2153651206088577'), ('logo.gif', 'http://pic.caatashoes.com/logo/websitelook.gif'), ('admin(at)websiteoutlook.com ', 'websitelook(at)yisec.com '), ('</body>', """<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-791706-35']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script></body>"""), ("""And then follow the Instruction at <a href="http://websiteoutlook.com/remove_url.html"><strong>Remove Website</strong></a> page.""", ''), ('ABQIAAAAFG7DPgHChqLzgCoY-JFYzxSDwNEwyb0RrCOjxO3pfMy3yNhBthTtXd8r3mD0aWEv8VgLoSxrUdAvYg', 'ABQIAAAA9LDJ1jY_AhCMUqB38vP0zxQ9fwhg0vXhr-3P25ti5qzGf1n9WxTlkBzD2tKe28XhQitoVb85J60sXw'), ('<li><a href="contact_us.html">Contact Us </a></li>', '<li><a href="contact_us.html">Contact Us </a></li><li><a href="sitemap/1">Site Map</a></li>'))

funcs = []



class MainHandler(webapp.RequestHandler):
    def get(self):
        s = str(globals())
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write(s)
            

def main():
    application = webapp.WSGIApplication([('/config.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)
