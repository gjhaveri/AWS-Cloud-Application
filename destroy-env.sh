#!/bin/bash
echo "Welcome to world of destruction"
echo "Wanna see the power of destruction? Check this out!!"
echo "Autoscaling group being updated"
aws autoscaling update-auto-scaling-group --auto-scaling-group-name $1  --min-size 0 --max-size 0
echo "Killing all instances- Kindly be patient and wait"
aws ec2 wait instance-terminated
echo "Load Balancer being Detached"
aws autoscaling detach-load-balancers --auto-scaling-group-name $1 --load-balancer-names $2
echo "AutoScaling Group Deleted. let's party"
aws autoscaling delete-auto-scaling-group --auto-scaling-group-name $1 --force-delete
echo "Launch Configuration deleted"
aws autoscaling delete-launch-configuration --launch-configuration-name $3
echo "Load Balancer deleted"
aws elb delete-load-balancer --load-balancer-name $2
echo "Deleting Database"
aws rds delete-db-instance --skip-final-snapshot --db-instance-identifier $4
echo "deleting sns topic"
aws sns delete-topic --topic-arn $5
echo "deleting sqs queue"
aws sqs delete-queue --queue-url $6
echo "deleting s3 bucket 1"
aws s3 rb s3://$7
echo "deleting s3 bucket 2"
aws s3 rb s3://$8
echo "You saved $ xxx for destroying everything! Thank you for using AWS service"
