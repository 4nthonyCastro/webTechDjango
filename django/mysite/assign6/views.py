from django.shortcuts import render
from django.http import HttpResponse

from django.template import loader
from .models import Post


def index(request):
    template = loader.get_template('assign6/index.html')
    return HttpResponse(template.render())

def simple_upload(request):
    if request.method == 'POST' and request.FILES['myfile']:
        myfile = request.FILES['myfile']
        fs = FileSystemStorage()
        filename = fs.save(myfile.name, myfile)
        uploaded_file_url = fs.url(filename)
        return render(request, 'templates/assign6/simple_upload.html', {
            'uploaded_file_url': uploaded_file_url
        })
    return render(request, 'templates/assign6/simple_upload.html')


