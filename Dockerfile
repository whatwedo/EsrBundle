FROM registry.whatwedo.ch/whatwedo/docker-base-images/php:v3.1

ARG WKHTMLTOPDF_VERSION=0.12.6.1-3

USER root
RUN curl -fsSL -o /tmp/wkhtmltox.deb \
        "https://github.com/wkhtmltopdf/packaging/releases/download/${WKHTMLTOPDF_VERSION}/wkhtmltox_${WKHTMLTOPDF_VERSION}.bookworm_$(dpkg --print-architecture).deb" && \
    apt-install /tmp/wkhtmltox.deb && \
    rm /tmp/wkhtmltox.deb && \
    mkdir /var/www && \
    chown app:app /var/www
USER app

WORKDIR /var/www
