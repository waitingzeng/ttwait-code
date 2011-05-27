#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
import re
SITE = 'http://www.101waystomakemoney.com'

REPLACE = (
    ('http://www.101waystomakemoney.com', 'http://101waysmakemoney.appspot.com'), 
    ('www.101waystomakemoney.com', 'http://101waysmakemoney.appspot.com'), 
    ('pub-5210272173716051', 'pub-2153651206088577'), 
    ('6575576254', '5886393784'),
    ('3882528073', '8158724156'),    
    ('2073861567', '3749411169'),
    ('9552845833', '3749411169'), #160*600
    ('2620788732', '9838282586'), 
    ('4800047081', '9838282586'), 
    ('6934787687', '9838282586'),
    ('UA-215342-5', 'UA-791706-37'),
    ('/cambridgebusinessacademy', 'http://make-money-home.appspot.com'),
    ('/easycash4life', 'http://make-money-home.appspot.com'),
    ('/makingmoneyonline', 'http://make-money-home.appspot.com'),
    ('/micronichefinder', 'http://make-money-home.appspot.com'),
    ('/faststreamofmoney', 'http://make-money-home.appspot.com'),
    ('/LinkWrap4Cash', 'http://make-money-home.appspot.com'),
    ('/profitsgenerated', 'http://make-money-home.appspot.com'),
    ('/bigforexcash', 'http://make-money-home.appspot.com'),
    ('/gdimarketing', 'http://make-money-home.appspot.com'),
    ('/2makemoneyonline', 'http://make-money-home.appspot.com'),
    ('<a href="http://www.101waystomakemoney.com/add-your-link/">Click Here To Add Your Link To This List</a>', ''),
    ('http://101waysmakemoney.appspot.com/howtomakemoneyonlinenow', 'http://make-money-home.appspot.com')
    
)

funcs = []
def func1(content):
    key1 = '<div id="ad-buttons">'
    key2 = '<!--/widget-->'
    b = content.find(key1)
    if b == -1:
        return content
    b = b+len(key1)
    e = content.find(key2, b)
    content = content.replace(content[b:e],'')
    return content
funcs.append(func1)
    
def func2(content):
    key1 = '<div id="mpu_banner">'
    key2 = '</div>'
    b = content.find(key1)
    if b == -1:
        return content
    b = b+len(key1)
    e = content.find(key2, b)
    content = content.replace('<div id="mpu_banner">'+content[b:e]+'</div>','')
    return content
funcs.append(func2)

def func3(content):
    key1 = '<div class="sideTabs">'
    key2 = '<!--/sideTabs-->'
    b = content.find(key1)
    if b == -1:
        return content
    b = b+len(key1)
    e = content.find(key2, b)
    body = content[b:e]
    body2 = re.sub(r'href="[^"]*"', 'href="http://make-money-home.appspot.com"', body)
    content = content.replace(body, body2)
    return content
funcs.append(func3)



class MainHandler(webapp.RequestHandler):
    def get(self):
        s = str(globals())
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write(s)
            

def main():
    application = webapp.WSGIApplication([('/config.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)
