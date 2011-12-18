#! /usr/bin/env python
#coding=utf-8
import datetime

from django.db import models
from django.contrib.admin.filters import FieldListFilter, DateFieldListFilter as OldDateFieldListFilter




class DateFieldListFilter(OldDateFieldListFilter):
    def __init__(self, *args, **kwargs):
        super(DateFieldListFilter, self).__init__(*args, **kwargs)
        today = datetime.date.today()
        yesterday = today - datetime.timedelta(days=1)
        links = list(self.links)
        links.insert(2, (u'昨天', {
                self.lookup_kwarg_year: str(yesterday.year),
                self.lookup_kwarg_month: str(yesterday.month),
                self.lookup_kwarg_day: str(yesterday.day),
            }),
)
        self.links = tuple(links)
        

FieldListFilter.register(
    lambda f: isinstance(f, models.DateField), DateFieldListFilter, True)
