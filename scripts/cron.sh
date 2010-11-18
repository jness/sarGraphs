#!/bin/bash

##############
# Cron Job for ROOT
# 10 * * * * /PATH TO DATA/cron.sh 2>&1
##############

abspath=$(cd ${0%/*} && echo $PWD/)

cd $abspath

./universal_report.sh all 

# Clean up the old reports
find $abspath/graphs/ -type f -mtime +8 -exec rm -rf {} \;
find $abspath/raw/ -type f -mtime +8 -exec rm -rf {} \;
