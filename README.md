Install
=
Update a file for actual DB config ./config/autoload/doctrine.local.php.
Add new host (at the example example.com).

>composer install

>./vendor/bin/doctrine-module orm:schema-tool:update --force

Using
=
Create
>curl -X POST -H 'Content-Type: application/json' -d '{"name":"name1","fullname":"lalala","email":"email@bigmir.net"}' http://example.com/api/create

Read
>curl -X GET http://example.com/api/read/1

Update
>curl -X PUT -H 'Content-Type: application/json' -d '{"name":"vasya123"}' http://example.com/api/update/1

Delete
>curl -X DELETE http://example.com/api/delete/1

Require
=
PHP 5.6

MySQL 5.*

curl

Apache 2.4+

web-server

Example config host (in OS Linux Ubuntu)
=
    <VirtualHost *:80>
        ServerName example.com
    
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/public
    
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
        <Directory /var/www/html/public>
             DirectoryIndex index.php
             AllowOverride All
             Require all granted
        </Directory>
    </VirtualHost>
