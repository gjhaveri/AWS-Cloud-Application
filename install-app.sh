#!/bin/bash

git clone git@github.com:illinoistech-itm/gjhaveri.git /home/ubuntu/gjhaveri

sudo apt-get update

sudo rm /var/lib/dpkg/lock
sudo dpkg --configure -a

sudo apt-get -y install git apache2 php-xml libapache2-mod-php php php-mysql php-gd curl php-curl zip unzip &
wait
export COMPOSER_HOME=/home/ubuntu/

sudo curl -sS https://getcomposer.org/installer | php
sudo rm /var/lib/dpkg/lock
sudo dpkg --configure -a
wait

sudo php composer.phar require aws/aws-sdk-php
sudo systemctl enable apache2
sudo systemctl start apache2

sudo rm -r /var/www/html/*
sudo mv vendor /var/www/html/



#sudo git clone https://github.com/illinoistech-itm/gjhaveri.git

sudo mv /home/ubuntu/gjhaveri/Application/*.php  /var/www/html/
#git@github.com:illinoistech-itm/gjhaveri.git /home/ubuntu/gjhaveri
