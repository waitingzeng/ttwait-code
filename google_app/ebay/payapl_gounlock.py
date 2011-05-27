#! /usr/bin/env python
#coding=utf-8
import wsgiref.handlers
from google.appengine.ext import webapp

SITE = 'https://www.gounlock.com/'
MYSITE = 'http://caatainc1.appspot.com'

REPLACE = (('https://www.gounlock.com', ''),('www.gounlock.com', ''), ('GoUnlock.com', 'Online-China-Shop.com'), ('SkyStarTrade', 'OnlineChinaShop'),('UA-1246150-8', ''), ('design/logo.jpg', 'http://pic.caatashoes.com/logo/china.jpg'),('San Francisco Bay Area, CA, USA', '1190 north east avenue vineland New Jersey 08360 USA'),('415 320 0800(9AM to 8PM)','856-982-6566'), ('650 796 9090 (10AM to 8PM) - Ben or Alan', '856-982-6566'), ('skystartrade@sbcglobal.net', 'admin@online-china-shop.com'), ('415 656 4419', '856-982-6968'), ('SkyStar_Trade', 'OnlineChinaShop'), ('235-473-084', '285-483-084'), ('100.1574117', '100.1974917'),('scripts/', '%s/scripts/' % MYSITE), ('design/', '%s/design/' % MYSITE), ('stil.css', '%s/stil.css' % MYSITE), ('thumb.php?', '%s/thumb.php?' % MYSITE), ('/favicon.ico', '%s/favicon.ico' % MYSITE), ('/gounlocklive/', '%s/gounlocklive/' % MYSITE), ('/gounlocklive/js/', '%s/gounlocklive/js/' % MYSITE))


NOURL = ['cart.php', 'order.php', 'registration.php', 'login.php']
REDIRECTURL = []
funcs = []


class MainHandler(webapp.RequestHandler):
    def get(self):
        s = str(globals())
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write(s)
            

def main():
    application = webapp.WSGIApplication([('/config.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)
