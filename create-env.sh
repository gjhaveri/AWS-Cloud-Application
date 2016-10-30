#!/bin/bash 
echo "Let us Create a world of Cloud"
echo "Wait! I will not execute until the paramters are checked, this is how I am programmed"
if [ $# != 5 ]; then
echo "Counting, please wait"
echo "Testing patience?, this is how it works in this world"
echo "Sorry, parameters are either more or less than the threshold"
exit 1
else
echo "Parameters accepted"
echo "Let's execute the script"
fi
echo "Let us first create a Load Balancer named gjhaveri"
aws elb create-load-balancer --load-balancer-name gjhaveri --listeners Protocol=Http,LoadBalancerPort=80,InstanceProtocol=Http,InstancePort=80 --subnets subnet-b36445d7
echo "Creating Launch Configuration named ubuntuserver"
aws autoscaling create-launch-configuration --launch-configuration-name $4 --image-id $1 --key-name $2 --security-groups $3 --instance-type t2.micro --user-data  file://installenv.sh
echo "Finally let's create an auto-scaling-group named serverdemo"
aws autoscaling create-auto-scaling-group --auto-scaling-group-name serverdemo --launch-configuration-name ubuntuserver --load-balancer-names gjhaveri --min-size 1 --max-size 5 --desired-capacity $5 --vpc-zone-identifier subnet-b36445d7
echo "Don't forget to kill everything else jhajek will not help you to get your money!! Boom and out of here..."
#echo "Adding a Simple Notification Service to our Application"
#echo "let us create a topic first"
#aws sns create-topic --name cloudassignment
#echo "Lets Subscribe tothis topic in order to get started"
# aws sns subscribe --topic-arn $6 --protocol email --notification-endpoint itsmeasgaurav@gmail.com
#echo "Let us Create a SQS Queue"
#aws sqs create-queue --queue-name assignmentqueue
#echo "Time to Send the message"
# aws sqs send-message --queue-url https://sqs.us-west-2.amazonaws.com/599404884853/assignmentqueue --message-body "I love travelling"
#echo "Let us check if we can receive the same message or not"
# aws sqs receive-message --queue-url https://sqs.us-west-2.amazonaws.com/599404884853/assignmentqueue
