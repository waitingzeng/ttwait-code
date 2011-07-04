#! /usr/bin/env python
# coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from google.appengine.api import memcache
from random import random, randint
from model import get_item, get_value
from datetime import datetime, timedelta


class MainHandler(webapp.RequestHandler): 
    HtohHdrs= ['connection', 'keep-alive', 'proxy-authenticate',
                       'proxy-authorization', 'te', 'trailers',
                       'transfer-encoding', 'upgrade']
        
    
    def _redirect(self, url = None):
        if url is None:
            return
        content = """<meta http-equiv="refresh" content="0;url=%s">""" % url
        self.response.out.write(content)
    
    def fetchurl(self, url, data=None):
        if url.find('?') != -1:
            url = '%s&%s' % (url,random())
        else:
            url = '%s?%s' % (url,random())
        method = urlfetch.GET
        if data is not None:
            method = urlfetch.POST
        
        headers = {}
        if 'HTTP_COOKIE' in self.request._environ:
            
            headers['Cookie'] = self.request._environ['HTTP_COOKIE'].replace(',', ';')
            
        if data:
            headers['Content-Type'] = 'application/x-www-form-urlencoded'
        for _ in range(3):
            try:
                resp = urlfetch.fetch(url, data, method, headers, False, False)
                return resp
            except Exception, info:
                continue
        else:
            raise info
    
    def setHeader(self, page, config=None):
        for header in page.headers:
            newheader = header.strip().lower() 
            if newheader in self.HtohHdrs:
                continue
            
            value = page.headers[header]
            if newheader == 'location':
                value = value.replace(config.SITE, '')
            
            #print header.strip().lower()
            self.response.headers[header] = value
    
    def set_status(self, status_code):
        self.response.set_status(status_code, self.response.http_status_message(status_code))
    
    def copy_get(self, url, config):
        if url == 'flushcache':
            memcache.flush_all()
            self.response.out.write('cache clear')
            return
       
        if hasattr(config, 'NOTURL') and url in config.NOTURL:
            gourl = config.SITE
        else:
            gourl = '%s/%s' % (config.SITE, url)
            if self.request.query_string:
                gourl = '%s?%s' % (gourl, self.request.query_string)

        origPostData = self.request.body
        page = None#memcache.get(gourl)
        if page is None or origPostData is not None:
            page = self.fetchurl(gourl, origPostData)
            ext = url.rsplit('\\.', 1)[-1].lower()
            if ext not in ['gif', 'jpg', 'png', 'bmp']:
                for k,v in config.REPLACE:
                    page.content = page.content.replace(k,v)
                for func in config.funcs:
                    if callable(func):
                        page.content = func(page.content)
            if len(page.content) < 500000 and origPostData is None:
                memcache.set(gourl, page, 864000)
        self.set_status(page.status_code)
        
        self.setHeader(page, config)
            
        self.response.out.write(page.content)
    
    
    def get(self, url=None):
        sitename = get_item(name='sitename', value='wmallcn')
        import oldsitedefault as config
        config.SITE = 'http://phpven.com'#'http://www.%s.com' % sitename.value
        config.REPLACE = (('/pic/', 'http://littlefox010.appspot.com/pic/',),)
        config.funcs = []
        config.REDIRECTURL = None
        self.copy_get(url, config)
        
    def post(self, url=None):
        return self.get(url)
            

def main():
    application = webapp.WSGIApplication([('/(.*)', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
