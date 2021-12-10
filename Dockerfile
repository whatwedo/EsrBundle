FROM ubuntu:18.04

RUN apt-get update -y &&\
    apt -y install software-properties-common &&\
    add-apt-repository ppa:ondrej/php &&\
    apt-get update

ARG DEBIAN_FRONTEND=noninteractive
RUN apt -y install php7.4 git zip wget tar unzip php7.4-gd php7.4-xml php7.4-mbstring libfontconfig1 libxrender1

RUN wget https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.3/wkhtmltox-0.12.3_linux-generic-amd64.tar.xz &&\
    tar vxf wkhtmltox-0.12.3_linux-generic-amd64.tar.xz &&\
    cp wkhtmltox/bin/wk* /usr/local/bin/

WORKDIR /app

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&\
    php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" &&\
    php composer-setup.php &&\
    php -r "unlink('composer-setup.php');"

COPY composer.json /app/composer.json

RUN php -d memory_limit=-1 composer.phar install

ADD . /app

ENTRYPOINT ["php"]

CMD ["./vendor/bin/phpunit"]
