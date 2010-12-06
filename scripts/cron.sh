#!/bin/bash

##############
# Cron Job for ROOT
# 10 * * * * /PATH TO DATA/cron.sh 2>&1
##############

abspath=$(cd ${0%/*} && echo $PWD/)
cd $abspath

# Logging 
date=$(date '+%m%d%Y%H%M')
log="./logs/$date"

# Loop through graphs
for type in cpu memory swap io load network
   do
	./universal_report.sh $type 2>&1 | tee -a $log
   done

# Clean up the old reports
find $abspath/logs/ -type f -mtime +8 -exec rm -rf {} \;
find $abspath/graphs/ -type f -mtime +8 -exec rm -rf {} \;
find $abspath/raw/ -type f -mtime +8 -exec rm -rf {} \;
