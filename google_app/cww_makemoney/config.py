#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'http://2.teachyoulearnmoney.sinaapp.com/'

REPLACE = (('2.teachyoulearnmoney.sinaapp.com', 'teachyoulearnmoney.appspot.com'),('UA-791706-40', 'UA-26237398-1'), ('google_ad_client = "google_ad_client";', 'google_ad_client = "pub-6205819031364190";'),)

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
