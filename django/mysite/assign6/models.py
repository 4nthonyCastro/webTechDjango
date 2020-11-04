import datetime

from django.db import models
from django.utils import timezone

class Post(models.Model):
    title = models.TextField()
    cover = models.ImageField(upload_to='images/')

    def __str__(self):
        return self.title

# Create your models here.
