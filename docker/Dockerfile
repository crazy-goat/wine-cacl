FROM alpine

RUN apk update \
    && apk add php-cli php-tokenizer php-curl php-intl php-mbstring git composer \
    && mkdir -p /srv/http/wine-calc \
    && cd /srv/http/wine-calc \
    && git clone https://github.com/crazy-goat/wine-calc.git . \
    && composer install -o --no-dev \
    && composer init-prod \
    && composer init-rr \
    && apk del git \
    && rm -rf /var/cache/apk/*

WORKDIR /srv/http/wine-calc

CMD ./bin/rr serve