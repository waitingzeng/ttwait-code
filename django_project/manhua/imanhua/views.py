# Create your views here.
from django.http import HttpResponseRedirect,HttpResponse
from ext.common import render_template, render_to_response
from manager import get_manager

app = get_manager('manhua').get_ins('www.imanhua.com')
def comic(request, type_id):
    part_list = app.comic(type_id)
    return render_template(request, 'comic.html', {'part_list' : part_list, 'app_label' : app.app_label})

def comic_part(request, type_id, part_id):
    app_label = app.app_label
    server_list = app.get_server()
    img_list = app.get_img_list(type_id, part_id)
    return render_template(request, 'comic_part.html', locals())


def comic_show(request, type_id, part_id, img_id):
    page = app.get_img(type_id, part_id, img_id)
    return HttpResponse(page, mimetype='image/jpeg')
    