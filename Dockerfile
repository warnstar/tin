FROM php:7.1-fpm

RUN ln -sf /usr/share/zoneinfo/Asia/Shanghai  /etc/localtime

RUN sed -i 's/deb.debian.org/mirrors.ustc.edu.cn/g' /etc/apt/sources.list

# Install modules
RUN apt-get update
RUN apt-get install -y \
        git \
        curl \
        openssl \
        wget \
        vim \
        libssl-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libicu-dev \
        libpcre3 libpcre3-dev \
        zlib1g-dev \
             --no-install-recommends

# ########### nginx ################
RUN wget http://nginx.org/download/nginx-1.12.0.tar.gz -O nginx.tar.gz \
    && mkdir -p nginx \
    && tar -xf nginx.tar.gz -C nginx --strip-components=1 \
    && rm nginx.tar.gz

RUN cd nginx && ./configure \
    --prefix=/etc/nginx \
    --sbin-path=/usr/sbin/nginx \
    --modules-path=/usr/lib/nginx/modules \
    --conf-path=/etc/nginx/nginx.conf \
    --error-log-path=/var/log/nginx/error.log \
    --http-log-path=/var/log/nginx/access.log \
    --pid-path=/var/run/nginx.pid \
    --lock-path=/var/run/nginx.lock \
    --http-client-body-temp-path=/var/cache/nginx/client_temp \
    --http-proxy-temp-path=/var/cache/nginx/proxy_temp \
    --http-fastcgi-temp-path=/var/cache/nginx/fastcgi_temp \
    --http-uwsgi-temp-path=/var/cache/nginx/uwsgi_temp \
    --http-scgi-temp-path=/var/cache/nginx/scgi_temp \
    --user=www-data \
    --group=www-data \
    --with-compat \
    --with-file-aio \
    --with-threads \
    --with-http_addition_module \
    --with-http_auth_request_module \
    --with-http_dav_module \
    --with-http_flv_module \
    --with-http_gunzip_module \
    --with-http_gzip_static_module \
    --with-http_mp4_module \
    --with-http_random_index_module \
    --with-http_realip_module \
    --with-http_secure_link_module \
    --with-http_slice_module \
    --with-http_ssl_module \
    --with-http_stub_status_module \
    --with-http_sub_module \
    --with-http_v2_module \
    --with-mail \
    --with-mail_ssl_module \
    --with-stream \
    --with-stream_realip_module \
    --with-stream_ssl_module \
    --with-stream_ssl_preread_module \
    --with-cc-opt='-g -O2 -fstack-protector-strong -Wformat -Werror=format-security -Wp,-D_FORTIFY_SOURCE=2 -fPIC' \
    --with-ld-opt='-Wl,-z,relro -Wl,-z,now -Wl,--as-needed -pie' \
    && make \
    && make install \
    && mkdir -p /var/cache/nginx/


# Install composer && global asset plugin
ENV COMPOSER_HOME /root/.composer
ENV PATH /root/.composer/vendor/bin:$PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer config -g repo.packagist composer https://packagist.phpcomposer.com

#install extension
RUN docker-php-ext-install zip \
    && docker-php-ext-install mcrypt \
    && docker-php-ext-install intl \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath

#install gd
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

#install swoole
RUN wget http://pecl.php.net/get/swoole-2.1.1.tgz \
    && pecl install swoole-2.1.1.tgz \
    && rm -f swoole-2.1.1.tgz \
    && docker-php-ext-enable swoole

# redis
RUN wget http://pecl.php.net/get/redis-3.1.6.tgz \
    && pecl install redis-3.1.6.tgz \
    && rm -f redis-3.1.6.tgz \
    && docker-php-ext-enable redis

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*


ADD . /var/www/html

WORKDIR /var/www/html

COPY ./nginx.conf /etc/nginx/nginx.conf


RUN chmod -R 777 /tmp

RUN usermod -u 1000 www-data

EXPOSE 80 443
CMD ["php index.php"]