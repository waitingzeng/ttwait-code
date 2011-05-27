from google.appengine.api import mail
import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api import users
import re
from google.appengine.ext.webapp.util import login_required
from google.appengine.api.urlfetch import fetch
from random import randint
from google.appengine.api import memcache

def notHtmlTags(htmlText, repl=' '):
    return re.sub(r"<[^>]*>", repl, htmlText)


class MainPage(webapp.RequestHandler):
    def get(self):
        self.response.headers['Content-Type'] = 'text/plain'
        kw = {}
        kw['sender']= self.request.get('sender', None)
        #kw['sender']= users.get_current_user().email()
        kw['to'] = self.request.get('to', None)
        
        kw['subject'] = self.request.get('subject', None)
        kw['body'] = self.request.get('body', None)
        kw['html'] = self.request.get('html', None)
        if kw['body'] is None:
            if kw['html'] is None:
                self.response.out.write('no body')
                return
            kw['body'] = notHtmlTags(kw['html'])
        kw['reply_to'] = self.request.get('reply_to', None)
        kw['cc'] = self.request.get('cc', None)
        kw['bcc'] = self.request.get('bcc', None)
        ks = kw.keys()
        for k in ks:
            if kw[k] is None:
                del kw[k]

        try:
            mail.send_mail(**kw)
        except Exception, info:
            self.response.out.write(str(info))
        else:
            self.response.out.write('success')
            
    def post(self):
        self.response.headers['Content-Type'] = 'text/plain'
        kw = {}
        kw['sender']= self.request.get('sender', None)
        kw['to'] = self.request.get('to', None)
        
        kw['subject'] = self.request.get('subject', None)
        kw['body'] = self.request.get('body', None)
        kw['html'] = self.request.get('html', None)
        if kw['body'] is None:
            if kw['html'] is None:
                self.response.out.write('no body')
                return
            kw['body'] = notHtmlTags(kw['html'])
        kw['reply_to'] = self.request.get('reply_to', None)
        kw['cc'] = self.request.get('cc', None)
        kw['bcc'] = self.request.get('bcc', None)
        ks = kw.keys()
        for k in ks:
            if kw[k] is None:
                del kw[k]

        try:
            mail.send_mail(**kw)
        except Exception, info:
            self.response.out.write(str(info))
        else:
            self.response.out.write('success')
        
        
    
def main():  
    application = webapp.WSGIApplication(
                                [('/mail.py', MainPage)],
                                debug=True)
    wsgiref.handlers.CGIHandler().run(application)
    
if __name__ == "__main__":  
    main()