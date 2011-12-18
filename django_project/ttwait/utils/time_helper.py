#!/usr/bin/env python
# -*- coding:utf-8 -*-
import time
import datetime

def datetime_to_str(dt):
    """
    datetime ---> string
    """
    return str(dt)[:19]

def date_to_str(d):
    """
    date ---> string
    """
    return str(d)

def ts_to_datetime(ts):
    """
    timestamp ---> datetime
    """
    return datetime.datetime.fromtimestamp(ts)

def ts_to_datetime_str(ts):
    """
    timestamp ---> datetime string
    """
    return datetime_to_str(ts_to_datetime(ts))

def utc_datetime_to_local(utc):
    """
    datetime(utc) ---> datetime(local)
    """
    return utc + datetime.timedelta(seconds=-time.timezone)
    
def local_ts():
    """
    get local timestamp
    """
    return time.time()

def local_sec():
    return int(time.time())

def utc_ts():
    """
    get utc timestamp
    """
    return int(time.time() + time.timezone)
    #tt = datetime.datetime.utcnow()
    #tt = tt.timetuple()
    #return int(time.mktime(tt))    

def local_string(format = '%Y-%m-%d %H:%M:%S'):
    return time.strftime(format,time.localtime())

def utc_string(format = '%Y-%m-%d %H:%M:%S%'):
    return time.strftime(format ,time.gmtime())

def str_to_date(time_str, format = '%Y-%m-%d'):
    return datetime.datetime.strptime(time_str, format)

if __name__ == '__main__':
    d = u'2OO8-1-8'
    print str_to_date(d)
