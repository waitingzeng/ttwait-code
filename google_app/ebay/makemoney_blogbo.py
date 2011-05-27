#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'http://make-money-home.appspot.com'

REPLACE = (('UA-791706-31', ''), ('pub-2153651206088577', 'pub-4574844248705353'), ('0921636798', '0708592542'), ('4376749062', '6740947504'), ('5539546892', '3608484648'))

funcs = []



class MainHandler(webapp.RequestHandler):
    def get(self):
        s = str(globals())
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write(s)
            

def main():
    application = webapp.WSGIApplication([('/config.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)
