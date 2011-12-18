#! /usr/bin/env python
#coding=utf-8
import models

from django.contrib import admin
import filters


class AdsenseAccountAdmin(admin.ModelAdmin):
    list_display = ('name', 'short_name', 'report_name')
    
    def report_name(self, obj):
        return u'AdSense 报告要求 | %s' % obj.short_name
    report_name.__name__ = '报告名称'
    
admin.site.register(models.AdsenseAccount, AdsenseAccountAdmin)


class ReportAdmin(admin.ModelAdmin):
    list_display = ('account', 'date', 'views', 'clicks', 'ctr', 'cpc', 'rpm', 'usd')
    ordering = ['account', 'date']
    date_hierarchy = 'date'
    list_filter = ('account', 'date')
    
    def ctr(self, obj):
        """网页 CTR"""
        return obj.ctr
    ctr.__name__ = """点击率"""
    

    def cpc(self, obj):
        """CPC (USD)"""
        return obj.cpc
    cpc.__name__ = """CPC (USD)"""
    
    def rpm(self, obj):
        """网页 RPM (USD)"""
        return obj.rpm
    rpm.__name__ = """网页 RPM (USD)"""
    
    
    def queryset(self, request):
        qs = self.model._default_manager.get_stat_query_set()
        # TODO: this should be handled by some parameter to the ChangeList.
        ordering = self.get_ordering(request)
        if ordering:
            qs = qs.order_by(*ordering)
        return qs
        
    
admin.site.register(models.Report, ReportAdmin)