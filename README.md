LearnZF2 repository
=======================

Introduction
------------
Ini adalah repository untuk website belajar ZF2. Berisi real "LIVE" module yang bisa diview oleh user, bisa didownload kalau berminat.


Installation
------------
 1.menggunakan bower untuk menginstall assets dependency. Install NodeJs dan run :
```
sudo npm install -g bower
bower install
```
 2.Dan kita akan dapat run installed dependency

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

Check apakah bower telah terinstall sempurna :
```
bower -version
```

Apabila bower telah terinstall sempurna, kita akan dapat melihat hasi return seperti ini :
```
bower -version
1.3.3
```

[optional] Namun apabila tidak di dapati return apapun, coba dengan meng-install nodejs-legacy
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

Cara paling mudah untuk memulai jika kita menggunakan PHP 5.4 atau di atas untuk memulai PHP internal yang cli-server di direktori root:

    php -S 0.0.0.0:8080 -t public/ public/index.php

Ini akan memulai cli-server pada port 8080, dan mengikat ke semua jaringan
interface.

**Catatan: ** The built-in CLI server hanya untuk *development*.

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
