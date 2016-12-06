#!/bin/bash

git clone git@github.com:illinoistech-itm/gjhaveri.git /home/ubuntu/gjhaveri
sudo rm /var/lib/dpkg/lock
sudo dpkg --configure -a

sudo apt-get update
sudo apt-get -y install git apache2 php-xml libapache2-mod-php php php-mysql curl php-curl zip unzip &
wait
export COMPOSER_HOME=/home/ubuntu

sudo curl -sS https://getcomposer.org/installer | php
wait
sudo php composer.phar require aws/aws-sdk-php
sudo systemctl enable apache2
sudo systemctl start apache2
	
sudo mv vendor /var/www/html/

#sudo rm index.html /var/www/html/

#sudo git clone git@github.com:illinoistech-itm/gjhaveri.git

sudo mv /home/ubuntu/gjhaveri/*.php	 /var/www/html/
