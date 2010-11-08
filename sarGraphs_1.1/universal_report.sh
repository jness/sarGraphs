#!/bin/bash

# Trouble Shoot
#set -x 

#
# Check for input
#
if [ -n "$1" ]
then
echo "thinking...."
else
echo "Command Syntax:"
echo "./universal_report.sh [report type] {sar file}"
echo "[report type]: cpu, network, memory, load, io, swap, all"
exit
fi

#
# Set Variables
#
input=$1

if [ -n "$2" ]
then
input2="-f $2"
else
input2=""
fi


if [ `sar | egrep 'AM|PM' | wc -l` -gt '0' ]
then
sar_timeformat=12
else
sar_timeformat=24
fi

if [ $input == 'cpu' ]
then
report="sar $input2"
elif [ $input == 'network' ]
then
report="sar -n DEV $input2"
elif [ $input == 'load' ]
then
report="sar -q $input2"
elif [ $input == 'memory' ]
then
report="sar -r $input2"
elif [ $input == 'io' ]
then
report="sar $input2"
elif [ $input == 'swap' ]
then
report="sar -r $input2"
elif [ $input == 'all' ]
then
$0 cpu
$0 network
$0 load
$0 memory
$0 io
$0 swap
fi
#
# Get the date from the Current SAR Reports
#
date=`sar $input2 | head -n 1 | awk '{print $4}' | awk -F/ '{print $1"/"$2"/"}'`
year=`date +'%Y'`
date=$date$year
date=`echo $date | sed 's/\//-/g'`

#
# Create the edit SAR Output which will be graphed as well as the 
# the static text file of the SAR report.
#


if [ $input == 'cpu' ]
then
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " " $2 " " $9 " " $7}' | egrep "^[0-9]" | grep -v idle > datadir/cpu
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " PLACEHOLDER " $8 " " $6}' | egrep "^[0-9]" | grep -v idle > datadir/cpu
  fi

elif [ $input == 'memory' ]
then
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | egrep ^[0-9] | grep -v kbm | awk '{printf $1 " %s %.2f \n", $2, ($4-$5)/1024}' > datadir/memory
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | egrep ^[0-9] | grep -v kbm | awk '{printf $1 " %s %.2f \n", "PLACEHOLDER", ($3-$4)/1024}' > datadir/memory
  fi

elif [ $input == 'load' ]
then
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " " $2 " " $5 " " $6 " " $7}' | egrep "^[0-9]" | grep -v ld > datadir/load
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " PLACEHOLDER " $4 " " $5 " " $6}' | egrep "^[0-9]" | grep -v ld > datadir/load
  fi

elif [ $input == 'network' ]
then
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | grep eth0 | awk '{ print $1 " " $2 " " $6 " " $7}' | egrep -v "Average" > datadir/network
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | grep eth0 | awk '{ print $1 " PLACEHOLDER " $5 " " $6}' | egrep -v "Average" > datadir/network
  fi

elif [ $input == 'io' ]
then
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " " $2 " " $9 " " $7}' | egrep "^[0-9]" | grep -v idle > datadir/io
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " PLACEHOLDER " $8 " " $6}' | egrep "^[0-9]" | grep -v idle > datadir/io
  fi

elif [ $input == 'swap' ]
then
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | awk '{ print $1 " " $2 " " $5 " " $10}' | egrep "^[0-9]" | egrep -v "idle|mem" > datadir/swap
  elif [ $sar_timeformat == '24' ]
    then
    $report | egrep -v "RESTART" | awk '{ print $1 " PLACEHOLDER " $4 " " $9}' | egrep "^[0-9]" | egrep -v "idle|mem" > datadir/swap
  fi

else
echo "Invalid Report Type!"
echo "Valid Report Types: cpu, memory, load, network, io, swap, all"
exit
fi

#
# Create the SAR Text Log
#
if [ $input == 'network' ]
then
	$report | egrep "eth0|IFACE" > ./raw/$input-$date.txt
	$report | egrep "eth0|IFACE" > ./raw/$input-current.txt
else
	$report > ./raw/$input-$date.txt
	$report > ./raw/$input-current.txt
fi
#
# Change the SAR output from AM/PM 12hour time to 24hour Time format
#
if [ $sar_timeformat == '12' ]
then
grep AM data | sed 's/^12:/00:/g' > tmp.data
grep PM data | sed 's/^01:/13:/g' | sed 's/^02:/14:/g' |sed 's/^03:/15:/g' |sed 's/^04:/16:/g' |sed 's/^05:/17:/g' |sed 's/^06:/18:/g' |sed 's/^07:/19:/g' |sed 's/^08:/20:/g' |sed 's/^09:/21:/g' |sed 's/^10:/22:/g' |sed 's/^11:/23:/g'  >> tmp.data
rm -rf data
mv tmp.data data
fi

#
# Use output to create graph
#
php ./$input''_graph.php > ./graphs/$input-current.jpg
cp -a ./graphs/$input-current.jpg ./graphs/$input-$date.jpg
echo "complete......"
