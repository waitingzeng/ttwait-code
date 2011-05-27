#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'http://www.waystolotofmoney.com/'

REPLACE = (('www.waystolotofmoney.com', 'teachyoulearnmoney.appspot.com'),('UA-791706-40', ''), ('google_ad_client = "google_ad_client";', 'google_ad_client = "pub-6205819031364190";'),('101 Ways Make Money', 'Teach You Learn Money'),('101 Ways To Makes Money – Learn How To Make Money Online', 'Teach You Learn Make Money Easy Money Ways'),('101 Ways Makes Money – Learn How To Makes Money Online', 'Teach You Learn Make Money Easy Money Ways'), ('101 ways to Makes Money online', 'Teach You Learn Make Money'),('101 ways make money', 'Teach You Learn Money'))

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
