#! /usr/bin/env python
#coding=utf-8
from django.db import models
from django.utils.datastructures import DictWrapper
from sql_helper import escape
from django.db import connections, DEFAULT_DB_ALIAS
from datetime import datetime
from time import strftime,mktime


class UnixTimestampField(models.DateTimeField):
    """UnixTimestampField: creates a DateTimeField that is represented on the
    database as a TIMESTAMP field rather than the usual DATETIME field.
    """
    def __init__(self, null=False, blank=False, **kwargs):
        super(UnixTimestampField, self).__init__(**kwargs)
        # default for TIMESTAMP is NOT NULL unlike most fields, so we have to
        # cheat a little:
        self.blank, self.isnull = blank, null
        self.null = True # To prevent the framework from shoving in "not null".
        
    def db_type(self):
        typ=['TIMESTAMP']
        # See above!
        if self.isnull:
            typ += ['NULL']
        if self.auto_now_add:
            typ += ['default CURRENT_TIMESTAMP']
        
        if self.auto_now:
            typ += ['on update CURRENT_TIMESTAMP']
        return ' '.join(typ)
    
    def to_python(self, value):
        return datetime.from_timestamp(value)
    
    def get_prep_value(self, value):
        if value==None:
            return None
        return mktime(value.timetuple())
    
    
    def get_db_prep_value(self, value):
        if value==None:
            return None
        return strftime('%Y%m%d%H%M%S',value.timetuple())




class DjangoFieldSlot(object):
    def db_type(self, connection):
        data = DictWrapper(self.__dict__, connection.ops.quote_name, "qn_")
        try:
            typ = connection.creation.data_types[self.get_internal_type()] % data
            if self.default is not models.NOT_PROVIDED and not callable(self.default):
                typ += ' default %s' % escape(self.default)
            return typ
        except KeyError:
            return None
    


def class_with_class(cls):
    class newcls(DjangoFieldSlot, cls): pass
    return newcls

from django.db.models.fields.subclassing import LegacyConnection


for name, cls in models.__dict__.items():
    if type(cls) == LegacyConnection and name in connections[DEFAULT_DB_ALIAS].creation.data_types:
        models.__dict__[name] = class_with_class(cls)


models.__dict__['UnixTimestampField'] = UnixTimestampField