#! /usr/bin/env python
#coding=utf-8
from manager import get_manager
from pyquery import PyQuery as pq
from singleweb import get_page
from seqdict import seqdict
import random

class IManHua(object):
    host = 'www.imanhua.com'
    pic_host_list = [
        "http://61.147.113.67:89",
        "http://61.147.109.2:89",
        "http://t1.imanhua.com",
        "http://61.147.109.2:89",
        "http://60.190.173.6:89",
    ]
    app_label = 'imanhua'
    
    def __init__(self):
        self._cache = {}
    
    def get_img_list(self, type_id, part_id):
        url = '/Files/Images/%s/%s/imanhua_%%03d.jpg' % (type_id, part_id)
        return [url % x for x in range(1,50)]
    
    def comic(self, type_id):
        if type_id not in self._cache:
            url = 'http://www.imanhua.com/comic/%s/' % type_id
            page = get_page(url)
            if page is None:
                return None
            res = list(self.parse_comic(type_id, page))
            self._cache[type_id] = res
        return self._cache[type_id]
    
    def parse_comic(self, type_id, page):
        page = pq(page)
        all_link = page.find('a')
        res = {}
        for link in all_link:
            link = pq(link)
            href = link.attr('href')
            if href.startswith('/comic/%s/list_' % type_id):
                if href in res:
                    continue
                res[href] = True
                yield '/%s%s' % (self.app_label, href), link.attr('title')
    
    def get_img(self, type_id, part_id, ct=0):
        server = random.choice(self.pic_host_list)
        img = int(ct) + 1
        url = '%s/Files/Images/%s/%s/imanhua_%03d.jpg' % (server, type_id, part_id, img)
        headers = {
            'Referer' : 'http://www.imanhua.com/comic/%s/list_%s.html' % (type_id, part_id)
        }
        page = get_page(url, headers=headers)
        return page
                
    def get_server(self):
        return self.pic_host_list
    

get_manager('manhua').add(IManHua.host, IManHua)

if __name__ == '__main__':
    app = IManHua()
    app.get_img('2331', '53503', 10)