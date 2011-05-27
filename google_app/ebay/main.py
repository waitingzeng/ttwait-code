import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.api.urlfetch import fetch
from django.utils import simplejson
import re

MAILSEARCH = re.compile(r"(\w+([-+\.]\w+)*@\w+([-\.]\w+)*\.\w+([-\.]\w+)*)", re.I).findall
headers = {
    'Accept-Encoding' : 'gzip',
    'User-Agent' : 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)'
}
class MainPage(webapp.RequestHandler):
    def fetchurl(self, url):
        ex = None
        for i in range(3):
            try:
                page = fetch(url, headers=headers, allow_truncated=True)
                return page
            except Exception, e:
                ex = e
                continue
        if ex:
            raise e
        
    
    def get(self):  
        self.response.headers['Content-Type'] = 'text/plain'
        try:
            ids = self.request.get('ids', None)
            if not ids is None:
                page = self.fetchurl('http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=%s' % ids)
                self.response.out.write('%s;' % page.status_code)
                if page.status_code == 200:
                    mailItem = {}
                    #print page.content
                    maillist = MAILSEARCH(page.content)
                    for m in maillist:
                        mailItem[m[0].lower()] = 0
                    data = '\n'.join(mailItem.keys())
                    self.response.out.write(data)
                    return
        except Exception, e:
            self.response.out.write('000;%s' % e)
            return

def main():  
    application = webapp.WSGIApplication(
                                [('/main.py', MainPage)],
                                debug=True)
    wsgiref.handlers.CGIHandler().run(application)
    
if __name__ == "__main__":  
    main()