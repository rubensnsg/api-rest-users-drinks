
Options  FollowSymLinks
RewriteEngine On
RewriteBase /

RewriteRule ^(.*)$ index.php?url=$1 [QSA, L]