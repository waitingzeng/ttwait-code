#! /usr/bin/env python
#coding=utf-8
from google.appengine.ext import db
import wsgiref.handlers
from google.appengine.ext import webapp

class Config(db.Model):
    name = db.StringProperty(required=True)
    value = db.StringProperty(required=True)


def get_item(name='type', value='default'):
    query = Config.gql("WHERE name = :name ", name=name)
    results = query.fetch(1)
    if len(results) == 0:
        if value is None:
            return None
        item = Config(name=name, value=value)
        item.put()
    else:
        item = results[0]
    return item

def get_value(*args, **kwargs):
    item = get_item(*args, **kwargs)
    if item:
        return item.value
    return None

class MainHandler(webapp.RequestHandler): 
    def get(self, url=None):
        name = self.request.get('name', None)
        value = self.request.get('value', None)
        action = self.request.get('action', 'help')
        if action == 'help':
            res = "?action=[set|get|help]&name=[name]&value=[value]"
        else:
            if not name:
                res = 'name must give!'
            else:
                if action == 'get':
                    item = get_item(name)
                    res = item.value
                elif action == 'set':
                    if value is None:
                        res = 'value must give in action "set"'
                    else:
                        item = get_item(name)
                        item.value = value
                        item.put()
                        res = '%s = "%s" success' % (name, value)
                else:
                    res = '%s is not in [set|get|help]' % action
                    
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write(res)

def main():
    application = webapp.WSGIApplication([('/model.py', MainHandler)], debug=True)
    wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
    main()
