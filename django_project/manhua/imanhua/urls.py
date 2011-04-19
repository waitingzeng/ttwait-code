from django.conf.urls.defaults import *

# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('imanhua.views',
    (r'^comic/(?P<type_id>\d+)/$', 'comic'),
    (r'^comic/(?P<type_id>\d+)/list_(?P<part_id>\d+).html$', 'comic_part'),
    (r'^(?P<type_id>\d+)/(?P<part_id>\d+)/(?P<img_id>\d+)/$', 'comic_show'),
)
