# Create-AWS-Environment

Steps to make it work:

Usage of Only 3 scripts in the entire process: 
install-app-env.sh 
install-env.sh
install-app.sh

1. Run the install-app-env.sh script by providing the positional parameters raw-gjh finished-gjh
2. This will create your RDS Database, SNS Service, SQS Service, Make Buckets.
3. Run the install-env.sh script by passing 6 positionsal parameters.
4. parameters are AMI-ID: ami-8b77d1eb 
Key Pair:test 
Security Group: sg-b5488acc 
Launch Configuration name: ubuntuserver 
Count: 3 
IAM-Profile: developer

5. Wait for the instance to be initialized with status check 2/2
6. SSH into the instance
7. Default directory is /home/ubuntu. On ls, it will display the cloned directory.
8. Composer.phar and other composer files are stored in /root folder 
9. all the php files will be stored in /var/www/html
10. Copy the url of the instance, a web page will be displayed with 2 buttons.
11. On clicking Load Image will load the image by pulling from the bucket.
12.On Clicking Records will display the records of the table by fetching it from the database.
13. Destroy.sh will destroy the applicational processes.

