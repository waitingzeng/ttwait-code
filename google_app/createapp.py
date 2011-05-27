#! /usr/bin/env python
#coding=utf-8
from singleWeb import singleWeb
from text import getIn, escape, RndStr, getHidden, getInList
import urllib
import re
import urllib2
from storage import Storage
import sys
from httplib import HTTPConnection
HTTPConnection.debuglevel = 0

class CreateApp:
    DEBUG = False
    domain = 'gmail.com'
    loginUrl = 'https://appengine.google.com'
    loginPostUrl = 'https://www.google.com/accounts/ServiceLoginAuth?service=ah&sig=d71ef8b8d6150b23958ad03b3bf546b7'
    loginSuccessKey = 'CheckCookie?continue='
    SendMuti = True
    URL_GMAIL = 'https://appengine.google.com/_ah/login/continue?https://appengine.google.com/&ltmpl=ae&sig=c24697718eec1be75b7ab8f8a0c02416'
    ACTION_TOKEN_COOKIE = "GMAIL_AT"
    
    def __init__(self, name, psw):
        self.web = singleWeb()
        self.name = name
        self.psw = psw
        self.params = Storage()
    
    
    def _buildURL(self, **kwargs):
        return "%s%s" % (self.URL_GMAIL, urllib.urlencode(kwargs))
    
    def getLoginData(self, data):
        all = getHidden(data)
        all.update({
            'Email' : self.name,
            'Passwd' : self.psw,
            'rmShown' : '0',
        })
        return all

    def _getActionToken(self):
        at = self.web.GetCookies(self.ACTION_TOKEN_COOKIE)
        if at is None:    
            params = {'search' : 'inbox',
                  'start': 0,
                  'view': 'tl',
                  }
            self.web.GetPage(self._buildURL(**params))

            at = self.web.GetCookies(self.ACTION_TOKEN_COOKIE)
        return at
    
    def checkLoginSuccess(self, result):
        if self.DEBUG:
            if result:
                file('logindebug.html', 'w').write(result)
        if self.loginSuccessKey and result.find(self.loginSuccessKey) != -1:
            return True
        if self.loginBlockKey and result.find(self.loginBlockKey) != -1:
            return False
        return False
    
    
    def getLoginHeader(self, data):
        return {'referer' : self.loginUrl}
    
    
    def loginSuccess(self, data):
        RE_PAGE_REDIRECT = 'CheckCookie\?continue=([^"\']+)' 
        try:
            link = re.search(RE_PAGE_REDIRECT, data).group(1)
            redirectURL = urllib2.unquote(link)
            redirectURL = redirectURL.replace('\\x26', '&')
        
        except AttributeError:
            return False
        pageData = self.web.GetPage(redirectURL)
        g = getIn(pageData, 'var GLOBALS=[,,', ',,')
        if g is None:
            return False
        self.GLOBALS = eval('[%s]' % g)
        return True
    
    def login(self):
        res = self.web.GetPage(self.loginUrl)
        if res is None:
            print 'login:get %s fail' % self.loginUrl
            return False
        self.loginPostUrl = getIn(res, 'action="', '"').replace("&amp;", '&')
        data = self.getLoginData(res)
        if data is None:
            return False
        header = {
            'referer' : self.web.resp.url
        }
        res = self.web.GetPage(self.loginPostUrl, data, header)
        if res is None:
            print 'login:post %s fail' % self.loginPostUrl
            return False
        respurl = self.web.url
        print respurl
        if respurl.find("accounts/CheckCookie") != -1:
            url = getIn(res, 'location.replace("', '"')
            url = url.replace('\\x3d', '=').replace('\\x26', '&')
            res = self.web.GetPage(url)
            if self.web.resp.url.find('appengine.google.com') != -1:
                return True
        elif respurl.find('https://appengine.google.com') != -1:
            return True
        else:
            return False
    
    def loadApp(self):
        url = 'https://appengine.google.com/'
        page = self.web.GetPage(url)
        if page is None:
            return []
        appids = getInList(page, 'app_id=', '"')
        return appids
    
    def createApp(self, appid=None):
        url = 'https://appengine.google.com/start/createapp'
        res = self.web.GetPage(url)
        if appid is None:
            appid = RndStr(11)
        data = getHidden(res)
        data.update({
            'app_id' : appid,
            'title' : appid,
            'tos_accept' : 'on',
            'auth_domain' : '',
            'auth_config' : 'google',
            'submit' : 'Create Application',
        })
        posturl = "https://appengine.google.com/start/createapp.do"
        res = self.web.GetPage(posturl, data, headers={'referer' : url})
        if res is None:
            return False
        file('a.html', 'w').write(res)
        
        if self.web.resp.url.find('/start/createapp_success?app_id=%s' % appid) != -1:
            return appid
        else:
            if str(res).find('Cannot create any more apps') != -1:
                raise 'Limit'
            return False

str_base = """temp = %(app)s
config = {'name' : '%(mail)s', 'password' : '%(psw)s'}
for k in temp:
    apps[k] = config
    
    
"""
#str_base = "emails[%(mail)s] = %(app)s\n\n"

def createmany():
    for i, line in enumerate(file('account.txt')):
        print i, 'begin'
        create(line)

def create(name):
    fail = file('fail.txt', 'a')
    appfile = file("apps.txt", 'a')
    line = name.strip()
    if not line:
        return
    if line.find('----') != -1:
        name, psw = line.split('----')
    else:
        name = line
        psw = 'shoes.com.888'
    app = CreateApp(name, psw)
    
    temp = []
    if app.login():
        print name, 'login success'
        i = 0
        while len(temp) < 10:
            appid = RndStr(14)
            try:
                if app.createApp(appid):
                    print i, name, appid, 'create success'
                    temp.append(appid)
                else:
                    print i, name, appid, 'create fail'
            except Exception, info:
                temp = app.loadApp()
            i += 1
        appfile.write(str_base % {'app' : str(temp), 'mail' : name, 'psw' : psw})
        appfile.flush()
    else:
        print name, 'login fail'
        fail.write('%s\n' % line)
        fail.close()
    appfile.close()

def check():
    from apps import apps
    accounts = dict([(x['name'], x['password']) for x in apps.values()])
    fail = file('fail.txt', 'a')
    for name, psw in accounts.items():
        app = CreateApp(name, psw)
        if app.login():
            print name, 'login success'
        else:
            print name, 'login fail'
            fail.write('%s----%s\n' % (name, psw))
            fail.flush()

if __name__ == '__main__':
    if len(sys.argv) == 1:
        createmany()
    else:
        create(sys.argv[1])
    #check()