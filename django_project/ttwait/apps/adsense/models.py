#coding=utf-8


from django.db import models
from django.db.models.query import QuerySet

# Create your models here.

class EmailUid(models.Model):
    msg_id = models.IntegerField('msg_id')
    uid = models.CharField('uid', max_length=50, unique=True)
    
    class Meta:
        db_table = 'uid_db'
    
    def __unicode__(self):
        return self.uid

class AdsenseAccountManager(models.Manager):
    def get_account_by_report_name(self, name):
        key = u'AdSense_报告要求'
        key1 = u'AdSense 报告要求'
        all_account = self.all()
        #if name.find(key) != -1 or name.find(key1) != -1:
        for item in all_account:
            if name.find(str(item.short_name)) != -1 :
                return item
        return None
        
    
class AdsenseAccount(models.Model):
    object = AdsenseAccountManager()
    name = models.CharField(u'Adsens 帐号', max_length=20, unique=True)
    short_name = models.CharField(u'缩写', max_length=20, unique=True)
    
    class Meta:
        db_table = 'adsense_accounts'
        verbose_name = 'Adsense帐号'
    
    def __str__(self):
        return self.name
    
    def __unicode__(self):
        return self.name



class ReportStatQuerySet(QuerySet):
    def iterator(self):
        stat_obj = Report(account=TotalAccount, date='')
        ave_obj = Report(account=AveAccount, date='')
        ct = 0
        for item in QuerySet.iterator(self):
            ct += 1
            stat_obj.views += item.views
            stat_obj.clicks += item.clicks
            stat_obj.usd += item.usd
            yield item
        yield EmptyReport
        if ct > 0:
            ave_obj.views = stat_obj.views / ct
            ave_obj.clicks = stat_obj.clicks / ct
            ave_obj.usd = float('%0.2f' % (stat_obj.usd / ct))
        yield ave_obj
        yield stat_obj


class ReportManager(models.Manager):
    def get_stat_query_set(self):
        return ReportStatQuerySet(self.model, using=self._db)
    

class Report(models.Model):
    object = ReportManager()
    account = models.ForeignKey(AdsenseAccount, verbose_name='帐号')
    date = models.DateField('日期')
    views = models.IntegerField('网页浏览量', default=0)
    clicks = models.IntegerField('点击次数', default=0)
    usd = models.FloatField('估算收入 (USD)', default=0)
    
    @property
    def ctr(self):
        """网页 CTR"""
        if not self.views:
            return 0
        return u'%0.2f%%' % ((self.clicks + 0.0) / self.views * 100)
    
    @property
    def cpc(self):
        """CPC (USD)"""
        if not self.clicks:
            return 0
        return u'%0.2f%%' % (self.usd / self.clicks * 100)
    
    @property
    def rpm(self):
        """网页 RPM (USD)"""
        if not self.views:
            return 0
        return u'%0.2f' % (self.usd / self.views * 1000)
    
    class Meta:
        db_table = 'report'
        verbose_name = '每日报告'
        unique_together = ('account', 'date')
        
        
    def __unicode__(self):
        x = [
        self.account, self.date, self.views, self.clicks, self.ctr, self.cpc, self.rpm, self.usd]

        return u'\t'.join([unicode(x) for x in x])



TotalAccount = AdsenseAccount(name=u'总计', short_name='total')
AveAccount = AdsenseAccount(name=u'平均', short_name='ave')
EmptyAccount = AdsenseAccount(name=u'', short_name='')
EmptyReport = Report(account=EmptyAccount, date='', views='', clicks='', usd='0')
