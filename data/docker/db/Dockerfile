#FROM mysql:8.0.3
FROM mariadb:10.5

MAINTAINER Vladislav Dehtarev <dehtarev.vladislav@gmail.com>

ARG HOST_UID=1000

VOLUME ["/var/lib/mysql"]

RUN usermod -u ${HOST_UID} mysql

EXPOSE 3306
