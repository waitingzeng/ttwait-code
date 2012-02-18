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
        app = MSNPost(sender, psw)
        if app.login():
            return app.web.cookies_to_str()
        else:
            return ''
    
    def addfriend(self, sender, psw, to, cookie):
        if not sender or not psw:
            return ''
        app = MSNPost(sender, psw)
        app.web.make_req('https://profile.live.com')
        app.web.set_cookies(cookie)
        try:
            if app.add_friend(to):
                logging.info('%s add %s success', sender, to)
                return 'success'
            else:
                logging.error('%s add %s fail', sender, to)
                return 'fail'
        except Exception, info:
            logging.info('%s add %s %s get exception %s', sender, to, info.__class__.__name__)
            return info.__class__.__name__

    def get(self):
        self.response.headers['Content-Type'] = 'text/plain'
        write = self.response.out.write
        try:
            action = self.request.get('action', 'addfriend')
            sender = self.request.get('sender', None)
            if not sender:
                write('000;need sender')
                return
            psw = self.request.get('psw', '846266')
            if action == 'login':
                res = self.login(sender, psw)
                write('200;%s' % res)
            elif action == 'addfriend':
                cookie = self.request.get('cookie', None)
                if not cookie:
                    write('000;need cookie')
                    return
                to = self.request.get('to', None)
                if not to:
                    write('000;need to')
                    return
                res = self.addfriend(sender, psw, to, cookie)
                write('200;%s' % res)
                
        except Exception, e:
            write('000;%s' % e)
            return

    def post(self):
        return self.get()
        
def main():
    application = webapp.WSGIApplication(
                                [('/msn.py', MainPage)],
                                debug=True)
    wsgiref.handlers.CGIHandler().run(application)

if __name__ == "__main__":
    main()