#! /usr/bin/env python
#coding=utf-8
import chardet

def decode(s):
    if isinstance(s, unicode):
        return s
    code = chardet.detect(s)
    try:
        return s.decode(code['encoding'])
    except:
        print code
        return s
    
def encode(s, code='utf-8'):
    if s is None:
        return s
    if not isinstance(s, unicode):
        s = decode(s)
    return s.encode(code)

def gbk(s):
    return encode(s, 'gbk')

def utf8(s):
    return encode(s, 'utf8')