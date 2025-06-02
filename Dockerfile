FROM php:8.2-apache            
                                 
# PHP�g���ƕK�v�c�[���̃C���X�g�[��       
RUN apt-get update && apt-get install -y git zip unzip libpng-dev libonig-dev libxml2-dev default-mysql-client && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd && apt-get clean && rm -rf /var/lib/apt/lists/*  
                                 
# Composer ���C���X�g�[��            
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  
                                 
# Apache �� rewrite ���W���[����L����  
RUN a2enmod rewrite               
                                 
# ��ƃf�B���N�g���� /var/www/html �ɐݒ�  
WORKDIR /var/www/html        
                                 
# �}�E���g���ꂽ�\�[�X�̏��L�҂� www-data �ɕύX  
RUN chown -R www-data:www-data /var/www/html  

RUN sed -ri 's!DocumentRoot /var/www/html!DocumentRoot /var/www/html/public!g' /etc/apache2/sites-available/*.conf \
 && sed -ri 's!<Directory /var/www/html>!<Directory /var/www/html/public>!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf