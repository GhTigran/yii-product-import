<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Product Import</h1>
    <br />
</p>

This project is a basic implementation of product import from CSV file into database.


REQUIREMENTS
------------

The minimum requirement by this project is that your Web server supports PHP 7+ and MySQL 5.7+.


SETUP
------------

Clone this github project into your chosen directory

    git clone https://github.com/GhTigran/yii-product-import.git
    
    
Configure Nginx server. Here is a sample configuration

    server {
        charset utf-8;
        client_max_body_size 128M;
    
        listen 8888; ## listen for ipv4
    
        server_name localhost;
        root        {Change this with the path of the folder containing the project};
        index       index.php;
    
        access_log  {Change this with the path to access log file};
        error_log   {Change this with the path to error log file};
    
        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }
    
        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;
    
        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }
    
        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
    
        location ~* /\. {
            deny all;
        }
    }
        
Restart Nginx. The command may vary based on your OS.  
        
You can then access the application through the following URL:

    http://127.0.0.1:8888

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```
    
Prepare database tables and some initial dummy data

    ./yii migrate

**NOTES:**
- The project won't create the database for you, this has to be done manually before you can access it.