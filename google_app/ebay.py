#! /usr/bin/env python
#coding=utf-8
from appcfg import *
import os
import sys
import urllib2
import getopt
import socket
timeout = 10
socket.setdefaulttimeout(timeout)



if __name__ == '__main__':
    opts, argv = getopt.getopt(sys.argv[1:], "c:b:a:p:", [])
    need = {}
    apps = None
    begin = 9999
    action = 'update'
    path = 'ebay'
    for opt, arg in opts:
        if opt == '-c':
            apps = {}
            s = file(arg).read()
            if s:
                exec(s)
            print len(apps)
        if opt == '-b':
            begin = int(arg)
        if opt == '-a':
            action = arg
        if opt == '-p':
            path = arg
        if opt == '-h':
            print '-c open the txt app file'
            print '-b begin the index'
            print '-p the path'
            print '-a update or rollback'
    
    appfile = os.path.join(path, 'app.yaml')
    appcontent = file(appfile).read().split('\n', 1)[1]
    sys.path = EXTRA_PATHS + sys.path
    script_name = 'myappcfg.py'
    script_name = SCRIPT_EXCEPTIONS.get(script_name, script_name)
    script_path = os.path.join(SCRIPT_DIR, script_name)

    
    if apps is None:
        from apps import apps
    
    
    if len(argv) == 0:
        need = apps
    else:
        for item in argv:
            need[item] = apps[item]
    sys.argv = sys.argv[:1]
    if len(need) == 0:
        print 'not and to update'
        sys.exit(0)
    
    argv = '%s %s -e test -p test --no_cookies' % (action, path)
    for i,v in enumerate(argv.split(' ')):
        sys.argv.append(v)
    
    i = len(need)
    fail = []
    for id, app in need.items():
        i -= 1
        if i > begin:
            continue
        print i, id,'begin'
        sys.argv[4] = app['name']
        sys.argv[6] = app['password']
        a = file(appfile, 'w')
        a.write('application: %s\n' % id)
        a.write(appcontent)
        a.close()
        print ' '.join(sys.argv)
        for j in range(10):
            try:
                execfile(script_path, globals())
                print id, 'success\n\n' 
                break
            except Exception, info:
                print 'fail', info
                if j == 9:
                    fail.append(id)
        
    print 'fail', fail
                    
    
    
