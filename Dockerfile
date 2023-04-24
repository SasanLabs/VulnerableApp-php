FROM jamesbrink/php:latest
LABEL maintainer="KSASAN preetkaran20@gmail.com"
COPY src/ /var/www/localhost/htdocs/VulnerableApp-php/
COPY static/ /var/www/localhost/htdocs/VulnerableApp-php/
COPY resources/ /var/www/localhost/htdocs/VulnerableApp-php/resources
COPY vulnerablehtaccess/ /var/www/localhost/htdocs/VulnerableApp-php/images/specialimages
RUN chmod -R 777 /var/www/localhost/htdocs/ && \ 
sed -i '/<Directory \/var\/www\localhost/htdocs/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/httpd.conf \
&& sed -i 's/\\.php$>/"(?i)\\.php$|\\.php5$|\\.php4$|\\.php3$|\\.phtml$|\\.phpt$">/' /etc/apache2/conf.d/php.conf 
