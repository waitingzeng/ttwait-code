#! /usr/bin/env python
#coding=utf-8

OLDOMAIN = 'online.caatashoes.com'
NEWDOMAIN = 'www.onlinefashional-01.com'
SITE = 'http://%s' % OLDOMAIN

NOURL = []
NOTREPLACEEXT = {
    'gif' : 1,
    'jpg' : 1
}

REPLACE = [
    ('"images/pic/', '"http://littlefox010.appspot.com/pic/',),
    (OLDOMAIN, NEWDOMAIN,),
    ('"images/', '"%s/images/' % SITE,),
    ('"includes/', '"%s/includes/' % SITE,),
    ('"/js/', '"%s/js/' % SITE,),
    
]

REDIRECTURL = {
    'ajax.php' : 1
}
#REDIRECTURL = '*'
query = ['main_page=login', 'main_page=shopping_cart', 'main_page=logoff','main_page=address_book', 
'main_page=account', #all account file
'main_page=product_reviews_write', 'main_page=advanced_search_result', 
'main_page=checkout', #All checkout file
'main_page=popup_shipping_estimator', 'action=update_product', 'action=add_product',#add product
'action=process', #login
'main_page=create_account',
]

def checkCache(url, gourl):
    if url in REDIRECTURL:
        return False
    for q in query:
        if gourl.find(q) != -1:
            print gourl
            return False
    return True
        

funcs = []
