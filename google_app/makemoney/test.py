#! /usr/bin/env python
# coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import urlfetch
from google.appengine.api import memcache
from random import random
import config as default_config
import logging
import re
import json
import model

class Storage(dict):
    def __getattr__(self, key):
        try:
            return self[key]
        except KeyError, k:
            raise AttributeError, k

    def __setattr__(self, key, value):
        self[key] = value

    def __delattr__(self, key):
        try:
            del self[key]
        except KeyError, k:
            raise AttributeError, k



default_config_url = 'http://ttwait.sinaapp.com/getconfig?appid=money-now-79'
#default_config_url = 'http://localhost:9000/getconfig'
query_r_re = re.compile('[&|?]*r=[^&]*', re.I)
memcache_timeout = 259200
class MainHandler(webapp.RequestHandler):
    HtohHdrs= ['connection', 'keep-alive', 'proxy-authenticate',
                   'proxy-authorization', 'te', 'trailers',
                   'transfer-encoding', 'upgrade']
    
    def get_config_url(self):
        config_url = memcache.get('config_url')
        if not config_url:
            item = model.get_item('config_url',  default_config_url)
            config_url = item.value
            memcache.set('config_url', config_url, memcache_timeout)
        return config_url
    
    def get_config(self, config_url=default_config_url):
        #config_url = self.get_config_url()
        logging.error('config url %s', config_url)
        config = memcache.get(config_url)
        if not config:
            resp = self.fetchurl(config_url)
            if resp.status_code != 200:
                logging.error('config_url %s get fail', config_url)
                
                config = memcache.get(config_url + '_old')
                if config:
                    return Storage(config)
                return self.get_config()
            config = json.loads(resp.content)
            if not config['SITE'].startswith('http://'):
                config['SITE'] = 'http://' + config['SITE']
            if 'NOTREPLACEEXT' not in config:
                config['NOTREPLACEEXT'] = default_config.NOTREPLACEEXT
            
            if 'REDIRECTURL' not in config:
                config['REDIRECTURL'] = default_config.REDIRECTURL
            
            if 'NOURL' not in config:
                config['NOURL'] = default_config.NOURL
            
            if 'funcs' not in config:
                config['funcs'] = default_config.funcs
            
            memcache.set(config_url, config, memcache_timeout)
            memcache.set('config_url', config_url, memcache_timeout)
        memcache.set(config_url+'_old', config, memcache_timeout)
        return Storage(config)
    
    def fetchurl(self, url):
        logging.error(url)
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
        
    def nourl(self, config, url):
        if not config:
            return False
        for u in config.NOURL:
            if url.find(u) != -1:
                return True
        return False
        
    def get(self, url=None):
        if url == 'flushcache':
            memcache.flush_all()
            self.response.out.write('cache clear')
            return
        
        if self.request.host.count('.') > 2:
            remove_host = self.request.host.split('.')[:-3]
            remove_host.append('')
            remove_host = '.'.join(remove_host)
            gourl = self.request.uri.replace(remove_host, '')
            self.response.set_status(301, 'Moved Permanently')
            self.response.headers['Location'] = gourl
            return
            
            
        config = self.get_config(self.get_config_url())
        if url == 'getconfig':
            s = str(config)
            self.response.headers['Content-Type'] = 'text/plain'
            self.response.out.write(s)
            return
        
        if not config:
            return ''
        
        if self.nourl(config, url):
            self.response.set_status(404, 'Not Found')
            self.response.out.write('not data found')
            return
        gourl = '%s/%s' % (config.SITE, url)
        if self.request.query_string:
            try:
                float(self.request.query_string)
            except:
                query_string = query_r_re.sub('', self.request.query_string)
                if query_string:
                    gourl = '%s?%s' % (gourl, query_string)
        
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
                    for k,v in config.REPLACE.items():
                        page.content = page.content.replace(k,v)
                        for func in config.funcs:
                            if callable(func):
                                page.content = func(page.content)
                memcache.set(gourl, page, memcache_timeout)
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
