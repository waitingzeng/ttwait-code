#! /usr/bin/env python
#coding=utf-8
from singleweb import SingleWeb
from text import get_in,  get_hidden, iso_to_char, get_in_list
import httplib
import urllib
import time
from log import LogBase
import sys
import logging
httplib.HTTPConnection.debuglevel = 0

class DisabledException(Exception):pass
class AuthFailException(Exception):pass

class MSNLive(LogBase):
    APP_URL = 'http://profile.live.com/'
    def __init__(self, name, psw):
        LogBase.__init__(self, name)
        self.web = SingleWeb()
        self.name = name
        self.psw = psw

    def login(self, *args, **kwargs):
        try:
            return self._login(*args, **kwargs)
        except:
            return False

    def do_submit(self, page):
        form = get_in(page, '<form name="fmHF" id="fmHF"', '</form>')
        if form is None:
            return page
        action = get_in(form, 'action="', '"')
        data = get_hidden(form)

        page = self.web.get_page(action, data, {'referer' : self.web.url})
        return page

    def get_auto_refresh_url(self, page):
        page = page.lower()
        noscript = get_in(page, '<noscript>', '</noscript>')
        if not noscript:
            return None
        for meta in get_in_list(noscript, '<meta', '/>'):
            equiv = get_in(meta, 'http-equiv="', '"')
            if equiv and equiv == 'refresh':
                refresh = get_in(meta, 'content="', '"')
                ii = refresh.find(";")
                if ii != -1:
                    pause, newurl_spec = float(refresh[:ii]), refresh[ii+1:]
                    jj = newurl_spec.find("=")
                    if jj != -1:
                        key, url = newurl_spec[:jj], newurl_spec[jj+1:]
                    if key.strip().lower() != "url":
                        continue
                else:
                    continue
                
                if pause > 1E-3:
                    time.sleep(pause)
                url = iso_to_char(url)
                return url
        return None
        

    def process_cookies(self):
        auth = self.web.get_cookies('RPSTAuth')
        if auth:
            self.web.clear_cookies()
            self.web.set_cookie_obj(auth)
            return
        return
    
    def active(self, login_page):
        data = {
            'ctl00$ctl00$MainContent$MainContent$LoginMain$iPwdEncrypted' : 'lFFvlCtVl8t5loh5/B6pLO9w98Rn0koyrbw7XxveR2TMxlKI6oZ+2Sjk2Tzlc5G++xvDYDxL2+lQjBxKvK5OyuWe5fsoz1sVgZ8jOEgQdHu1iiCOUZN8BZ50h6uLn2RGnbfjAmrXDs1sC7LH2BojoFERYcWK6khY+zdNol3ao5s=',
        'ctl00$ctl00$MainContent$MainContent$LoginMain$iPublicKey' : '1BEF90811CE78A99D0820E87F3BDF1F96622EB40',
       'ctl00$ctl00$MainContent$MainContent$LoginWrapper$LoginRepeater$ctl00$LoginOther$iEncryptedSecretAnswer' : 'HuGIQQaa2l8FUSnacZbzMm8zjDlX9po2hbGp3mAjLBELM16rOiNr8/870XoF3tLqoA8PsfwhlsJwVyEVVxAnJTYFaODxYCz861Vua6uDoUQjG1VFifpSBSSBPRY+5AiG139kNUZSPj+Uryuukx13mVAsj8TA/PGcHGH6P8Ae6Uw=',
        'ctl00$ctl00$MainContent$MainContent$LoginWrapper$LoginRepeater$ctl00$LoginOther$iQuestion' : '母亲的出生地点'
        }
        page = self.web.submit(login_page, data, name='aspnetForm')
        
        return page
    
    def _login(self, to = None, login_page=None):
            
        login_page = self.web.get_page(self.APP_URL)

        url = self.get_auto_refresh_url(login_page)
        logging.error('url %s', url)
        if url and url.find('cid-') != -1:
            return True
        
        if url:
            login_page = self.web.get_page(url)

        post_url = get_in(login_page, "srf_uPost='", "'")
        logging.error('post_url %s', post_url)
        data = get_hidden(login_page)
        data.update({'login' : self.name,
                'passwd' : self.psw,
                'NewUser' : '1',
                
        })

        #req = urllib2.Request(url, data=data, headers=headers)
        result = self.web.get_page(post_url, data=data)
        if result is None:
            return False
        if result.find('onload="javascript:DoSubmit();"') != -1:
            active_page = self.web.submit(result)
            result = self.active(active_page)

        url = self.get_auto_refresh_url(result)
        logging.error('finish %s', url)
        if url.find('profile.live.com/') != -1:
            #self.process_cookies()
            return True
        if self.web.url.lower().find('jsDisabled.srf') != -1:
            if result.find('action="https://security.live.com') != -1:
                self.error('Disable')
                raise DisabledException
            else:
                self.error('Auth Fail')
                raise AuthFailException
        return False
    
    
    def get_page(self, *args, **kwargs):
        res = self.web.get_page(*args, **kwargs)
        return self.auto_refresh(res)
        
    def auto_refresh(self, res):
        if res is None:
            return None
        lower_res = res.lower()
        if lower_res.find('onload="javascript:dosubmit();"') != -1:
            return self.web.submit(res)
            
        for meta in get_in_list(lower_res, '<meta', '/>'):
            if meta.find('http-equiv="refresh"') != -1:
                refresh = get_in(meta, 'content="', '"')
                ii = refresh.find(";")
                if ii != -1:
                    pause, newurl_spec = float(refresh[:ii]), refresh[ii+1:]
                    jj = newurl_spec.find("=")
                    if jj != -1:
                        key, newurl = newurl_spec[:jj], newurl_spec[jj+1:]
                    if key.strip().lower() != "url":
                        return res
                else:
                    return res
                
                if pause > 1E-3:
                    time.sleep(pause)
                newurl = iso_to_char(newurl)
                res = self.get_page(newurl)
                return res
        return res
            
            


if __name__ == '__main__':
    app = MSNLive(sys.argv[1], '846266')
    print app._login()
    file('a.txt', 'wb').write(app.web.cookies_to_str())
    
    #app.get_page('https://domains.live.com/')
