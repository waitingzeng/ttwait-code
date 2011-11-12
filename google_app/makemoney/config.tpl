#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'http://%(from_site)s/'

REPLACE = (
    ('%(from_site)s', '%(to_site)s'),
    ('UA-791706-40', '%(analy_id)s'), 
    ('UA-791706-42', '%(analy_id)s'), 
    ('UA-791706-46', '%(analy_id)s'), 
    ('google_analy_id', '%(analy_id)s'), 
    ('google_ad_client = "google_ad_client";', 
    'google_ad_client = "%(google_ad_client)s";'),
)

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
