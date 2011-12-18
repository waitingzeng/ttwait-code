# Create your views here.
from load import load_emails
from django.shortcuts import HttpResponseRedirect
from django.contrib import messages

def update(request):
    referer = request.META.get('HTTP_REFERER', '')
    for i, item in load_emails():
        msg = '%s %s update success' % (i, item)
        print msg
        messages.info(request, msg)
        if i > 50:
            break
    return HttpResponseRedirect(referer)
