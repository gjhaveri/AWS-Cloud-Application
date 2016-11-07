#!/bin/bash
echo "Let us Create a world of Cloud"
echo "lets see if loop"
if [ $# != 6 ]; then
echo "nothing"
exit 1
else
echo "Let's execute"
fi
echo "Let us first create a Load Balancer named gjhaveri"
aws elb create-load-balancer --load-balancer-name gjhaveri --listeners Protocol=Http,LoadBalancerPort=80,InstanceProtocol=Http,InstancePort=80 --subnets subnet-b36445d7
echo "Creating Launch Configuration named ubuntuserver"
aws autoscaling create-launch-configuration --launch-configuration-name $4 --image-id $1 --key-name $2 --security-groups $3 --instance-type t2.micro --user-data  file://install-app.sh --iam-instance-profile $6
echo "Finally let's create an auto-scaling-group named serverdemo"
aws autoscaling create-auto-scaling-group --auto-scaling-group-name serverdemo --launch-configuration-name ubuntuserver --load-balancer-names gjhaveri --min-size 1 --max-size 5 --desired-capacity $5 --vpc-zone-identifier subnet-b36445d7
echo "Don't forget to kill everything else jhajek will not help you to get your money!! Boom and out of here..."

