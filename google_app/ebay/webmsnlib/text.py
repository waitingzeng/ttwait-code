#! /usr/bin/env python
#coding=utf-8
import re
import time
import os
from random import randint
import urllib
import traceback
import urllib2
import hashlib

def get_in(data, b, e=None, start=0, flag=False):
    if data is None:
        return None
    b1 = data.find(b, start)
    if b1 == -1:
        return None
    b1 += len(b)
    if e is None:
        return data[b1:]
    if isinstance(e, list):
        e1 = -1
        for i in range(b1 + 1, len(data)):
            if data[i] in e:
                e1 = i
                break
    else:
        e1 = data.find(e, b1)
    if e1 == -1:
        if flag:
            return data[b1:]
        return None
    return data[b1:e1]


def get_in_list(data, b, e, start=0):
    if data is None:
        return
    while True:
        b1 = data.find(b, start)
        if b1 == -1:
            return
        b1 += len(b)
        e1 = data.find(e, b1)
        if e1 == -1:
            return
        yield data[b1:e1]
        start = e1


def get_hidden(page):
    return get_input(page)

def get_input(page, type='hidden'):
    data = {}
    for input in get_in_list(page, '<input', '>'):
        input = input.replace("'", '"')
        if input.lower().find('type="%s"' % type) == -1:
            continue
        name = get_in(input, 'name="', '"')
        value = get_in(input, 'value="', '"')
        if name is None:
            name = get_in(input, 'name=', ' ')
            if name is None:
                continue
            continue
        if value is None:
            value = get_in(input, 'value=', ' ')
            if value is None:
                value = ''
        data[name] = value
    return data


def get_tag(data, tag):
    btag = '<%s>' % tag
    etag = '</%s>' % tag
    return get_in(data, btag, etag)
    

def get_end_tag(data, tag):
    btag = '<%s' % tag.lower()
    etag = '</%s>' % tag.lower()
    data1 = data.lower()
    begin = 0
    while True:
        end = data1.find(etag, begin)
        if data1.find(btag, begin, end) != -1:
            begin = end+1
        else:
            return data[:end]

def escape(html):
    """Returns the given HTML with ampersands, quotes and carets encoded."""
    #('&', '&amp;')
    for k, v in [('<', '&lt;'), ('>', '&gt;'), ('  ', '&nbsp;&nbsp;'),]:
        html = html.replace(k, v)

    return html

def unescape(html):
    """Returns the given HTML with ampersands, quotes and carets encoded."""
    return html.replace('&amp;', '&').replace('&lt;', '<').replace('&gt;', '>').replace('&nbsp;', ' ')




def not_html_tags(htmlText, repl=' '):
    return re.sub(r"<[^>]*>", repl, htmlText)

def readlines(filename, comment=None):
    data = []
    if os.path.exists(filename):
        for x in file(filename):
            x = x.strip()
            if x and (not comment or not x.startswith(comment)):
                data.append(x)
    return data

def readdict(filename, sp = None, ignore=True):
    data = {}
    if os.path.exists(filename):
        for x in file(filename):
            x = x.strip()
            if x:
                if sp is None:
                    data[x] = 1
                else:
                    try:
                        k,v = x.split(sp, 2)
                        data[k.strip()] = v.strip()
                    except Exception, info:
                        if not ignore:
                            raise info
                        print info
                        continue
    return data


def writelines(filename, lines):
    if lines is None:
        return
    a = file(filename, 'w')
    a.write('\n'.join(lines))
    a.write('\n')
    a.close()




def rnd_str(num):
    result = []
    for i in range(num):
        result.append(chr(randint(97,122)))
    return ''.join(result)


def make_utf8(s):
    if isinstance(s, unicode):
        return s
    try:
        s = s.decode('gbk')
        if isinstance(s, unicode):
            return s
    except:
        pass

    try:
        s = s.decode('utf-8')
        if isinstance(s, unicode):
            return s
    except:
        pass
    return s

def query_to_dict(str):
    return dict([x.split('=', 1) for x in urllib.unquote_plus(str).split('&')])


def urlencode(query):
    s = []
    for k,v in query:
        s.append('%s=%s' % (k, urllib.quote_plus(v)))
    return '&'.join(s)

cre = re.compile('&#(\d+);', re.I|re.M)
def iso_to_char(query):
    def f(match):
        a = match.group(1)
        if a.isdigit():
            a = int(a)
            if a <= 255:
                if a > 127:
                    return ''
                return chr(a)
            else:
                return eval('u"\u%x"' % a)
        return a
    return cre.sub(f, query)


smart_split_re = re.compile('("(?:[^"\\\\]*(?:\\\\.[^"\\\\]*)*)"|\'(?:[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\'|[^\\s]+)')
def smart_split(text):
    r"""
    Generator that splits a string by spaces, leaving quoted phrases together.
    Supports both single and double quotes, and supports escaping quotes with
    backslashes. In the output, strings will keep their initial and trailing
    quote marks.

    >>> list(smart_split(r'This is "a person\'s" test.'))
    [u'This', u'is', u'"a person\\\'s"', u'test.']
    >>> list(smart_split(r"Another 'person\'s' test."))
    [u'Another', u"'person's'", u'test.']
    >>> list(smart_split(r'A "\"funky\" style" test.'))
    [u'A', u'""funky" style"', u'test.']
    """
    for bit in smart_split_re.finditer(text):
        bit = bit.group(0)
        if bit[0] == '"' and bit[-1] == '"':
            yield '"' + bit[1:-1].replace('\\"', '"').replace('\\\\', '\\') + '"'
        elif bit[0] == "'" and bit[-1] == "'":
            yield "'" + bit[1:-1].replace("\\'", "'").replace("\\\\", "\\") + "'"
        else:
            yield bit

def waitexit(func):
    def wrapper(*args, **kwargs):
        try:
            func(*args, **kwargs)
        except:
            traceback.print_exc()
        raw_input('press any key to exit')
    return wrapper

TAGRESULT = re.compile(r'<Result>(.*?)<\/Result>', re.I|re.M|re.S)
def get_yahoo_tags(content):
    try:

        data = {
            'appid' : 'F20C_5fV34GKK0OIuUKOGwrjY253x4Zjt_qyV.vFIq9hPH5h5AADBJNeYO0mDgoyOmVk',
            'context' : content,
        }
        url = 'http://api.search.yahoo.com/ContentAnalysisService/V1/termExtraction'
        req = urllib2.Request(url, urllib.urlencode(data))
        res = urllib2.urlopen(req).read()
        r = TAGRESULT.findall(res)
    except:
        import traceback
        traceback.print_exc()
        return []
    return r

def md5(s):
    a = hashlib.md5(s)
    return a.hexdigest()


def pop_rnd(items):
    return items.pop(randint(0, len(items)-1))

def get_rnd(items):
    return items[randint(0, len(items)-1)]


if __name__=='__main__':
    #print list(smart_split(u'被上诉人 (原审原告): 张某某, 女.'))
    print get_yahoo_tags("make money")

