
from django.conf.urls.defaults import patterns, include, url
from django.conf import settings
import apps.adsense.views

# Uncomment the next two lines to enable the admin:
from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'ttwait.views.home', name='home'),
    # url(r'^ttwait/', include('ttwait.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    #url(r'^admin/doc/', include('django.contrib.admindocs.urls')),
    url(r'^adsense/update/', 'apps.adsense.views.update'),
    # Uncomment the next line to enable the admin:
    url(r'^', include(admin.site.urls)),

    #url('^autocomplete/', include(autocomplete.urls)),
    
)


if settings.DEBUG:
    urlpatterns += patterns('',
        (r'^static/(?P<path>.*)$', 'django.views.static.serve',
                {'document_root': settings.STATIC_ROOT}),
        
    )