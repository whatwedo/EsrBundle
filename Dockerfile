FROM --platform=linux/amd64 ubuntu:latest

RUN apt-get update -y &&\
    apt -y install software-properties-common &&\
    add-apt-repository ppa:ondrej/php &&\
    apt-get update

ARG DEBIAN_FRONTEND=noninteractive
RUN apt -y install php8.3 git zip wget tar unzip php8.3-gd php8.3-xml php8.3-mbstring libfontconfig1 libxrender1 curl php8.3-curl php8.3-bcmath

RUN wget https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.3/wkhtmltox-0.12.3_linux-generic-amd64.tar.xz &&\
    tar vxf wkhtmltox-0.12.3_linux-generic-amd64.tar.xz &&\
    cp wkhtmltox/bin/wk* /usr/local/bin/

WORKDIR /app

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&\
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" &&\
    php composer-setup.php &&\
    php -r "unlink('composer-setup.php');"

COPY composer.json /app/composer.json

RUN COMPOSER_ALLOW_SUPERUSER=1 php -d memory_limit=-1 composer.phar install

ADD . /app

ENTRYPOINT ["php"]

CMD ["./vendor/bin/phpunit"]
