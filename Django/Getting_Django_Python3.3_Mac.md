GETTING DJANGO INSTALLED ON PYTHON 3.3 UNDER A VIRTUAL ENVIRONMENT (MAC):

<hr>

Keep in mind that:
<br>
1. If we want to use a specific version of Python on our system e.g. 3.3 along with its specific tools (pip, easy_install...), this will need to be specified by us at every step of the way. We have to go around the default version of Python in Mac, which is 2.7 and if it were to be changed we'd experience unexpected problems later on with other programs.
---Type "/usr/bin/python --version" to verify that it's "Python 2.7.5"
---Downloaded versions of Python e.g. 3.3 and 3.4 may be found at "/Library/Frameworks/Python.framework/Versions/". The actual Python versions would be at e.g. "/Library/Frameworks/Python.framework/Versions/3.3/bin/python3.3".
---Python components such as pip may be found at e.g. "/Library/Frameworks/Python.framework/Versions/3.3/bin" for version 3.3.
<br>
2. After we get the manage.py file from Django, we need to make sure that the version of Python that it's running is not the system-wide one ("/usr/bin/python"), but that which is specifically relevant to our virtual environment. We do this by replacing "#!/usr/bin/env python" with "#! ~/Documents/MAbout.com/venv/bin/python
".
---In my experience, unless this is done the Django module will not be retrieved by the program even if it's downloaded and in the correct location e.g. "/Library/Frameworks/Python.framework/Versions/3.3/lib/python3.3/site-packages". The error message will be "ImportError: No module named 'django'".
---In order to verify that Django may be retrieved, open Python in the terminal and type "import django". If there are no errors, it means that it's getting properly referenced.
<br>

<hr>

Follow the steps detailed in <a href="https://www.youtube.com/watch?v=oT1A1KKf0SI">this YouTube video</a>. These are:
<br>
1. Install the <a href="https://pypi.python.org/pypi/setuptools#installation-instructions">Python setuptools</a>. As the page says, the command will be
similar to "curl https://bootstrap.pypa.io/ez_setup.py -o - | python". Nevertheless, if we wish to use Python 3.3 the "python" after the pipe will need to be changed to "/Library/Frameworks/Python.framework/Versions/3.3/bin/python3.3".
<br>
2. Install the virtual environment using <a href="http://virtualenv.readthedocs.org/en/latest/virtualenv.html">a high enough version of pip</a>. E.g. type "/Library/Frameworks/Python.framework/Versions/3.3/bin/pip2.7 install virtualenv".
<br>
3. Create a virtualenv containing Python 3.3 by typing e.g. "virtualenv --no-site-packages -p /Library/Frameworks/Python.framework/Versions/3.3/bin/python3.3 venv
".
---"no-site-packages" makes sure that the virtualenv does not include root modules (that is, the virtualenv makes everything from scratch without relying on your computer's files).
---The "-p" and the filepath specifies the version of Python and its location that must be used. If this wasn't done, the virtualenv would have the default version of Python, 2.7.
---"venv" is the name of the virtual environment's directory that we'll access.
<br>
4. Enter the virtual environment by typing "source venv/bin/activate".
<br>
5. Install Django using the version of easy_install that's in the virtual environment by typing e.g. "/Users/miguelamigot/Documents/MAbout.com/venv/bin/easy_install Django".
<br>
6. Create the project files by typing "django-admin.py startproject PROJECTNAME".
<br>
7. Modify the Python environment specified by the manage.py file to reflect the virtual environment's version of Python instead of the system's.
---As stated above, this should be "#! ~/Documents/MAbout.com/venv/bin/python
" instead of "/usr/bin/python".
<br>
8. Run Django by typing "python manage.py runserver".
<br>
9. Leave the virtual environment by typing "deactivate".
<br>


<hr>

<br>
Useful links:
<br>
- http://stackoverflow.com/questions/14013728/django-no-module-named-django-core-management
- https://pypi.python.org/pypi/setuptools#installation-instructions
- http://stackoverflow.com/questions/13183112/installing-pip-for-python3-3
- http://stackoverflow.com/questions/23256054/install-django1-7-with-python-3-4-using-virtualenv
