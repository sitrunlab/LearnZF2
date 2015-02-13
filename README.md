LearnZF2 repository
===================

[![Build Status](https://secure.travis-ci.org/sitrunlab/LearnZF2.png?branch=develop)](http://travis-ci.org/sitrunlab/LearnZF2)
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

 4.Execute Sql dump that located in **data/sql** directory into MySQL database.
 
 5.Copy <code>config/autoload/doctrine.local.php.dist</code> to <code>config/autoload/doctrine.local.php</code> and configure it with your current environment.


 

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
