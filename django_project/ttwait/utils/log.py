#!/usr/bin/env python
# -*- coding:utf-8 -*-
import logging
import time
import os
from ttwait.utils.path import dirname
try:
    import codecs
except ImportError:
    codecs = None

    
def setup_log(level=logging.ERROR, file_path=None):
    logging.getLogger().setLevel(level)
    from os import path as osp
         
    add_stream_handler()
    if file_path is None:
        file_path = dirname(__file__, 3)
    log_file = osp.join(file_path, 'logs', "log.txt")
    add_file_handler(log_file)

def add_stream_handler():
    """Turns on colored logging output for stderr if we are in a tty."""
    channel = logging.StreamHandler()
    channel.setFormatter(SimpleFormatter())
    logging.getLogger().addHandler(channel)   
 
def add_file_handler(file_name): 
    file_handler = MyFileHandler(file_name)
    file_handler.setFormatter(SimpleFormatter())
    logging.getLogger().addHandler(file_handler)    
    
def utf8(value):
    if isinstance(value, unicode):
        return value.encode("utf-8")
    assert isinstance(value, str)
    return value


def _unicode(value):
    if isinstance(value, str):
        return value.decode("utf-8")
    assert isinstance(value, unicode)
    return value      

class MyFileHandler(logging.StreamHandler):
    """
    A handler class which writes formatted logging records to disk files.
    """
    def __init__(self, filename, mode='a', encoding=None, delay=0):
        """
        Open the specified file and use it as the stream for logging.
        """
        #keep the absolute path, otherwise derived classes which use this
        #may come a cropper when the current directory changes
        if codecs is None:
            encoding = None
        self.baseFilename, self.ext = os.path.splitext(os.path.abspath(filename))
        self.level_stream = {}
        self.mode = mode
        self.encoding = encoding
        if delay:
            #We don't open the stream, but we still need to call the
            #Handler constructor to set level, formatter, lock etc.
            logging.Handler.__init__(self)
            self.stream = None
        else:
            logging.StreamHandler.__init__(self)
    
    def _level_file(self, level):
        return '%s_%s%s' % (self.baseFilename, level, self.ext)

    def close(self):
        """
        Closes the stream.
        """
        for stream in self.level_stream.values():
            stream.flush()
            if hasattr(stream, 'close'):
                stream.close()
        logging.StreamHandler.close(self)
        self.stream = None

    def _open(self, levelno):
        """
        Open the current base file with the (original) mode and encoding.
        Return the resulting stream.
        """
        level = logging.getLevelName(levelno)
        if level in self.level_stream:
            return self.level_stream[level]
        _filename = self._level_file(level)
        if self.encoding is None:
            stream = open(_filename, self.mode)
        else:
            stream = codecs.open(_filename, self.mode, self.encoding)
        self.level_stream[level] = stream
        return stream

    def emit(self, record):
        """
        Emit a record.

        If the stream was not opened because 'delay' was specified in the
        constructor, open it before calling the superclass's emit.
        """
        self.stream = self._open(record.levelno)
        logging.StreamHandler.emit(self, record)

    

class SimpleFormatter(logging.Formatter):
    def __init__(self, *args, **kwargs):
        logging.Formatter.__init__(self, *args, **kwargs)
        self.use_utc = kwargs.get("use_utc", False)

    def format(self, record):
        try:
            record.message = record.getMessage()
        except Exception, e:
            record.message = "Bad message (%r): %r" % (e, record.__dict__)
        if self.use_utc:
            record.asctime = time.strftime("%Y-%m-%d %H:%M:%S", time.gmtime(record.created))
        else:
            record.asctime = time.strftime("%Y-%m-%d %H:%M:%S", time.localtime(record.created))
        prefix = '[%(levelname)1.1s %(asctime)s %(module)s:%(lineno)d]' % \
            record.__dict__
        formatted = prefix  + " " + record.message
        formatted = utf8(formatted)
        if record.exc_info:
            if not record.exc_text:
                record.exc_text = self.formatException(record.exc_info)
        if record.exc_text:
            formatted = formatted.rstrip() + "\n" + record.exc_text
        return formatted.replace("\n", "\n    ")
    
if __name__ == '__main__':
    setup_log()
    logging.warning("Invalid cookie signature %r", "-----how")
    logging.error("Invalid cookie signature %r", "-----how")
    logging.info("%d %s %.2fms", 200,
                   "get in", 1.12)    