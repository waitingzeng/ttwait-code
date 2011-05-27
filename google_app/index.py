#! /usr/bin/env python
#coding=utf-8
import urllib2
from cgi import escape
from urllib import unquote

SITE = 'http://caatainc1.appspot.com/'

def fetchurl(gourl):
    try:
        return urllib2.urlopen(gourl).read()
    except:
        return ''

HtohHdrs= ['connection', 'keep-alive', 'proxy-authenticate',
                       'proxy-authorization', 'te', 'trailers',
                       'transfer-encoding', 'upgrade']
def index(req):
    url = req.args.replace('index.py?', '').replace('index.py&', '').replace('&', '?', 1)
    gourl = '%s%s' % (SITE, url)
    resp = urllib2.urlopen(gourl)
    data = resp.read()
    for k, v in resp.headers.dict.items():
        if k.strip().lower() in HtohHdrs:
            continue
        req.headers_out.add(k,  v)
    return data


def index2(req):
   s = """\
<html><head>
<style type="text/css">
td {padding:0.2em 0.5em;border:1px solid black;}
table {border-collapse:collapse;}
</style>
</head><body>
<table cellspacing="0" cellpadding="0">%s</table>
</body></html>
"""
   attribs = ''

   # Loop over the Request object attributes
   for attrib in dir(req):
      attribs += '<tr><td>%s</td><td>%s</td></tr>'
      attribs %= (attrib, escape(unquote(str(req.__getattribute__(attrib)))))

   return s % (attribs)
                                   
