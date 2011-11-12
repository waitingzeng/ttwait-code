import wsgiref.handlers
from google.appengine.ext import webapp
from google.appengine.ext import db

class Storage(db.Model):
    obj_key = db.StringProperty(required=True)
    obj_value = db.IntegerProperty(required=True)


class MainPage(webapp.RequestHandler):
    def get(self):
        self.response.headers['Content-Type'] = 'text/plain'
        try:
            action = self.request.get('action', 'load')
            if action == 'load':
                limit = self.request.get('limit', 1000)
                obj_value = int(self.request.get('obj_value', '0'))
                to_value = int(self.request.get('to_value', str(obj_value)))
                query = Storage.gql("where obj_value=%s limit %s" % (obj_value, limit))
                out = [x.obj_key for x in query]
                if obj_value != to_value:
                    for item in query:
                        item.obj_value = to_value
                        item.put()
                self.response.out.write('0;')
                self.response.out.write('\n'.join(out))
                return
            elif action == 'update':
                obj_keys = self.request.get('obj_keys', None)
                obj_value = int(self.request.get('obj_value', '0'))
                if obj_keys is None:
                    self.response.out.write('-1;key require')
                    return
                obj_keys = obj_keys.split(';')
                for obj_key in obj_keys:
                    query = Storage.gql('where obj_key=:1', obj_key)
                    item = query.get()
                    if item is None:
                        item = Storage(obj_key=obj_key, obj_value=obj_value)
                    else:
                        if item.obj_value >= obj_value:
                            continue
                        item.obj_value = obj_value
                        
                    item.put()
                self.response.out.write('0;')
                return
                
        except Exception, e:
            self.response.out.write('-1;%s' % e)
            return

def main():
    application = webapp.WSGIApplication(
                                [('/store.py', MainPage)],
                                debug=True)
    wsgiref.handlers.CGIHandler().run(application)

if __name__ == "__main__":
    main()