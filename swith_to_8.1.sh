#!/bin/bash
sudo -i
sudo a2dismod php & sudo a2dismod php7.4 &  sudo a2dismod php7.1 &  sudo a2enmod php8.1 & sudo service apache2 restart & update-alternatives --set php /usr/bin/php8.1
