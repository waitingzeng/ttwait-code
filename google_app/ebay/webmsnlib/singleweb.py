import urllib2
import urllib
import traceback
import gzip
from StringIO import StringIO
from ClientForm import ParseFile, ControlNotFoundError, ListControl
LG_DEBUG = True
import httplib
import time
import cPickle as pickle
from multipartposthandler import MultipartPostHandler
import cookielib

HEADERS = {
    'User-Agent' : 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7 GTB6',
    'Accept' : 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Language' : 'zh-cn,zh;q=0.5',
    'Accept-Encoding': 'gzip',
    'Accept-Charset' : 'GB2312,utf-8;q=0.7,*;q=0.7',
    'Keep-Alive' : '300',
    'Connection' : 'keep-alive',
    'Cache-Control' : 'max-age=0',

}

def get_page(url, data=None, headers={}, times=3):
    web = SingleWeb(proxy=proxy)
    req = web.make_req(url, data, headers)
    for i in range(times):
        data = web.get_page(req)
        if data:
            return data
    return None


class SingleWeb(object):
    def __init__(self, cookiejar=cookielib.CookieJar()):
        self.retry = 0
        self.resp = None
        self.opener = urllib2.build_opener()
        self.cookies = urllib2.HTTPCookieProcessor(cookiejar)
        self.opener.add_handler(self.cookies)
        self.default_cookies = None

    def debug(self, debug_level=1):
        httplib.HTTPConnection.debuglevel = debug_level

    def get_cookies(self, key):
        cookies = self.cookies.cookiejar._cookies
        for domain in cookies.keys():
            cookies_by_path = cookies[domain]
            for path in cookies_by_path.keys():
                cookies_by_name = cookies_by_path[path]
                if key in cookies_by_name.keys():
                    return cookies_by_name[key]

        return None

    def clear_cookies(self):
        self.cookies.cookiejar._cookies.clear()

    def set_cookie_obj(self, cookie):
        self.cookies.cookiejar.set_cookie(cookie)

    def set_cookie(self, name, value):
        cookie = self.cookies.cookiejar._cookie_from_cookie_tuple((name.strip(), value.strip(), {}, {}), self.req)
        self.set_cookie_obj(cookie)

    def set_cookies(self, cookies):
        for one in cookies.split(';'):
            self.set_cookie(*one.split('=', 1))

    def cookies_to_dict(self):
        cookies = self.cookies.cookiejar._cookies_for_request(self.req)
        return dict([(t.name,t.value) for t in cookies])

    def cookies_to_str(self):
        cookies = self.cookies.cookiejar._cookies_for_request(self.req)
        return ';'.join(['%s=%s' % (t.name, t.value) for t in cookies])

    def get_all_cookies(self):
        return pickle.dumps(self.cookies.cookiejar._cookies, 2)
    
    def set_all_cookies(self, cookies):
        self.cookies.cookiejar._cookies = pickle.loads(cookies)

    def get_headers(self, headers, req=None):
        for k,v in HEADERS.items():
            if k not in headers:
                headers[k] = v

        if 'referer' not in headers:
            headers['referer'] = self.url

        if req:
            for k, v in headers.items():
                req.add_header(k, v)
            return req
        else:
            return headers


    def make_req(self, url_or_request, data=None, headers={}, muti=False):
        if not isinstance(url_or_request, urllib2.Request):
            headers = self.get_headers(headers)
            self.resp = None
            self.req = urllib2.Request(url_or_request, headers=headers)
            if type(data) == dict:
                if muti:
                    mutipart = MultipartPostHandler()
                    mutipart.http_request(self.req, data)
                else:
                    data = urllib.urlencode(data)
                    self.req.add_data(data)
            else:
                if muti:
                    contenttype = 'multipart/form-data; boundary=---------------------------7d917724f0588'
                    self.req.add_unredirected_header('Content-Type', contenttype)
                else:
                    self.req.add_data(data)
        else:
           self.req = url_or_request
        return self.req

    def get_res(self, *args, **kwargs):
        error = False
        self.exception = None
        self.make_req(*args, **kwargs)
        if self.default_cookies:
            self.req.add_header('Cookie', self.default_cookies)
            #self.defaultcookies = None
        try:
            resp = self.opener.open(self.req)
            self.resp = resp
            self.retry = 0
            return self.resp
        except Exception, info:
            if LG_DEBUG:
                traceback.print_exc()
            self.exception = info
            return None

    def get_form(self, forms, name=None):
        form = None
        if name is None:
            return forms[0]
        else:
            try:
                return forms[name]
            except:
                for item in forms:
                    if item.name == name or item.attrs.get('id', '') == name:
                        return item
        return None


    def submit(self, page, data={}, headers={}, name=None, action=None, kwargs={}):
        forms = ParseFile(StringIO(page), self.resp.geturl(), backwards_compat=False)

        form = self.get_form(forms, name)
        if form == None:
            return None
        for k, v in data.items():
            try:
                item = form.find_control(k)
            except ControlNotFoundError:
                form.new_control('text', k, {'value' : v})
                continue

            if isinstance(item, ListControl) and not isinstance(v, (list, tuple)):
                    v = [v]

            try:
                item.value = v
            except AttributeError:
                if item.readonly:
                    item.readonly = False
                if item.disabled:
                    item.disabled = False
                item.value = v

        if action:
            if callable(action):
                form.action = action(form.action)
            else:
                form.action = action

        req = form.click(**kwargs)
        self.get_headers(headers, req)

        return self.get_page(req)



    def submit_url(self, url, data={}, headers={}, name=None, **kwargs):
        page = self.get_page(url)
        if page is None:
            return None
        return self.submit(page, data, headers, name, **kwargs)

    def get_page(self, *args, **kwargs):
        if self.get_res(*args, **kwargs) is None:
            return
        try:
            pageData = self.resp.read()
            if self.resp.headers.get('content-encoding', None) == 'gzip':
                pageData = gzip.GzipFile(fileobj=StringIO(pageData)).read()

            self.resp.close()
            return pageData
        except Exception, info:
            if LG_DEBUG:
                traceback.print_exc()
            self.exception = info
            return None



    def upload(self, *args, **kwargs):
        kwargs.update({
            'muti' : True
        })
        return self.GetPage(*args, **kwargs)

    @property
    def url(self):
        try:
            return self.resp.url
        except Exception, info:
            #print info
            return ''


if __name__ == '__main__':
    web = SingleWeb(proxy = '127.0.0.1:8087')
    log_url = "http://t.co/6Iu0vfC6"
    result=web.get_page(log_url)
    print result
    #web.submit(result)
