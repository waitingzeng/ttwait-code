#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from model import get_item

class MainHandler(webapp.RequestHandler):
    def get(self):
        item = get_item('type')
        if item.value == 'site':
            from oldsitedefault import NOURL, NOTREPLACEEXT, REDIRECTURL
        else:
            try:
                config = __import__(item.value)
            except ImportError:
                msg = 'not a site'
        s = str(globals()) + str(locals())
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write(s)
        

def main():
    application = webapp.WSGIApplication([('/config.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)
