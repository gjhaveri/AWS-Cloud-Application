Steps to make it work:

Usage of Only 3 scripts in the entire process: 
a.	install-app-env.sh 
b.	install-env.sh
c.	install-app.sh

a. Install-app-env.sh
1. Run the install-app-env.sh script by providing the positional parameters raw-gjh finished-gjh
2. This will create your RDS Database, SNS Service, SQS Service as well as Create S3 Buckets.

b. install-env.sh
1. Run the install-env.sh script by passing 6 positional parameters.
2. The parameters are:
AMI-ID: ami-8b77d1eb 
Key Pair: test
Security Group: sg-b5488acc 
Launch Configuration name: ubuntuserver 
Count: (As per your requirement) 
IAM-Profile: developer
This will create an entire environment which would be needed to run the application.
3. Wait for the instances to be initialized with status check 2/2
4. There will be one additional instance created in addition to the count specified by you which will not be running within the load balancer or on the server.  
5. SSH into the instance
6. Default directory is /home/ubuntu. On ls, it will display the cloned directory.
7. Composer.phar and other composer files are stored in /root folder 
8. all the php files will be stored in /var/www/html

c.	Install-app.sh
This script will execute in the background and will install all the background files to execute php and aws sdk commands as well as run the cron job.

PHP FILES:
1.	Index.php
2.	Welcome.php
3.	gallery.php
4.	upload.php
5.	uploader.php
6.	edit.php
7.	logout.php







1.	index.php:
This page is used to allow the user to get into the application:
Three users can get into this website:

a.	Username: gjhaveri@hawk.iit.edu
Pwd: gaurav

b.	UserName: controller@iit.edu
Pwd: ilovebunnies

c.	Username: hajek@iit.edu
Pwd: iit

2.	Welcome.php
This page allows you to authenticate successfully and provides features and links to do different functionalities.
3.	Gallery.php
This page displays all the pictures that are uploaded with display of before and after.

4.	Upload.php
This page consists of a button to upload the picture and provide entries into the database.

5.	Uploader.php
This page processes the information of the picture uploaded by the user like the size of the files and transfers it to the appropriate bucket. 
It consists of 2 buttons:
a.	Go back – This button takes you back to upload the picture. 
b.	Process- This will execute the cron job in the background and the image will be watermarked and displayed in the gallery.
