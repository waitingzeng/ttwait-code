#! /usr/bin/env python
# coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from google.appengine.api import memcache
from random import random
import config

class MainHandler(webapp.RequestHandler): 
    def get(self, url=None):
        content = """<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>%s</title>
</head>
<frameset cols="*" frameborder="NO" border="0" framespacing="0">
<frame src="%s">
</frameset>
</html>
""" % (config.SITE, config.SITE)
        self.response.out.write(content)
            
            

def main():
    application = webapp.WSGIApplication([('/(.*)', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
