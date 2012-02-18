#!/usr/bin/env python
#coding=utf-8

import urllib
import urllib2
import mimetools, mimetypes
import os, stat, sys

class Callable:
    def __init__(self, anycallable):
        self.__call__ = anycallable

# Controls how sequences are uncoded. If true, elements may be given multiple values by
#  assigning a sequence.
doseq = 1

class MultipartPostHandler:
    def http_request(self, request, data):
        if data is not None and type(data) != str:
            v_files = []
            v_vars = []
            try:
                 for(key, value) in data.items():
                     if type(value) == file:
                         v_files.append((key, value))
                     else:
                         v_vars.append((key, value))
            except TypeError:
                systype, value, traceback = sys.exc_info()
                raise TypeError, "not a valid non-string sequence or mapping object", traceback

            #if len(v_files) == 0:
            #    data = urllib.urlencode(v_vars, doseq)
            #else:
            if True:
                boundary, data = self.multipart_encode(v_vars, v_files)
                contenttype = 'multipart/form-data; boundary=%s' % boundary
                if(request.has_header('Content-Type')
                   and request.get_header('Content-Type').find('multipart/form-data') != 0):
                    print "Replacing %s with %s" % (request.get_header('content-type'), 'multipart/form-data')
                request.add_unredirected_header('Content-Type', contenttype)
            request.add_data(data)
        return request

    def multipart_encode(vars=[], files=[], boundary = None, buffer = None):
        if boundary is None:
            boundary = mimetools.choose_boundary()
            #boundary = '---------------------------7d92711f502ee'
        if buffer is None:
            buffer = ''
        for(key, values) in vars:
            if isinstance(values, basestring):
                values = [values]
            for value in values:
                buffer += '--%s\r\n' % boundary
                buffer += 'Content-Disposition: form-data; name="%s"' % key
                buffer += '\r\n\r\n' + value + '\r\n'
        for(key, fds) in files:
            if isinstance(fds, file):
                fds = [fds]
            for fd in fds:
                file_size = os.fstat(fd.fileno())[stat.ST_SIZE]
                filename = fd.name.split('/')[-1]
                contenttype = mimetypes.guess_type(filename)[0] or 'application/octet-stream'
                buffer += '--%s\r\n' % boundary
                buffer += 'Content-Disposition: form-data; name="%s"; filename="%s"\r\n' % (key, filename)
                buffer += 'Content-Type: %s\r\n' % contenttype
                # buffer += 'Content-Length: %s\r\n' % file_size
                fd.seek(0)
                buffer += '\r\n' + fd.read() + '\r\n'
        buffer += '--%s--\r\n\r\n' % boundary
        return boundary, buffer
    multipart_encode = Callable(multipart_encode)

    https_request = http_request
    
if __name__ == '__main__':
    mimetools._prefix = '---------------------------'
    print mimetools.choose_boundary()