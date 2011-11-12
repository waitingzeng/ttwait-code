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
from dict4ini import DictIni

site_config = DictIni('site_config.ini')
path = 'makemoney'
action = 'update'

if __name__ == '__main__':
    appfile = os.path.join(path, 'app.yaml')
    configfile = os.path.join(path, 'config.tpl')
    configcontent = file(configfile).read()
    configfile = os.path.join(path, 'config.py')
    appcontent = file(appfile).read().split('\n', 1)[1]
    sys.path = EXTRA_PATHS + sys.path
    script_name = 'appcfg.py'
    script_name = SCRIPT_EXCEPTIONS.get(script_name, script_name)
    script_path = os.path.join(SCRIPT_DIR, script_name)

    argv = '%s %s -e test -p test --no_cookies' % (action, path)
    for i,v in enumerate(argv.split(' ')):
        sys.argv.append(v)
    
    for key, infos in site_config.items():
        print key, 'begin'
        sys.argv[4] = infos['email']
        sys.argv[6] = str(infos['psw'])
        
        a = file(configfile, 'w')
        a.write(configcontent % infos)
        a.close()
        a = file(appfile, 'w')
        a.write('application: %s\n' % infos['appid'])
        a.write(appcontent)
        a.close()
        print ' '.join(sys.argv)
        for j in range(10):
            try:
                #raw_input()
                execfile(script_path, globals())
                print key, 'success\n\n' 
                break
            except Exception, info:
                print 'fail', info
        
                    
    
    
