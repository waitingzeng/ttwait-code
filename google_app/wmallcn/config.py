#! /usr/bin/env python
#coding=utf-8

OLDOMAIN = 'wmallcn.caatashoes.com'
NEWDOMAIN = 'www.wmallcn.com'#'www.onlinefashional-01.com'

SITE = 'http://%s' % OLDOMAIN

NOURL = []
NOTREPLACEEXT = {
    'gif' : 1,
    'jpg' : 1
}

REPLACE = [
    ('"/img/', '"%s/img/' % SITE,),
    ('"/style/', '"%s/style/' % SITE,),
    ('"/js/', '"%s/js/' % SITE,),
]

REDIRECTURL = {
    'index.asp' : '1',
    'index.php' : '1',
    'reg.asp' : 1,
    'repass.asp' : 1, 
    'login.asp' : 1, 
    'basket.asp' : 1, 
    'buy.asp' : 1,
    'cash.asp' : 1, 
    'orders.asp' : 1, 
    'modify.asp' : 1, 
    'userinfo.asp' : 1,
    'submore.asp' : 1,
    'cashsave.asp' : 1,
    'guestbook.asp' : 1,
    'reg.php' : 1,
    'repass.php' : 1, 
    'login.php' : 1, 
    'basket.php' : 1, 
    'buy.php' : 1,
    'cash.php' : 1, 
    'orders.php' : 1, 
    'modify.php' : 1, 
    'userinfo.php' : 1,
    'submore.php' : 1,
    'cashsave.php' : 1,
    'guestbook.php' : 1,
    'ajax.php' : 1,
    'ajax.asp' : 1,
    }
#REDIRECTURL = '*'

def checkCache(url, gourl):
    if url in REDIRECTURL:
        return False
    return True


funcs = []
