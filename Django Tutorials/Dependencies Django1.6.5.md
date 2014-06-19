ADDING CSS, JS... (anything) DEPENDENCIES TO DJANGO 1.6.5:

<hr>

Keep in mind that:
<br />
1. This is applicable to anything from custom CSS and JS files to framework dependences to PDFs (anything).
<br />
2. There are a couple of ways to do this and this guide covers the "development" way i.e. there's most likely a more efficient/secure way to do this for a production environment.
<br />
3. This takes advantage of relative paths, meaning that it should be easy to reference our static files if our app were to be used for another project (if the URLs to the dependencies e.g. Bootstrap .css files were absolute, then we'd have to fix all of the templates, etc. in our new project).
<br />
4. The way in which you organize your files is up to you. Once we go through with this we'll be able to specify the filepaths that we prefer.
<br />
5. This is specific to Django 1.6.5 and it may not apply to future versions of the framework.

<br />

<hr>

Follow the steps detailed in <a href="https://www.youtube.com/watch?v=3Dgfp6hLznA">this YouTube video</a>. These are:
<br />
1. Create a folder named "Static" in the project's directory (the directory in which "manage.py" is contained) and place your files in them in whatever path structure you prefer.
<br />
2. On the project's settings.py file, specify the STATIC_ROOT, STATIC_URL and STATICFILES_DIR variables as explained by <a href="https://docs.djangoproject.com/en/1.6/ref/settings/#std:setting-STATIC_ROOT">Django's docs</a>. As <a href="http://youtu.be/3Dgfp6hLznA?t=6m22s">Mike Hibbert's YouTube tutorial explains at 6:30</a>, STATICFILES_DIR will specifically need to be told about the location of the files you currently have in the "static" folder and the folder wherein they will go into (in this example, the latter is named "assets"). As we'll see, a Django program will retrieve the contents from "static" and put them into "assets" before we can use them.
<br />
3. Reference them accordingly from the HTML templates.
---At the very top, call "{% load static %}"
---When retreiving a file, use e.g .: "<link href="{% static 'assets/bootstrap-3.1.1-dist/css/bootstrap.min.css' %}" rel="stylesheet" media="screen">"
<br />
4. Run the Django program that will properly copy your files into the location it can use by typing "python manage.py collectstatic" (and saying "yes" after).
---If you are in a virtual environment and this doesn't work, make sure you are using the version of Python that the virtual environment has been running on by typing e.g. "../bin/python3.3 manage.py collectstatic".
<br />
5. An "assets" folder (if that's the name you specified) will have been created, and now its content can properly be referenced from the HTML templates.
<br />


<hr>

<br />
Useful links:
<br />
- https://www.youtube.com/watch?v=3Dgfp6hLznA
- https://docs.djangoproject.com/en/1.6/ref/settings/#std:setting-STATIC_ROOT
- http://effectivedjango.com/tutorial/static.html#adding-static-files
- https://github.com/josephmisiti/generic-django-project
- https://medium.com/cs-math/11-things-i-wish-i-knew-about-django-development-before-i-started-my-company-f29f6080c131
