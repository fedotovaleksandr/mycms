FROM nginx:latest

COPY nginx.conf /etc/nginx/
COPY mycms.conf /etc/nginx/sites-available/

RUN rm /etc/nginx/conf.d/default.conf
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80 443
