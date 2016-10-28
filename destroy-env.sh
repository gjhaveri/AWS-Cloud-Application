#!/bin/bash
echo "Welcome to world of destruction"
echo "Wanna see the power of destruction? Check this out!!"
echo "Autoscaling group being updated"
aws autoscaling update-auto-scaling-group --auto-scaling-group-name serverdemo  --min-size 0 --max-size 0 	
echo "Killing all instances- Kindly be patient and wait"
aws ec2 wait instance-terminated
echo "Load Balancer being Detached"
aws autoscaling detach-load-balancers --auto-scaling-group-name serverdemo --load-balancer-names gjhaveri
echo "AutoScaling Group Deleted. let's party"
aws autoscaling delete-auto-scaling-group --auto-scaling-group-name serverdemo --force-delete
echo "Launch Configuration deleted"
aws autoscaling delete-launch-configuration --launch-configuration-name ubuntuserver
echo "Load Balancer deleted"
aws elb delete-load-balancer --load-balancer-name gjhaveri
echo "You saved $ xxx for destroying everything! Thank you for using AWS service"