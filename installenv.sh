

#sudo apt-get update
#sudo apt-get -y install git 
#sudo apt-get -y install apache2
#sudo systemctl enable apache2
#sudo systemctl start apache2
#cd /home/ubuntu
#sudo git clone https://github.com/gjhaveri/boostrap-website.git
#sudo mv /home/ubuntu/boostrap-website/* /var/www/html


#!/bin/bash

git clone git@github.com:illinoistech-itm/gjhaveri.git /home/ubuntu/gjhaveri

sudo apt-get update
sudo apt-get -y install git apache2 php-xml libapache2-mod-php php php-mysql curl php-curl zip unzip
sudo curl -sS https://getcomposer.org/installer | php

sudo php composer.phar require aws/aws-sdk-php
sudo systemctl enable apache2
sudo systemctl start apache2

sudo mv vendor /var/www/html
cd /var/www/html
sudo rm index.html

sudo git clone https://github.com/illinoistech-itm/gjhaveri

sudo mv /home/ubuntu/gjhaveri/* /var/www/html
