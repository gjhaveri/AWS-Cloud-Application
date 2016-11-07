#!/bin/bash

git clone git@github.com:illinoistech-itm/gjhaveri.git /home/ubuntu/gjhaveri

sudo apt-get update
sudo apt-get -y install git apache2 php-xml libapache2-mod-php php php-mysql curl php-curl zip unzip

export COMPOSER_HOME=/root && /usr/bin/composer.phar self-update 1.0.0-alpha11

sudo curl -sS https://getcomposer.org/installer | php

sudo php composer.phar require aws/aws-sdk-php
sudo systemctl enable apache2
sudo systemctl start apache2
	
sudo mv vendor /var/www/html/

#sudo rm index.html /var/www/html/

sudo git clone https://github.com/illinoistech-itm/gjhaveri

sudo mv /home/ubuntu/gjhaveri/*.php	 /var/www/html/
#git@github.com:illinoistech-itm/gjhaveri.git /home/ubuntu/gjhaveri
