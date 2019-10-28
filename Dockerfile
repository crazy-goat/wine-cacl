FROM alpine

RUN apk update \
    && apk add php-cli
