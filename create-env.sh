#!/bin/bash 
echo "Let us Create a world of Cloud"
echo "Let us first create a Load Balancer named gjhaveri"
aws elb create-load-balancer --load-balancer-name gjhaveri --listeners Protocol=Http,LoadBalancerPort=80,InstanceProtocol=Http,InstancePort=80 --subnets subnet-b36445d7
echo "Creating Launch Configuration named ubuntuserver"
aws autoscaling create-launch-configuration --launch-configuration-name ubuntuserver --image-id $1 --key-name test --security-groups sg-b5488acc --instance-type t2.micro --user-data  file://installenv.sh
echo "Finally let's create an auto-scaling-group named serverdemo"
aws autoscaling create-auto-scaling-group --auto-scaling-group-name serverdemo --launch-configuration-name ubuntuserver --load-balancer-names gjhaveri --min-size 1 --max-size 5 --desired-capacity 3 --vpc-zone-identifier subnet-b36445d7
echo "Don't forget to kill everything else jhajek will not help you to get your money!! Boom and out of here..."
