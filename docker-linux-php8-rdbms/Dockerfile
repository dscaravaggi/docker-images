#
# 2023-09-05 tosn image Optimized
#
FROM debian:bookworm-slim


LABEL "com.supertosano"="Super Tosano" \
      version="1.0-exp" \
      MAINTAINER="Ufficio IT (ufficio.informatico@supertosano.com)" \
      description="Test of installation php apache stack ."

COPY ./assets/ibm-iaccess-1.1.0.27-1.0.amd64.deb /tmp   

RUN export LC_ALL=en_US.UTF-8 ;  apt -y update  && \
    apt-get install -y \
     apache2 \
     tar \
     libxrender1 \
     libfontconfig \
     libxext6 \
     apt-transport-https && \
    apt-get install -y \
     curl \ 
     freetds-bin \
     freetds-dev \
     git \
     libaio1 \
     libodbc1 \
     odbcinst \
     odbcinst1debian2 \
     php \
     php-cli \
     php-curl \
     php-dev \
     php-gd \
     php-json \
     php-ldap \
     php-mbstring \
     php-mysql \
     php-odbc \
     php-pear \
     php-pgsql \
     php-soap \
     php-sqlite3 \
     php-xml \
     php-xsl \
     php-zip \
     ssh \
     tdsodbc \
     unixodbc \
     unixodbc-dev \    
     unzip && \
    pecl version && \
    mkdir -p /tmp; cd /tmp; mkdir -p ./assets ; \
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


RUN echo /usr/lib/oracle/21.1/client64/lib > /etc/ld.so.conf.d/oracle.conf && \
    echo /opt/sqlanywhere17/lib64 > /etc/ld.so.conf.d/sqlany.conf && \
    ldconfig && \
    pecl channel-update pecl.php.net && \
    echo instantclient,/usr/lib/oracle/21.1/client64/lib | pecl install oci8 && \
    pecl install sqlsrv-5.11.0 && \
    pecl install pdo_sqlsrv-5.11.0 && \
    echo "extension=oci8.so" >> /etc/php/8.2/cli/conf.d/22-rdbms.ini && \
    echo "extension=sqlsrv.so" >> /etc/php/8.2/cli/conf.d/22-rdbms.ini && \
    echo "extension=pdo_sqlsrv.so" >> /etc/php/8.2/cli/conf.d/22-rdbms.ini && \
    cp --verbose /etc/php/8.2/cli/conf.d/22-rdbms.ini /etc/php/8.2/apache2/conf.d/22-rdbms.ini && \
    echo "<?php  phpinfo();" > /var/www/html/info.php && \
    dpkg -i /tmp/ibm-iaccess-1.1.0.27-1.0.amd64.deb && \
    /bin/rm -f /tmp/ibm-iaccess-1.1.0.27-1.0.amd64.deb && \
    echo "[SQL Anywhere 17]" > /tmp/sqlany_odbc.template && \
    echo "Description=SAP SQL Anywhere 17 ODBC Driver" >> /tmp/sqlany_odbc.template && \
    echo "Driver=/opt/sqlanywhere17/lib64/libdbodbc17_r.so" >> /tmp/sqlany_odbc.template && \
    echo "Setup=/opt/sqlanywhere17/lib64/libdbodbc17_r.so" >> /tmp/sqlany_odbc.template && \
    odbcinst -i -d -f  /tmp/sqlany_odbc.template && \
    curl --fail -o /tmp/msodbcsql.deb https://packages.microsoft.com/debian/11/prod/pool/main/m/msodbcsql17/msodbcsql17_17.10.4.1-1_amd64.deb && \
    ACCEPT_EULA=Y  dpkg -i /tmp/msodbcsql.deb ; /bin/rm --force /tmp/*.deb && \
    php -i | grep pdo  && \    
    mkdir -p /var/www/ && \
    EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')" ; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" ; \
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" ; \
    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then exit 1; fi ; \
    php composer-setup.php --install-dir=bin --quiet && \
    ln -s /usr/bin/composer.phar /usr/bin/composer && \
    php -r "unlink('composer-setup.php');" && \
    composer -V 

ENV NODE_PATH=/opt/sqlanywhere17/node \
    SQLANY17=/opt/sqlanywhere17 \
    ODBCINI=/etc/odbc.ini \
    TZ=Europe/Rome \
    PATH="/opt/sqlanywhere17/bin64:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"

EXPOSE 80

HEALTHCHECK --interval=30s --retries=2 CMD curl --fail http://localhost || exit 1

WORKDIR /var/www/

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]