FROM nginx:1.23.3

LABEL maintainer="Habibur Rahman Riad <riad.iuxit@gmail.com>"

ARG TIMEZONE="Asia/Dhaka"

ENV TZ="${TIMEZONE}"

USER root


RUN echo "--- Set Timezone ---" \
        && echo "${TZ}" > /etc/timezone \
        && rm /etc/localtime \
        && dpkg-reconfigure -f noninteractive tzdata \
    && echo "-- Trust CA Certs --" \
        && update-ca-certificates \
    && echo "-- Install APT Dependencies --" \
        && apt update \
        && apt upgrade -y \
    && echo "--- Clean Up ---" \
        && apt-get clean -y \
        && apt-get autoremove -y \
        && rm -f /etc/nginx/conf.d/*.conf

ARG UID="1000"
ARG GID="1000"

RUN groupadd --gid ${GID} app \
    && useradd --uid ${UID} --create-home --system --comment "App User" --shell /bin/bash --gid app app

ENV NGINX_CONF_USER="app app" \
    NGINX_CONF_HTTP_CLIENT_MAX_BODY_SIZE="2m" \
    NGINX_VHOST_DNS_RESOLVER_IP="127.0.0.11" \
    NGINX_VHOST_ENABLE_HTTP_TRAFFIC="true" \
    NGINX_VHOST_ENABLE_HTTPS_TRAFFIC="false" \
    NGINX_VHOST_UPSTREAM_PHPFPM_SERVICE_HOST_PORT="tatted-app:9000" \
    NGINX_VHOST_SSL_CERTIFICATE="/etc/ssl/certs/ssl-cert-snakeoil.pem" \
    NGINX_VHOST_SSL_CERTIFICATE_KEY="/etc/ssl/certs/ssl-cert-snakeoil.key" \
    NGINX_VHOST_HTTP_SERVER_NAME="_" \
    NGINX_VHOST_HTTPS_SERVER_NAME="_" \
    NGINX_VHOST_FASTCGI_PARAM_X_FORWARDED_PORT="8080"

# Add Nginx Configs
COPY --chown=app:app ./docker/web/nginx.conf /etc/nginx/nginx.conf
COPY --chown=app:app ./docker/web/conf.d/*.conf /etc/nginx/conf.d/
COPY --chown=app:app ./docker/web/includes/*.conf /etc/nginx/includes/


# Remove the Additional Entrypoints that comes with the image
RUN rm -rf /docker-entrypoint.d/*.sh

# Add our own Additional Entrypoints
COPY --chown=app:app ./docker/web/entrypoint.sh /docker-entrypoint.sh

WORKDIR /var/www/html

COPY --chown=app:app ./codes/public ./public


RUN chmod ugo+x /docker-entrypoint.sh \
    && touch /var/run/nginx.pid \
    && chown -R app:app /var/www/html /etc/nginx/ /run/nginx.pid /var/cache/nginx /var/log/nginx

ARG SHOULD_CHOWN_TO_APP="true"

RUN if [ "${SHOULD_CHOWN_TO_APP}" = "true" ]; then \
        chown -R app:app . \
    ;fi

ENTRYPOINT [ "/docker-entrypoint.sh" ]

CMD ["nginx"]

USER app