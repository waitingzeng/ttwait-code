#!/usr/bin/env python
#
# Copyright 2007 Google Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#



"""Convenience wrapper for starting an appengine tool."""


import os
import sys


if not hasattr(sys, 'version_info'):
  sys.stderr.write('Very old versions of Python are not supported. Please '
                   'use version 2.5 or greater.\n')
  sys.exit(1)
version_tuple = tuple(sys.version_info[:2])
if version_tuple < (2, 4):
  sys.stderr.write('Error: Python %d.%d is not supported. Please use '
                   'version 2.5 or greater.\n' % version_tuple)
  sys.exit(1)

#DIR_PATH = os.path.abspath(os.path.dirname(os.path.realpath(__file__)))
DIR_PATH = 'D:/Code/google_appengine'
SCRIPT_DIR = os.path.join(DIR_PATH, 'google', 'appengine', 'tools')



EXTRA_PATHS = [
  DIR_PATH,
  os.path.join(DIR_PATH, 'lib', 'antlr3'),
  os.path.join(DIR_PATH, 'lib', 'django_0_96'),
  os.path.join(DIR_PATH, 'lib', 'fancy_urllib'),
  os.path.join(DIR_PATH, 'lib', 'ipaddr'),
  os.path.join(DIR_PATH, 'lib', 'protorpc'),
  os.path.join(DIR_PATH, 'lib', 'webob'),
  os.path.join(DIR_PATH, 'lib', 'yaml', 'lib'),
  os.path.join(DIR_PATH, 'lib', 'simplejson'),
  os.path.join(DIR_PATH, 'lib', 'graphy'),
]


SCRIPT_EXCEPTIONS = {
  "dev_appserver.py" : "dev_appserver_main.py"
}


def fix_sys_path():
  """Fix the sys.path to include our extra paths."""
  sys.path = EXTRA_PATHS + sys.path


def run_file(file_path, globals_, script_dir=SCRIPT_DIR):
  """Execute the file at the specified path with the passed-in globals."""
  fix_sys_path()
  script_name = os.path.basename(file_path)
  script_name = SCRIPT_EXCEPTIONS.get(script_name, script_name)
  script_path = os.path.join(script_dir, script_name)
  execfile(script_path, globals_)


def main(argv):
  fix_sys_path()
  from google.appengine.tools.appcfg import AppCfgApp
  import logging
  import getpass
  logging.basicConfig(format=('%(asctime)s %(levelname)s %(filename)s:'
                              '%(lineno)s %(message)s '))
  
  newargv = []
  password = None
  index = -1
  for i, arg in enumerate(argv):
    if arg == '--password':
        password = argv[i+1]
        index = i
        break
  
  if index >= 0:
      argv.pop(index+1)
      argv.pop(index)

  def get_password(*args, **kwargs):
      return password or getpass.getpass()

  try:
    result = AppCfgApp(argv, password_input_fn=get_password).Run()
    if result:
      sys.exit(result)
  except KeyboardInterrupt:
    StatusUpdate('Interrupted.')
    sys.exit(1)


if __name__ == '__main__':
  main(sys.argv)
