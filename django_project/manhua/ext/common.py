###########
#common.py
###########
from django.conf import settings
from django.core.exceptions import ImproperlyConfigured
from django.http import HttpResponse
from django.template.context import RequestContext
from django.utils import simplejson
from django.utils.functional import Promise
from django.utils.translation import force_unicode
from django.template import loader
from django.db import connection
# Create your models here.
import os,datetime


def short(*args, **kwargs):
    try:
        cursor = connection.cursor()
        a = cursor.execute(*args, **kwargs)
        connection._commit()
        return True
    except Exception, info:
        print info
        return False


def render_to_response(*args, **kwargs):
    httpresponse_kwargs = {'mimetype': kwargs.pop('mimetype', None)}
    return HttpResponse(loader.render_to_string(*args, **kwargs), **httpresponse_kwargs)

def render_template(request, template_name, dictionary=None, **kwargs):
    return render_to_response(template_name, dictionary, RequestContext(request), **kwargs)

def get_func(funcname):
    i = funcname.rfind('.')
    if i == -1:
        m, a = funcname, None
    else:
        m, a = funcname[:i], funcname[i+1:]
    try:
        if a is None:
            mod = __import__(m,{},{},[])
        else:
            mod = getattr(__import__(m, {}, {}, [a]), a)
    except ImportError, e:
        raise ImproperlyConfigured, 'ImportError %s: %s' % (funcname, e.args[0])
    
    if callable(mod):
        return mod
    else:
        raise Exception, 'Filters function error'

class LazyEncoder(simplejson.JSONEncoder):
     def default(self, o):
         if isinstance(o, Promise):
             return force_unicode(o)
         else:
             return super(LazyEncoder, self).default(o)

    
def response_json(state, obj=None):
    data = {'state' : state}
    if obj is not None:
        data['data'] = obj
    data = simplejson.dumps(data,  cls=LazyEncoder)
    return HttpResponse(data)

def get_last_month(d = None):
    if d is None:
        d = datetime.datetime.today()
    a = datetime.datetime(d.year, d.month, 1)
    return a - datetime.timedelta(days=1)
    

def str_date(d = None):
    if d is None:
        d = datetime.datetime.today()
    return d.strftime('%Y-%m-%d')


def check_same_day(d1, d2):
    return d1.year == d2.year and d1.month == d2.month and d1.day == d2.day


