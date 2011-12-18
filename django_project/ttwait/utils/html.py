#! /usr/bin/env python
#coding=utf-8
from pyquery import PyQuery as pq
import re
import urllib
from text import get_in, get_in_list

def html_to_text(content, blank=False):
    if not content:
        return None
    d = pq(content)
    text = []
    strip = blank and (lambda s:s.strip('\r\n')) or (lambda s:s.strip())
    
    def add_text(tag, no_tail=False):
        if tag.text:
            text.append(strip(tag.text))
        for child in tag.getchildren():
            add_text(child)
        if tag.tag in ('br', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'div'):
            text.append('\n')
        if not no_tail and tag.tail:
            text.append(strip(tag.tail))
        

    for tag in d:
        add_text(tag, no_tail=True)
    s = ' '.join([t for t in text])
    s = iso_to_char(unescape(s))
    return s

def text_to_html(content, blank=True):
    if not content:
        return None
    text_list = content.split('\n')
    html = []
    strip = blank and (lambda s:s.strip('\r')) or (lambda s:s.strip())
    for txt in text_list:
        txt = strip(txt)
        if not txt:
            html.append('<br/>')
        else:
            html.append('<p>%s</p>' %  escape(txt))
            
    html = ''.join(html)
    return html



def escape(html):
    """Returns the given HTML with ampersands, quotes and carets encoded."""
    #('&', '&amp;')
    for k, v in [('<', '&lt;'), ('>', '&gt;'), ('  ', '&nbsp;&nbsp;'),]:
        html = html.replace(k, v)

    return html

def unescape(html):
    """Returns the given HTML with ampersands, quotes and carets encoded."""
    return html.replace('&amp;', '&').replace('&lt;', '<').replace('&gt;', '>').replace('&nbsp;', ' ')



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



def not_html_tags(htmlText, repl=' '):
    return re.sub(r"<[^>]*>", repl, htmlText)



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


def query_to_dict(str):
    return dict([x.split('=', 1) for x in urllib.unquote_plus(str).split('&')])


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
