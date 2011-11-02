#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'http://1.waystoeasymoney.sinaapp.com/'

REPLACE = (('1.waystoeasymoney.sinaapp.com', 'make-money-article.appspot.com'),('UA-791706-42', ''),('UA-791706-40', ''),('UA-791706-46', ''), ('google_ad_client = "google_ad_client";', 'google_ad_client = "pub-1763218455048936";'),)

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
