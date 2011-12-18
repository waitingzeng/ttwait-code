#! /usr/bin/env python
#coding=utf-8
from django.contrib import admin
from django.db.models.base import ModelBase

def model_admin_with_model(model):
    class newcls(admin.ModelAdmin):pass
    newcls.__name__ = '%sAdmin' % model.__name__
    opts = model._meta
    list_display = [f.name for f in opts.local_fields]
    newcls.list_display = list_display
    return newcls


def auto_admin_model(model):
    try:
        admin.site.register(model, model_admin_with_model(model))
    except admin.sites.AlreadyRegistered:
        pass

def auto_admin_models(models):
    for name in dir(models):
        attr = getattr(models, name)
        if isinstance(attr, ModelBase):
            auto_admin_model(attr)