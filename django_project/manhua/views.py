#! /usr/bin/env python
#coding=utf-8
from django.http import HttpResponseRedirect,HttpResponse
from ext.common import render_template
import urlparse
from manager import get_manager

manager = get_manager('manhua')
def trans_to_app(url):
    if not url:
        return None
    urls = urlparse.urlsplit(url)
    if not urls[0].startswith('http'):
        return None
    cls = manager.get(urls[1])
    if not cls:
        return None
    return HttpResponseRedirect('%s%s' % (cls.app_label, urls[2]))
    

def index(request):
    url = request.POST.get('url', '')
    if request.method == 'POST':
        res = trans_to_app(url)
        if res:
            return res
    return render_template(request, 'base.html', {'url' : url})

