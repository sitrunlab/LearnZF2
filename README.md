LearnZF2 repository
=======================

[![Build Status](https://secure.travis-ci.org/sitrunlab/LearnZF2.png?branch=develop)](http://travis-ci.org/sitrunlab/LearnZF2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sitrunlab/LearnZF2/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/sitrunlab/LearnZF2/?branch=develop)
[![Coverage Status](https://coveralls.io/repos/sitrunlab/LearnZF2/badge.png?branch=develop)](https://coveralls.io/r/sitrunlab/LearnZF2)

Introduction
------------
This is a repository for the "Learning Zend Framework" website and contains live modules that you can view or download directly.


Installation
------------
 1.Use Bower to install asset dependencies. Install NodeJs dan run :

```
sudo npm install -g bower
bower install
```

 2.This is the output of the Bower installation process.

```
bower install
-----------------------------------------
Update available: 1.3.9 (current: 1.3.7)
Run npm update -g bower to update
-----------------------------------------

bower bootstrap#3.0.3           cached git://github.com/twbs/bootstrap.git#3.0.3
bower bootstrap#3.0.3         validate 3.0.3 against git://github.com/twbs/bootstrap.git#3.0.3
bower jquery#1.10.2             cached git://github.com/jquery/jquery.git#1.10.2
bower jquery#1.10.2           validate 1.10.2 against git://github.com/jquery/jquery.git#1.10.2
bower jquery-ui#1.10.3          cached git://github.com/components/jqueryui.git#1.10.3
bower jquery-ui#1.10.3        validate 1.10.3 against git://github.com/components/jqueryui.git#1.10.3
bower selectize#0.8.5           cached git://github.com/brianreavis/selectize.js.git#0.8.5
bower selectize#0.8.5         validate 0.8.5 against git://github.com/brianreavis/selectize.js.git#0.8.5
bower sifter#0.3.x              cached git://github.com/brianreavis/sifter.js.git#0.3.3
bower sifter#0.3.x            validate 0.3.3 against git://github.com/brianreavis/sifter.js.git#0.3.x
bower microplugin#0.0.x         cached git://github.com/brianreavis/microplugin.js.git#0.0.3
bower microplugin#0.0.x       validate 0.0.3 against git://github.com/brianreavis/microplugin.js.git#0.0.x
bower sifter#0.3.x                 new version for git://github.com/brianreavis/sifter.js.git#0.3.x
bower sifter#0.3.x             resolve git://github.com/brianreavis/sifter.js.git#0.3.x
bower sifter#0.3.x            download https://github.com/brianreavis/sifter.js/archive/v0.3.4.tar.gz
...
```

Check that Bower was installed successfully :

```
bower -version
```

The output should look like this:

```
bower -version
1.3.3
```

[optional] If there was no output, try installing nodejs-legacy

```
sudo apt-get install nodejs-legacy
```

 3.run composer update

```
php composer.phar self-update && php composer.phar install
```

Web Server Setup
----------------

### PHP CLI Server

The easiest way to begin in PHP 5.4 or higher is by running this script:

    php -S 0.0.0.0:8080 -t public/ public/index.php

The script above will start "cli-server" on port 8080 and affect all network interfaces.

**Warning:** The built in CLI-Server is for development only!

### Apache Setup

    <VirtualHost *:80>
        ServerName learnzf2.localhost
        DocumentRoot /path/to/LearnZF2/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/learnzf2.localhost/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

### Nginx Setup

Create a new file named "learnzf2.localhost"

    sudo gedit /etc/nginx/sites-available/learnzf2.localhost

And filled it with these scripts.

    server {
          listen      80;
          server_name learnzf2.localhost;
          root        /path/to/LearnZF2/public;
          index       index.html index.htm index.php;

          location / {
            try_files $uri $uri/ /index.php$is_args$args;
          }

          location ~ \.php$ {
            fastcgi_pass unix:/var/run/php5-fpm.sock;
            fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include        fastcgi_params;
          }
    }

Create a symlink to the "sites-enabled" directory

    sudo ln -s /etc/nginx/sites-available/learnzf2.localhost /etc/nginx/sites-enabled/learnzf2.localhost

Restart the Nginx service.

    sudo service nginx restart


**NOTE :**
Don't forget to add a "virtual hostname" to the host file.

The host file location in Windows is :

    C:\Windows\System32\Drivers\etc\hosts


The host file location in Linux is :

    sudo gedit /etc/hosts


And add this line :

    127.0.0.1 learnzf2.localhost


### Git Publish

It would be easier to use git flow to publish your branch, by git flow, you always use feature checked out from develop branch, and when you done and want to create a Pull Request, you can run :

    git flow feature yourfeature publish

Next commit you need to push manually :

    git push origin yourfeature

It seems more keywords, but it's just a little things for many elegant way to switching branch and merging with git flow. By running git flow, you have summary like :

    $ git flow feature start download-plugin

Switched to a new branch **'feature/download-plugin'**

Summary of actions:
- A new branch 'feature/download-plugin' was created, based on 'develop'
- You are now on branch 'feature/download-plugin'

Now, start committing on your feature. When done, use:

     git flow feature finish download-plugin
It would be very usefull when you want to managing hotfix that merge to develop and master automatically when finish a hotfix flow.

For full command, you can check [Git flow cheatsheet](http://danielkummer.github.io/git-flow-cheatsheet/)
