<h1>Installation Process Django + MongoDB + Django Rest Framework</h1>
<h2>Dash</h2>

<i>At any point, check what packages you have installed through "pip freeze".</i>
<b>Using pip-1.2.1</b>

<ol>

<li>
<a href="http://virtualenv.readthedocs.org/en/latest/virtualenv.html">Virtualenv</a>
</li>

<li>
<a href="http://virtualenvwrapper.readthedocs.org/en/latest/install.html#shell-startup-file">Virtualenvwrapper</a>
<br>
Specify a non-default version of Python using the corresponding versions of pip, etc. to install it. Will need to set the following environment variables if not working with the default version (compare to those in the given tutorial):
<ul>
<li>VIRTUALENVWRAPPER_PYTHON</li>
<li>WORKON_HOME</li>
<li>PROJECT_HOME</li>
<li>source /Library/Frameworks/Python.framework/Versions/3.3/bin/virtualenvwrapper.sh
(not an environment variable, but it denotes the location of virtualenvwrapper.sh for a specified version of Python)</li>
</ul>
When installing a virtualenv using virtualenvwrapper, type "mkvirtualenv --no-site-packages NAME_OF_YOUR_VIRTUALENV". Check the version of Python that comes with it by typing "python" and entering into the console of your virtualenv.
<br>
Example: mkvirtualenv -p /Library/Frameworks/Python.framework/Versions/7.1/bin/python2.7 --no-site-packages 27dashVenv
</li>


<li>
<a href="http://youtu.be/oT1A1KKf0SI?t=9m37s">easy_install Django</a>
<br>
Will read from Django's website and install the "best-match" version (On 7/2014, 1.6.5). Check that it's correctly installed by entering into the Python console and typing "import django" or directly typing "python manage.py shell". If you see "ImportError: No module named 'django'", doublecheck that you're entering into a Python console with the correct version.
</li>

<li>
django-admin.py startproject dashboard
<br>
(Starting with this command, go into the directory where you want to save the project)
<br>
This will create an upper directory and an inner directory with the same name. Django just cares about the name of the inner, so we can modify the name of the upper if we want to.
<br>
Possible error: using virtualenvwrapper and after having started a Django problem, there was an import error ("ImportError: Could not import settings") because I had defined the $DJANGO_SETTINGS_MODULE environment variable for the previous project, and django-admin.py was "confused" because of this (see <a href="http://stackoverflow.com/questions/8826534/how-can-i-correctly-set-django-settings-module-for-my-django-project-i-am-using">this</a>). The solution was to remove the value of the environment variable (an easy way to do this is to export it to a new value during the current section in a non-permanent way, which will lead the following Terminal process to interpret it as an empty value).
</li>

<li>
python3.3 manage.py runserver
<br>
Note that your version of Python may vary.
</li>

<li>
python3.3 manage.py startapp apiManager
<br>
Create an app for your project.
</li>

<li>
Add 'dashboard.apps.apiManager' to "INSTALLED_APPS" in settings.py
<br>
Note the importance of the path, starting from the main project.
</li>

<li>
python manage.py runserver
<br>
Possible error: "ImportError: No module named django.core.management".
Check the version of Python that the shebang is calling in manage.py. Even if
we are in a virtualenv, it will most likely call the system's version.
Replace the line, as shown <a href="http://stackoverflow.com/questions/6049933/django-import-error-no-module-named-core-management">here</a>.
</li>

<li>
pip install djangorestframework
<br>
Possible error: "Cannot fetch index base URL https://pypi.python.org/simple/".
This may be due to the version of pip (see <a href="http://stackoverflow.com/questions/21294997/pip-connection-failure-cannot-fetch-index-base-url-http-pypi-python-org-simpl">this</a>). The solution is to use a different version of pip by installing it through "easy_install pip==1.2.1".
</li>

<li>
Add 'rest_framework' to "INSTALLED_APPS" in settings.py
</li>

<li>
pip install git+https://github.com/django-nonrel/mongodb-engine
<br>
<a href="http://django-mongodb-engine.readthedocs.org/en/latest/topics/setup.html">Install Django MongoDB Engine</a>
<br>
Note that it may already be installed. Make sure that models.py is in the main application's ("dashboard").
<br>
Possible error (though it will not stop the installation): "ERROR:root:Error while trying to get django settings module". MongoDBEngine is trying to access the project's settings.py file in order to append itself as an app under "INSTALLED_APPS" (before any of our custom ones). Apparently, this is the only way it may work and otherwise it will not work in the future (see <a href="https://github.com/django-nonrel/mongodb-engine/blob/master/django_mongodb_engine/__init__.py">their explanation</a> and <a href="http://stackoverflow.com/questions/21381087/how-to-install-django-nonrel-package">this question</a>). Note the value of the $DJANGO_SETTINGS_MODULE environment variable.
<br>
In addition, note that in order to properly connect to a database, MongoDB must be running.
</li>


</ol>

