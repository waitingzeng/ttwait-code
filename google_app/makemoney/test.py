#! /usr/bin/env python
# coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from google.appengine.api import memcache
from random import random
import config
import logging


class MainHandler(webapp.RequestHandler):
    HtohHdrs= ['connection', 'keep-alive', 'proxy-authenticate',
                   'proxy-authorization', 'te', 'trailers',
                   'transfer-encoding', 'upgrade']
    
    def fetchurl(self, url):
        #logging.info('fetchurl %s', url)
        #if url.find('?') != -1:
        #    url = '%s&%s' % (url,random())
        #else:
        #    url = '%s?%s' % (url,random())
        for _ in range(3):
            try:
                resp = urlfetch.fetch(url, deadline =10)
                return resp
            except Exception, info:
                continue
        else:
            raise info
        

    def post(self, url=None):
        gourl = '/'
        self.response.set_status(301, 'Moved Permanently')
        self.response.headers['Location'] = gourl
        
    def nourl(self, url):
        for u in config.NOURL:
            if url.find(u) != -1:
                return True
        return False
        
    def get(self, url=None):
        if url == 'flushcache':
            memcache.flush_all()
            self.response.out.write('cache clear')
            return
        
        if self.nourl(url):
            self.response.set_status(404, 'Not Found')
            self.response.out.write('not data found')
            return
        gourl = '%s/%s' % (config.SITE, url)
        #if self.request.query_string and not (len(self.request.query_string) == 13 and self.request.query_string.startswith('13')):
        #    gourl = '%s?%s' % (gourl, self.request.query_string)
        if url in config.REDIRECTURL:
            self.response.set_status(301, 'Moved Permanently')
            self.response.headers['Location'] = gourl
            
        else:
            gourl = gourl.lower()
            page = memcache.get(gourl)
            #page = None
            if page is None:
                page = self.fetchurl(gourl)
                ext = url.rsplit('.', 1)[-1]
                if ext not in config.NOTREPLACEEXT:
                    for k,v in config.REPLACE:
                        page.content = page.content.replace(k,v)
                        for func in config.funcs:
                            if callable(func):
                                page.content = func(page.content)
                memcache.set(gourl, page, 259200)
            self.response.set_status(page.status_code, self.response.http_status_message(page.status_code))
            
            for header in page.headers:
                if header.strip().lower() in self.HtohHdrs:
                    # don't forward
                    continue
                
                self.response.headers[header] = page.headers[header]
            self.response.out.write(page.content)
            
            

def main():
    application = webapp.WSGIApplication([('/(.*)', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
