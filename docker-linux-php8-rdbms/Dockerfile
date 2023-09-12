#
# 2023-09-05 tosn image Optimized
#
FROM debian:bookworm-slim


LABEL "com.supertosano"="Super Tosano"
LABEL version="1.0-exp"
LABEL MAINTAINER="Ufficio IT (ufficio.informatico@supertosano.com)"

LABEL description="Test of installation php apache stack ."


RUN export LC_ALL=en_US.UTF-8 ;  apt -y update  && \
    apt-get install -y \
     apache2 \
     tar \
     libxrender1 \
     libfontconfig \
     libxext6 \
     apt-transport-https && \
    apt-get install -y \
     unzip \
     curl \
     git \
     php-cli \
     php \
     php-curl \
     php-gd \
     php-json \
     php-ldap \
     php-mbstring \
     php-mysql \
     php-pgsql \
     php-sqlite3 \
     php-xml \
     php-xsl \
     php-zip \
     php-soap \
     ssh \
     php-pear \
     php-dev \
     libaio1 \
     php-odbc \
     unixodbc \
     odbcinst \
     libodbc1 \
     odbcinst1debian2 \
     unixodbc-dev && \
    pecl -v

RUN mkdir -p /tmp; cd /tmp; mkdir -p ./assets ; \
    curl --fail --silent -o ./assets/instantclient-basic-linuxx64.zip \
        https://download.oracle.com/otn_software/linux/instantclient/instantclient-basic-linuxx64.zip && \
    curl --fail --silent -o ./assets/instantclient-sdk-linuxx64.zip \
        https://download.oracle.com/otn_software/linux/instantclient/instantclient-sdk-linuxx64.zip && \
    curl --fail --silent -o ./assets/sql_anywherelinux_x64.tar.gz \
        https://d5d4ifzqzkhwt.cloudfront.net/sqla17client/sqla17_client_linux_x86x64.tar.gz && \
    tar xvfz ./assets/sql_anywherelinux_x64.tar.gz && \
    mv --verbose ./client17* ./client17any && \
    ./client17any/setup -silent -nogui -I_accept_the_license_agreement -install sqlany_client64 -company Tosano && \
    mkdir -p /usr/lib/oracle/21.1/client64 ; \
    cd /usr/lib/oracle/21.1/client64 ; \
    unzip /tmp/assets/instantclient-basic-linuxx64.zip && \
    unzip /tmp/assets/instantclient-sdk-linuxx64.zip && \
    mv --verbose /usr/lib/oracle/21.1/client64/instantclient*/  /usr/lib/oracle/21.1/client64/lib/ && \
       ls -l /usr/lib/oracle/21.1/client64/lib/ && \
    /bin/rm -rf /tmp/assets ; \
    apt-get clean ; 

COPY ./assets/ibm-iaccess-1.1.0.27-1.0.amd64.deb /tmp   

RUN echo /usr/lib/oracle/21.1/client64/lib > /etc/ld.so.conf.d/oracle.conf && \
    echo /opt/sqlanywhere17/lib64 > /etc/ld.so.conf.d/sqlany.conf && \
    ldconfig && \
    apt-get install php-sqlite3 && \
    apt-get -y install php-pgsql && \
    pecl channel-update pecl.php.net && \
    echo instantclient,/usr/lib/oracle/21.1/client64/lib | pecl install oci8 && \
    pecl install sqlsrv-5.11.0 && \
    pecl install pdo_sqlsrv-5.11.0 && \
    echo "extension=oci8.so" >> /etc/php/8.2/cli/conf.d/22-rdbms.ini && \
    echo "extension=sqlsrv.so" >> /etc/php/8.2/cli/conf.d/22-rdbms.ini && \
    echo "extension=pdo_sqlsrv.so" >> /etc/php/8.2/cli/conf.d/22-rdbms.ini && \
    cp --verbose /etc/php/8.2/cli/conf.d/22-rdbms.ini /etc/php/8.2/apache2/conf.d/22-rdbms.ini && \
    echo "<?php  phpinfo();" > /var/www/html/info.php && \
    php -i | grep pdo  && \    
    mkdir -p /var/www/

RUN dpkg -i /tmp/ibm-iaccess-1.1.0.27-1.0.amd64.deb && \
    /bin/rm -f /tmp/ibm-iaccess-1.1.0.27-1.0.amd64.deb && \
    echo "[SQL Anywhere 17]" > /tmp/sqlany_odbc.template && \
    echo "Description=SAP SQL Anywhere 17 ODBC Driver" >> /tmp/sqlany_odbc.template && \
    echo "Driver=/opt/sqlanywhere17/lib64/libdbodbc17_r.so" >> /tmp/sqlany_odbc.template && \
    echo "Setup=/opt/sqlanywhere17/lib64/libdbodbc17_r.so" >> /tmp/sqlany_odbc.template && \
    odbcinst -i -d -f  /tmp/sqlany_odbc.template

ENV TZ=Europe/Rome

EXPOSE 80

HEALTHCHECK --interval=30s --retries=2 CMD curl --fail http://localhost || exit 1

WORKDIR /var/www/

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]