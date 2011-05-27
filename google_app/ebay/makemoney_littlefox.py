#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'http://www.rajaietalks.com'

REPLACE = (('http://www.rajaietalks.com', ''),('www.rajaietalks.com', ''),('UA-4550101-1', 'UA-791706-30'), ('google_ad_client = "pub-5522059358772292";', 'google_ad_client = "pub-8204171404325207";'), ('google_ad_slot = "4743867869";', 'google_ad_slot = "7439857135";'), ('google_ad_slot = "1095884884";', 'google_ad_slot = "5003203737";'), ('google_ad_slot = "0219881967";', 'google_ad_slot = "5109183691";'), ('google_ad_slot = "9927927337";', 'google_ad_slot = "7567681970";'), ('http://join.genuineincomestreams.com/track/NTYxMDEuOS44LjIzLjAuMC4wLjA', '/'), ('src="http://sm8.sitemeter.com/js/counter.js?site=sm8simple"', ''), ('http://feeds.feedburner.com/rajaietalks', ''), ('RajaieTalks', ''), ('<li><a class="" rel="nofollow" title="Contact Us" href="/contact">Contact</a></li>', ''),('<body>', '<body><script type="text/javascript">window.google_analytics_uacct = "UA-791706-30";</script>'),)

funcs = []
def Sponsors(content):
    key1 = '<div class="widget"><h4 class="widgettitle">'
    key2 = '<h4 class="widgettitle">'
    b = content.find(key1)
    if b == -1:
        return content
    e = content.find(key2, b+len(key1))
    content = content.replace(content[b:e], '')
    return content
funcs.append(Sponsors)

def Form(content):
    key1 = '<form action="/wp-comments-post.php" method="post">'
    key2 = '</form>'
    b = content.find(key1)
    if b == -1:
        return content
    e = content.find(key2, b+len(key1))
    content = content.replace(content[b:e], '')
    return content

funcs.append(Form)

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
