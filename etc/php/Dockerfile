FROM php:7.2.7-fpm

RUN apt-get update && apt-get upgrade
RUN apt-get -y install git curl zip libbz2-dev \
                        ntp libssl-dev \
                        libcurl4-openssl-dev \
                        pkg-config \
                        libxml2-dev \
                        libenchant-dev \
                        zlib1g-dev \
                        mysql-client \
                        libpng-dev \
                        libjpeg-dev \
                        libgmp-dev \
                        libc-client-dev \
                        libkrb5-dev \
                        libpspell-dev \
                        libreadline-dev \
                        libedit-dev \
                        librecode-dev \
                        libsodium-dev \
                        libxml2-dev \
                        libxslt-dev \
                        libmcrypt-dev

RUN apt-get -y install aspell-en \
                    aspell-ru

RUN docker-php-ext-install bcmath \
                            bz2 \
                            calendar \
                            ctype \
                            curl \
                            dom \
                            exif \
                            fileinfo \
                            gd \
                            gettext \
                            gmp \
                            hash \
                            iconv \
                            intl \
                            json \
                            mbstring \
                            opcache \
                            pcntl \
                            pdo \
                            pdo_mysql \
                            posix \
                            pspell \
                            readline \
                            recode \
                            session \
                            shmop \
                            simplexml \
                            sockets \
                            sodium \
                            sysvmsg \
                            sysvsem \
                            sysvshm \
                            xml \
                            xsl \
                            zip \
                            phar \
                            tokenizer \
                            xmlrpc


RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && docker-php-ext-install imap

# RUN apt-get update && apt-get -y install #libsnmp-dev
#reflection snmp soap spl

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /bin/composer
RUN apt-get clean all
