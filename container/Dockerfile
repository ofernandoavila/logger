# Usa a imagem PHP com Apache como base
FROM php:8.2-apache

# Instala as extensões necessárias, incluindo o pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Habilita o mod_rewrite para o Laravel
RUN a2enmod rewrite