#! /usr/bin/env python
# coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from random import random, randint
from model import get_value, Image
from datetime import datetime, timedelta
from google.appengine.api import memcache

CACHETIME = 31104000

def get_img(name):
    query = Image.gql("WHERE name = :name ", name=name)
    results = query.fetch(1)
    if len(results) == 0:
        return None
    else:
        return results[0].value
    
def put_img(name, value):
    item = Image(name=name, value=value)
    item.put()
    
    
class MainHandler(webapp.RequestHandler): 
    HtohHdrs= ['connection', 'keep-alive', 'proxy-authenticate',
                       'proxy-authorization', 'te', 'trailers',
                       'transfer-encoding', 'upgrade']
        

    def fetchurl(self, url):
        if url.find('?') != -1:
            url = '%s&%s' % (url,random())
        else:
            url = '%s?%s' % (url,random())
        for _ in range(3):
            try:
                resp = urlfetch.fetch(url)
                return resp
            except Exception, info:
                continue
        else:
            raise info
    
    def setHeader(self, page):
        for header in page.headers:
            if header.strip().lower() in self.HtohHdrs:
                continue
            
            self.response.headers[header] = page.headers[header]
    
    def set_status(self, status_code):
        self.response.set_status(status_code, self.response.http_status_message(status_code))
    
    
    def get(self, url=''):
        if url == 'clearpic':
            pics = Image.all()
            for pic in pics:
                pic.delete()
            self.response.out.write('clear %s' % len(pics))
            return
        if not url.endswith('.jpg'):
            self.set_status(404)
            return
        pic = url[:-4]
        page = get_img(pic)
        if page is None:
            item = get_value('pichost', 'http://pic.caatashoes.com')
            gourl = '%s/pic/%s' % (item, url)
            page = self.fetchurl(gourl)
            if page.status_code != 200:
                self.set_status(page.status_code)
                self.setHeader(page)
                self.response.out.write(page.content)
                return
            else:
                page = page.content
                put_img(pic, page)
        self.set_status(200)
        self.response.headers['content-type'] = 'image/jpeg'
        self.response.headers['cache-control'] = str(CACHETIME)
        a = datetime.today()
        a += timedelta(seconds=31104000)
        self.response.headers['expires'] = a.strftime('%a, %d %b %Y %X GMT')
        self.response.headers['accept-ranges'] = 'bytes'
        self.response.out.write(page)
        
    
        
    def post(self, url=None):
        return self.get(url)

def main():
    application = webapp.WSGIApplication([('/picture/(.*)', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
