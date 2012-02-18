import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api.urlfetch import fetch
from django.utils import simplejson
import re
from webmsnlib.msn_post import MSNPost
import logging

class MainPage(webapp.RequestHandler):
    def login(self, sender, psw):
        if not sender or not psw:
            return ''
        print 'begin login'
        app = MSNPost(sender, psw)
        if app.login():
            print 'login success'
            return app.web.cookies_to_str()
        else:
            print 'login fail'
            return ''
    
    def addfriend(self, sender, psw, to, cookie):
        if not sender or not psw:
            return ''
        logging.error('begin add')
        app = MSNPost(sender, psw)
        app.web.make_req('https://profile.live.com')
        app.web.set_cookies(cookie)
        try:
            if app.add_friend(to):
                logging.error('add success')
                return 'success'
            else:
                logging.error('add fail')
                return 'fail'
        except Exception, info:
            return info.__class__.__name__

    def get(self):
        self.response.headers['Content-Type'] = 'text/plain'
        try:
            action = self.request.get('action', None)
            if action == 'login':
                res = self.login(self.request.get('sender'), self.request.get('psw'))
                self.response.out.write('200;%s' % res)
        except Exception, e:
            self.response.out.write('000;%s' % e)
            return

    def post(self):
        self.response.headers['Content-Type'] = 'text/plain'
        try:
            action = self.request.get('action', None)
            cookie = self.request.get('cookie', None)

            if not cookie:
                self.response.out.write('000;need cookie')
                
            if action == 'addfriend':
                res = self.addfriend(self.request.get('sender'), self.request.get('psw'), self.request.get('to'), cookie)
                self.response.out.write('200;%s' % res)
        except Exception, e:
            self.response.out.write('000;%s' % e)
            return
        
def main():
    application = webapp.WSGIApplication(
                                [('/msn.py', MainPage)],
                                debug=True)
    wsgiref.handlers.CGIHandler().run(application)

if __name__ == "__main__":
    main()