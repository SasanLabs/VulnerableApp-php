FROM php:8.0-apache
LABEL maintainer="KSASAN preetkaran20@gmail.com"
RUN pecl install mongodb-1.16.2 && docker-php-ext-enable mongodb && a2enmod rewrite
COPY src/ /var/www/html/VulnerableApp-php/
COPY static/ /var/www/html/VulnerableApp-php/
COPY resources/ /var/www/html/VulnerableApp-php/resources
COPY vulnerablehtaccess/ /var/www/html/VulnerableApp-php/images/specialimages
RUN sed -ri '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
	&& sed -ri 's!<FilesMatch \\.php\$>!<FilesMatch "\\.(?:php|php5|php4|php3|phtml|phpt)$">!' /etc/apache2/conf-available/docker-php.conf \
	&& chown -R www-data:www-data /var/www/html/VulnerableApp-php/images \
	&& chmod -R u+rwX /var/www/html/VulnerableApp-php/images