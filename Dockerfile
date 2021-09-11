FROM php:8.0-apache
LABEL maintainer="KSASAN preetkaran20@gmail.com"
COPY src/ /var/www/html/VulnerableApp-php/
COPY static/ /var/www/html/VulnerableApp-php/
COPY resources/ /var/www/html/VulnerableApp-php/resources
RUN mkdir -p /var/www/html/VulnerableApp-php/images && chmod -R 777 /var/www/html/ \
    && ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load