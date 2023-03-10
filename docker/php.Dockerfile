#Creator: Lory LÉTICÉE
#Editor:

FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y nano vim tree git libzip-dev zip gnupg && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install bcmath && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug 
    
RUN apt-get install -y libpng-dev libfreetype6-dev libjpeg62-turbo-dev && \
    docker-php-ext-configure gd && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install exif

#install NMV (change node latest lts version)
RUN rm /bin/sh && ln -s /bin/bash /bin/sh
RUN touch ~/.bashrc && chmod +x ~/.bashrc

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
RUN . ~/.nvm/nvm.sh && source ~/.bashrc && nvm install 18.15.0

#install curl
RUN apt-get update && \
    apt-get install curl -y

#install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo 'deb https://dl.yarnpkg.com/debian/ stable main' | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update -y && apt-get install yarn -y

RUN yarn install

#Add encore for package.json's scripts key requirements
RUN yarn add encore

#Generate assets files
RUN sh -l -c yarn build


# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.19