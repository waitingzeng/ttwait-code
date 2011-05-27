#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from random import random, randint
from model import get_value, Image
from datetime import datetime, timedelta
import urlparse


def getIn(data, b, e=None, start=0, flag=False):
    if data is None:
        return None
    b1 = data.find(b, start)
    if b1 == -1:
        return None
    b1 += len(b)
    if e is None:
        return data[b1:]
    if isinstance(e, list):
        e1 = -1
        for i in range(b1 + 1, len(data)):
            if data[i] in e:
                e1 = i
                break
        
    else:
        e1 = data.find(e, b1)
    if e1 == -1:
        if flag:
            return data[b1:]
        return None
    return data[b1:e1]


def getInList(data, b, e, start=0):
    if data is None:
        return
    while True:
        b1 = data.find(b, start)
        if b1 == -1:
            return
        b1 += len(b)
        e1 = data.find(e, b1)
        if e1 == -1:
            return
        yield data[b1:e1]
        start = e1


def getHidden(page):
    return getInput(page)

def getInput(page, type='hidden'):
    data = {}
    for input in getInList(page, '<input', '>'):
        t = trim(getIn(input, 'type=', [' ', "'", '"']))
        if not t:
            continue
        if t != type:
            continue
        name = trim(getIn(input, 'name=', [' ', "'", '"']))
        value = trim(getIn(input, 'value=', [' ', "'", '"']))
        if name is None:
            continue
        if value is None:
            value = ''
        data[name] = value
    return data

def trim(url):
    if not url:
        return url
    return url.strip(' \'"')

def _parse(baseurl, content, output):
    content = content.lower()
    links = []
    for link in getInList(content, '<a', '</a>'):
        href = trim(getIn(link, 'href=', [' ', "'", '"']))
        if not href or href=='#' or href[-4:] in ('.jpg', '.png', '.gif', '.xml'):
            continue
        url = urlparse.urljoin(baseurl, href)
        if url == baseurl:
            continue
        output.append(url)
    
    hadform ='0'
    for form in getInList(content, '<form', '</form>'):
        hadform = '1'
        password = getInput(form, 'password')
        if password:
            hadform = '3'
            continue
        textarea = getInList(form, '<textarea', '</textarea>')
        if textarea:
            hadform = '2'
    output.append(hadform)
    
    
class MainHandler(webapp.RequestHandler): 
    HtohHdrs= ['connection', 'keep-alive', 'proxy-authenticate',
                       'proxy-authorization', 'te', 'trailers',
                       'transfer-encoding', 'upgrade']
        

    def fetchurl(self, url):
        for _ in range(3):
            try:
                resp = urlfetch.fetch(url)
                return resp
            except Exception, info:
                continue
        else:
            raise info
    
    def set_status(self, status_code):
        self.response.set_status(status_code, self.response.http_status_message(status_code))
    
    
    def get(self, params=''):
        self.response.headers['Content-Type'] = 'text/plain'
        self.set_status(200)
        output = []
        try:
            geturl = self.request.get('url', None)
            if not geturl:
                return
            page = self.fetchurl(geturl)
            output.append('%s' % page.status_code)
            if page.status_code != 200:
                return
            _parse(geturl, page.content, output)
            
        except Exception, e:
            output.append('000')
            output.append('%s' % e)
        self.response.out.write(';'.join(output))

def main():
    application = webapp.WSGIApplication([('/crawl.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
