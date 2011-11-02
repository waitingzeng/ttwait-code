#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'http://1.somuchmoney.sinaapp.com/'

REPLACE = (('1.somuchmoney.sinaapp.com', 'so-much-money.appspot.com'),('UA-791706-40', ''),('UA-791706-46', ''), ('google_ad_client = "google_ad_client";', 'google_ad_client = "pub-3036032774445026";'),)

funcs = []

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
