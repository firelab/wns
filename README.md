What the Phone Home Does: 


This server displays the stats of WindNinja Gui runs and shows who is using it and when. This server runs on the ninjastorm.firelab.org server. 

### 
It uses curl requests to IPINFO to geolocate users based on IP.

###
PHP scripts query a Sqlite db with user info stored and this info gets displayed in vanilla JS. 


###
To edit SSH into /etc/var/www/html/sqlitetest 
/etc/apache2/error.log.1 or /etc/apache2/error.log help debug the PHP
