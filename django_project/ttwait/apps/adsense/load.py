#! /usr/bin/env python
#coding=utf-8
import os
import os.path as osp
import zipfile

from models import AdsenseAccount, Report, EmailUid
import poplib
from cStringIO import StringIO
import email
import base64
import csv

cur_path = osp.dirname(osp.abspath(__file__))
EMAIL = dict(
    host = "pop3.163.com",
    user = "zqc160@163.com",
    psw = "littlefox846266",
)


class POP(object):
    def __init__(self, host, user, psw):
        self.host = host
        self.user = user
        self.psw = psw
        #self.uid_db = bsddb.hashopen(osp.join(cur_path, 'uid.bsd'))
        self.connect()
    
    def connect(self):
        self.pop = poplib.POP3(self.host)
        self.pop.user(self.user)
        self.pop.pass_(self.psw)
        self.load_uids()
    
    def load_uids(self):
        uids = EmailUid.objects.all()
        self.uids = {}
        for item in EmailUid.objects.all():
            self.uids[item.uid] = item.msg_id

    
    def get_new_msgs(self):
        
        uids = self.pop.uidl()[1]
        for item in uids:
            msg_id, uid = item.split()
            if uid not in self.uids :
                yield msg_id, uid
    
    def get_msg(self, msg_id, uid):
        content = self.pop.retr(msg_id)
        obj = EmailUid(uid=uid, msg_id=msg_id)
        obj.save()
        self.uids[uid] = msg_id
        msg = email.message_from_string('\n'.join(content[1]))
        
        return msg
    
    def set_uid(self, uid):
        self.uid_db[uid] = '1'
        self.uid_db.sync()

def get_payload(msg):
    payload = {}
    if msg.is_multipart():
        for part in msg.get_payload():
            payload.update(get_payload( part ))
    else:
        types = msg.get_content_type()
        filename = msg.get_filename()
        if types=='application/octet-stream' or types == 'application/zip':
            try:
               body = base64.decodestring(msg.get_payload())
               payload[filename]= body
            except:
               print '[*001*]BLANK'
    return payload
    

def save_report(account, date, views, clicks, usd):
    if not date.startswith('20'):
        return
    views = int(views.replace(',', ''))
    clicks = int(clicks.replace(',', ''))
    usd = float(usd.replace(',', ''))
    report,_ = Report.object.get_or_create(account=account, date=date)

    if report.views < views:
        report.views = views
    if report.clicks < clicks:
        report.clicks = clicks
    if report.usd < usd:
        report.usd = usd
    #print unicode(report).encode('gbk'), 'save'
    report.save()

def readcsv(content, dialect='excel'):
    content = content.replace('\x00', '')
    s = StringIO(content)
    for dialect in ['excel', 'excel-tab']:
        s.seek(0)
        res = []
        c = csv.reader(s, dialect)
        fail = False
        for line in c:
            if len(line) < 6:
                fail = True
                break
            res.append(line)
        if not fail:
            return res
    return None
    

def process(item, msg):
    if not msg.is_multipart():
        return False
    
    subject = email.Header.decode_header(msg['subject'])[0][0]
    #subject = decode(subject)
    account = AdsenseAccount.object.get_account_by_report_name(subject)
    if account is None:
        #print subject, 'not need'
        return False
    p = get_payload(msg)
    if len(p) != 1:
        print 'attratment not one', p.keys(), subject
        return False
    name, v = p.items()[0]
    report = StringIO(v)
    zip = zipfile.ZipFile(report)
    if len(zip.filelist) != 1:
        print 'zip filelist not one', '\t'.join(x.filename for x in zip.filelist)
        return False
    content = zip.read(zip.filelist[0].filename)
        
    c = readcsv(content)
    if not c:
        raise Exception('Parse csv fail')
    
    for line in c:
        save_report(account, line[0], line[1], line[2], line[-1])
    print unicode(account).encode('gbk'), 'save success'
    return True
    

def load_emails():
    lib = POP(**EMAIL)
    for i, item in enumerate(lib.get_new_msgs()):
        msg = lib.get_msg(*item)
        process(item, msg)
        yield i, item
        

if __name__ == '__main__':
    print list(load_emails())
