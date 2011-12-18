#! /usr/bin/env python
#coding=utf-8
import threading


def start_thread(func, *args, **kwargs):
    h = threading.Thread(target=func, name='Thread', args=args, kwargs=kwargs)
    h.setDaemon(True)
    h.start()
    return h
    
