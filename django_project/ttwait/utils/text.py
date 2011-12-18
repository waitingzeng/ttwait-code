#! /usr/bin/env python
#coding=utf-8
import re
import time
import os
from random import randint
import urllib
import traceback
from singleweb import get_page
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


def readlines(filename, comment=None):
    data = []
    if os.path.exists(filename):
        for x in file(filename).xreadlines():
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
    a.close()




def rnd_str(num):
    result = []
    for i in range(num):
        result.append(chr(randint(97,122)))
    return ''.join(result)



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

def md5(s):
    a = hashlib.md5(s)
    return a.hexdigest()


import mysignal
def sleep(sec=0):
    a = time.time()
    print 'waiting',
    while mysignal.ALIVE:
        b = sec - (time.time() - a)
        if b <= 0:
            break
        print int(b),
        try:
            time.sleep(10)
        except:
            break
    print




if __name__=='__main__':
    print get_in('<a href="afdafsda ', 'href=', [' ', "'", '"'])

