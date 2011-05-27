#! /usr/bin/env python
# coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from google.appengine.api import memcache
from random import random
#from model import get_item, get_value
import Cookie
import config


HEADERS = {
    'User-Agent' : 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7 GTB6',
    'Accept' : 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Language' : 'zh-cn,zh;q=0.5',
    'Accept-Encoding': 'gzip,deflate',
    'Accept-Charset' : 'GB2312,utf-8;q=0.7,*;q=0.7',
    'Keep-Alive' : '300',
    'Connection' : 'keep-alive',
    'Cache-Control' : 'max-age=0',
    
}

def make_cookie_header(cookie):
    ret = ""
    for val in cookie.values():
        ret+="%s=%s; " % (val.key, val.value)
    return ret   

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
        
        headers = HEADERS
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
            
            if newheader == 'set-cookie':
                cookie = Cookie.SimpleCookie(page.headers.get('set-cookie', ''))
                for val in cookie.values():
                    self.response.headers.add_header(newheader, val.OutputString())
                
                continue

            self.response.headers.add_header(header, value)
    
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
        
        ext = url.rsplit('.', 1)[-1].lower()
        if ext in ['gif', 'jpg', 'png', 'bmp', 'css', 'js', 'ico']:
            self.redirect(gourl, True)
            return

        origPostData = self.request.body
        if origPostData:
            page = None
        else:
            page = memcache.get(gourl)
        
        incache = True
        canCache = config.checkCache(url, gourl)
        if not canCache or page is None:
            incache = False
            try:
                page = self.fetchurl(gourl, origPostData)
            except:
                content = """<p>I am very sorry, Now Show This Page Had Some Problem, Please Wait A Moment! Thank You!</p>
                <p>Now Redirect To <a href="/">Home</a></p>
                <script language="javascript">
                setTimeout(function(){
                    location.href = "/";
                }, 10)
                </script>
                """
                self.response.out.write(content)
                return
            
            for k,v in config.REPLACE:
                page.content = page.content.replace(k,v)
            for func in config.funcs:
                if callable(func):
                    page.content = func(page.content)
                    
            if len(page.content) < 500000 and canCache:
                memcache.set(gourl, page, 864000)
        self.set_status(page.status_code)
        
        self.setHeader(page, config)
    
        self.response.out.write(page.content)
        #self.response.out.write(incache and 'incache' or 'not in cache')
    
    def get(self, url=None):
        self.copy_get(url, config)
        
    def post(self, url=None):
        return self.get(url)
            

def main():
    application = webapp.WSGIApplication([('/(.*)', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
