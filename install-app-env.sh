#!/bin/bash

echo "Have you created a database instance before, that too just by typing commands?"
echo "Let us Create a RDS Database to store all our information while building our application"
aws rds create-db-instance --db-name school --db-instance-identifier clouddatabases --db-instance-class db.t2.micro --engine mysql --master-username awsdatabase --master-user-password awsdatabase --port 3306 --allocated-storage 5 --availability-zone us-west-2b
echo "Let us wait for the database to be available"
aws rds wait db-instance-available --db-instance-identifier clouddatabases
echo "Your RDS Database is now available to use"


echo "Adding a Simple Notification Service to our Application"
echo "let us create a topic first"
aws sns create-topic --name cloudassignment
echo "Lets Subscribe tothis topic in order to get started"
aws sns subscribe --topic-arn arn:aws:sns:us-west-2:599404884853:cloudassignment --protocol email --notification-endpoint itsmeasgaurav@gmail.com
echo "Let us Create a SQS Queue"
aws sqs create-queue --queue-name assignmentqueue
echo "Time to Send the message"
aws sqs send-message --queue-url https://sqs.us-west-2.amazonaws.com/599404884853/assignmentqueue	 --message-body upload
echo "Let us check if we can receive the same message or not"
aws sqs receive-message --queue-url https://sqs.us-west-2.amazonaws.com/599404884853/assignmentqueue	

echo "Let us create two buckets"
aws s3 mb s3://$1
aws s3 mb s3://$2
