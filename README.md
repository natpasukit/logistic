# logistic
solving shortest path and bin packing

This things require PHP 5.6+ for stable used ( 5.5 might work , 5.3 API will not working thus breaking the application )

# Configure
You need to use .htaccess as below since this use slim as sub-directory
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ api.php [QSA,L]

for nginx
if (!-e $request_filename){
    rewrite ^(.*)$ /api.php break;
}

You may consider to remove these 2 line as it is for development purpose.
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
