#! /usr/bin/env python
#coding=utf-8
import os

def dirname(path, num=1):
    res = path
    for i in xrange(num):
        res = os.path.dirname(res)
    return res
