#! /usr/bin/env python
# coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from google.appengine.api import memcache
from random import random, randint
from model import get_item, get_value
from datetime import datetime, timedelta
from apps import getApp
import httplib
httplib.HTTPConnection.debuglevel = 1

def getIn(data, b, e=None, start=0, flag=False):
    if data is None:
        return None
    b1 = data.find(b, start)
    if b1 == -1:
        return None
    b1 += len(b)
    if e is None:
        return data[b1:]
    e1 = data.find(e, b1)
    if e1 == -1:
        if flag:
            return data[b1:]
        return None
    return data[b1:e1]


DOMAIN_SITE = {
    'loveweshop-1.com' : 'http://www.loveweshop.com',
    'mallsbiz.com' : 'http://www.mallsbiz-1.com',
    'zone4y.com' : 'http://www.zone4y-1.com',
    'factoriesstore.com' : 'http://www.factoriesstore-1.com',
    'onlinefashional.com' : 'http://www.onlinefashional-01.com',
    'zonesbrand.com' : 'http://www.zonesbrand-1.com',
    'mallbrand.com' : 'http://www.wmallcn.com',
    'caatainc.cn' : 'http://www.caataltd.com',
    'mall-brand.cn' : 'http://www.wmallcn.com',
    'littlefox000' : 'http://www.mall-shoes.com',
    'littlefox001' : 'http://www.trade-qqq.com',
    'littlefox002' : 'http://www.caataltd.com',
    '_1' : 'http://www.scock.com',
    '_2' : 'http://www.mall-shoes.com',
    '_3' : 'http://www.trade4online.com',
    '_4' : 'http://www.kf-trade.com'
}
block_referer = ['hostgasum', ]
CACHETIME = 31104000

VERIFI_DICT = {
'y_key_' : """<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
            <HTML>
            <HEAD>
            <META name="y_key" value="{key}">
            <TITLE>
            </TITLE>
            </HEAD>
            <BODY>
            </BODY>
            </HTML>""",
            
'google' : """google-site-verification: google{key}.html"""
}


def get_url(request):
    if len(DOMAIN_SITE) == 0:
        return None
    host = request.environ['SERVER_NAME']
    for k, v in DOMAIN_SITE.items():
        if host.endswith(k):
            return v
    
    if host.endswith('appspot.com'):
        for k, v in DOMAIN_SITE.items():
            if host.startswith(k):
                return v
    allurls = get_item('allurls')
    if allurls.value == 'default':
        allurls = DOMAIN_SITE.values()
    else:
        allurls = allurls.value.split(';')
    allurls = list(set(allurls))
    url = allurls[randint(0, len(allurls)-1)]
    return url
    

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
        
        #headers = {'Cookie' : self.request._environ['HTTP_COOKIE']} 
        #if data:
        #    headers['Content-Type'] = 'application/x-www-form-urlencoded'
        
        for _ in range(3):
            try:
                resp = urlfetch.fetch(url, data, method)
                return resp
            except Exception, info:
                continue
        else:
            raise info
    
    def setHeader(self, page):
        for header in page.headers:
            if header.strip().lower() in self.HtohHdrs:
                continue
            #print header.strip().lower()
            self.response.headers[header] = page.headers[header]
    
    def set_status(self, status_code):
        self.response.set_status(status_code, self.response.http_status_message(status_code))
    
    def copy_get(self, url, config):
        if url == 'flushcache':
            memcache.flush_all()
            self.response.out.write('cache clear')
            return
        if url.endswith('.html'):
            for k, v in VERIFI_DICT.items():
                if url.startswith(k):
                    key = getIn(url, k, '.html')
                    res = v.replace('{key}', key)
                    self.response.out.write(res)
                    return
    
        if hasattr(config, 'NOTURL') and url in config.NOTURL:
            gourl = config.SITE
        else:
            gourl = '%s/%s' % (config.SITE, url)
            if self.request.query_string:
                gourl = '%s?%s' % (gourl, self.request.query_string)

        REDIRECTURL = getattr(config, 'REDIRECTURL', None)
        if url and REDIRECTURL and (url in REDIRECTURL or (REDIRECTURL == '*' and url[-4:] in ('.php', '.asp', 'html',))):
            self.set_status(301)
            self.response.headers['Location'] = str(gourl)
            return
        
        item = get_item(name='open_post', value='0')
        if item.value == '1':
            origPostData = self.request.body
        else:
            origPostData = None
        page = memcache.get(gourl)
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
        
        self.setHeader(page)
            
        self.response.out.write(page.content)
    
    
    def cachePic(self, url):
        referer = self.request.referer
        if referer:
            for s in block_referer:
                if referer.find(s) !=-1:
                    self.set_status(404)
                    return
                
            
        if not url.startswith('pic') or not url.endswith('.jpg'):
            self.set_status(404)
            return
        pic = url[4:-4]
        app = get_value(pic, getApp())
        self.set_status(301)
        self.response.headers['Location'] = str('http://%s.appspot.com/picture/%s.jpg' % (app, pic))
        
    
    def get(self, url=None):
        item = get_item(name='type')
        if item.value == 'default':
            url = get_url(self.request)
            return self._redirect(url)
        elif item.value == 'piccache':
            self.cachePic(url)
        elif item.value == 'site':
            sitename = get_item(name='sitename', value='wmallcn')
            import oldsitedefault as config
            config.SITE = 'http://www.%s.com' % sitename.value
            #config.REPLACE = (('/pic/', 'http://littlefox010.appspot.com/pic/',),)
            config.funcs = []
            self.copy_get(url, config)
        else:
            config = __import__(item.value)
            self.copy_get(url, config)
        
    def post(self, url=None):
        return self.get(url)
            

def main():
    application = webapp.WSGIApplication([('/(.*)', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
