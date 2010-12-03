#!/bin/bash

# For Verbose Troubleshoot
#set -x 

#
# Check for input
#
if [ ! -n "$1" ]
then
echo "Command Syntax:"
echo "./universal_report.sh [report type] {sar file}"
echo "[report type]: cpu, network, memory, load, io, swap"
exit
fi 

#
# Check for Valid input
#
if [ "$1" != 'cpu' -a "$1" != 'network' -a "$1" != 'memory' -a "$1" != 'load' -a "$1" != 'io' -a "$1" != 'swap' ] 
then
echo "Command Syntax:"
echo "./universal_report.sh [report type] {sar file}"
echo "[report type]: cpu, network, memory, load, io, swap"
exit
fi

#
# Set Variable
#
input=$1
echo "=========== Starting $1 ==========="

#
# Check for SAR
#
echo "CHECKING SAR:"
if [ -x "`which sar 2>/dev/null`" ]
then
echo "  OK"
sar=`which sar`
else
echo "SAR Binary not found"
exit
fi


#
# Address bug found by Oneiroi
# https://github.com/jness/sarGraphs/issues#issue/1
#
echo "CHECKING PHP:"
if [ -x "`which php 2>/dev/null`" ]
then 
echo "  OK"
php=`which php`
else
echo "PHP Binary not found"
exit
fi

#
# Get the date from the Current SAR Reports
#
date=`$sar | head -n 1 | awk '{print $4}' | awk -F/ '{print $1"/"$2"/"}'`
year=`date +'%Y'`
date=$date$year
date=`echo $date | sed 's/\//-/g'`
echo "VARIABLES:"
echo "  \$date: $date"

#
# Check for SAR Data
#
sarlines=`$sar |egrep "^[0-9]" | wc -l`
if [ $sarlines -le 2 ]
then
echo "Not enough SAR data, be sure the service is running"
exit
fi

#
# Get SAR Time format
#
if [ `$sar | egrep 'AM|PM' | wc -l` -gt '0' ]
then
sar_timeformat=12
else
sar_timeformat=24
fi
echo "  \$sar_timeformat: $sar_timeformat"

#
# Check if Swap usage is in Memory or Swap section
#
if [ "`$sar -r | grep -o '%swpused'`" == '%swpused' ]
then
swap_command='$sar -r'
else
swap_command='$sar -S'
fi



if [ "$input" == 'cpu' ]
then
report="$sar"
elif [ "$input" == 'network' ]
then
	#
	# Check if Network usage is KB or Bytes
	#
	if [ "`$sar -n DEV | grep -o 'rxbyt/s'`" == 'rxbyt/s' ]
	then
	network_size='byte'
	else
	network_size='kb'
	fi
echo "  \$network_size: $network_size"
report="$sar -n DEV"
elif [ "$input" == 'load' ]
then
report="$sar -q"
elif [ "$input" == 'memory' ]
then
report="$sar -r"
elif [ "$input" == 'io' ]
then
report="$sar"
elif [ "$input" == 'swap' ]
then
	#
	# Check if Swap usage is in Memory or Swap section
	#
	if [ "`sar -r | grep -o '%swpused'`" == '%swpused' ]
	then
	swap_command='sar -r'
	else
	swap_command='sar -S'
	fi
report="$swap_command"
fi

# 
# Print out SAR command
#
echo "SAR COMMAND:"
echo "    $report"


#
# Create the edit SAR Output which will be graphed as well as the 
# the static text file of the SAR report.
#

# 
# If CPU Report
#
if [ $input == 'cpu' ]
then
  cpu_head=$($sar | egrep '%' | head -n 1)
  count=1
      while [ $count -le 10 ]
      do
         column=$(echo $cpu_head | awk '{print $"'"$count"'"}')
           if [ "$column" == '%idle' ]
           then
               cpu_column=$count
               break
           fi
          count=$(echo $count + 1 | bc)
      done
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " " $2 " " $"'"$cpu_column"'"}' | egrep "^[0-9]" | grep -v idle > datadir/cpu
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " PLACEHOLDER " $"'"$cpu_column"'"}' | egrep "^[0-9]" | grep -v idle > datadir/cpu
  fi

#
# If Memory Report
#
elif [ $input == 'memory' ]
then
  memory_head=$($sar -r | egrep '%' | head -n 1)
  count=1
      while [ $count -le 11 ]
      do
         column=$(echo $memory_head | awk '{print $"'"$count"'"}')
           if [ "$column" == 'kbmemused' ]
           then
               kbmemused=$count
           elif [ "$column" == 'kbbuffers' ]
           then
               kbbuffers=$count
           elif [ "$column" == 'kbcached' ]
           then
               kbcached=$count
           fi
          count=$(echo $count + 1 | bc)
      done
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | egrep ^[0-9] | grep -v kbm | awk '{printf $1 " %s %.2f \n", $2, ($"'"$kbmemused"'"-$"'"$kbbuffers"'"-$"'"$kbcached"'")/1024}' > datadir/memory
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | egrep ^[0-9] | grep -v kbm | awk '{printf $1 " %s %.2f \n", "PLACEHOLDER", ($"'"$kbmemused"'"-$"'"$kbbuffers"'"-$"'"$kbcached"'")/1024}' > datadir/memory
  fi

#
# If Load Report
#
elif [ $input == 'load' ]
then
  load_head=$($sar -q | egrep 'ldavg' | head -n1)
  count=1
      while [ $count -le 11 ]
      do
         column=$(echo $load_head | awk '{print $"'"$count"'"}')
           if [ "$column" == 'ldavg-1' ]
           then
               load=$count
	       break
           fi
          count=$(echo $count + 1 | bc)
      done
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " " $2 " " $"'"$load"'"}' | egrep "^[0-9]" | grep -v ld > datadir/load
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " PLACEHOLDER " $"'"$load"'"}' | egrep "^[0-9]" | grep -v ld > datadir/load
  fi

#
# If Network Report
#
elif [ $input == 'network' ]
then
  network_head=$($sar -n DEV | egrep 'rxpck' | head -n1)
  count=1
      while [ $count -le 11 ]
      do
         column=$(echo $network_head | awk '{print $"'"$count"'"}')
           if [ "$column" == 'rxbyt/s' -o "$column" == 'rxkB/s' ]
           then
               rxbyt=$count
	   elif [ "$column" == 'txbyt/s' -o "$column" == 'txkB/s' ]
	   then
               txbyt=$count
           fi
          count=$(echo $count + 1 | bc)
      done
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | grep eth0 | awk '{ print $1 " " $2 " " $"'"$rxbyt"'" " " $"'"$txbyt"'"}' | egrep -v "Average" > datadir/network
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | grep eth0 | awk '{ print $1 " PLACEHOLDER " $"'"$rxbyt"'" " " $"'"$txbyt"'"}' | egrep -v "Average" > datadir/network
  fi

#
# If I/O Report
#
elif [ $input == 'io' ]
then
  io_head=$($sar | egrep '%' | head -n1)
  count=1
      while [ $count -le 11 ]
      do
         column=$(echo $io_head | awk '{print $"'"$count"'"}')
           if [ "$column" == '%iowait' ]
           then
               iowait=$count
	       break
           fi
          count=$(echo $count + 1 | bc)
      done
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " " $2 " " $"'"$iowait"'"}' | egrep "^[0-9]" | grep -v iowait > datadir/io
  elif [ $sar_timeformat == '24' ]
    then
     $report | egrep -v "RESTART" | awk '{print $1 " PLACEHOLDER " $"'"$iowait"'"}' | egrep "^[0-9]" | grep -v iowait > datadir/io
  fi

#
# If Swap Report
#
elif [ $input == 'swap' ]
then
  swap_head=$($swap_command | egrep '%' | head -n1)
  count=1
      while [ $count -le 11 ]
      do
         column=$(echo $swap_head | awk '{print $"'"$count"'"}')
           if [ "$column" == '%swpused' ]
           then
               swap=$count
               break
           fi
          count=$(echo $count + 1 | bc)
      done
  if [ $sar_timeformat == '12' ]
    then
     $report | egrep -v "RESTART" | awk '{ print $1 " " $2 " " $"'"$swap"'"}' | egrep "^[0-9]" | egrep -v "%swpused" > datadir/swap
  elif [ $sar_timeformat == '24' ]
    then
    $report | egrep -v "RESTART" | awk '{ print $1 " PLACEHOLDER " $"'"$swap"'"}' | egrep "^[0-9]" | egrep -v "%swpused" > datadir/swap
  fi

fi

#
# Create the SAR Text Log
#
if [ $input == 'network' ]
then
	$report | egrep "eth0|IFACE|^$|RESTART" > ../htdocs/raw/$input-$date.txt
	$report | egrep "eth0|IFACE|^$|RESTART" > ../htdocs/raw/$input-current.txt
else
	$report > ../htdocs/raw/$input-$date.txt
	$report > ../htdocs/raw/$input-current.txt
fi

#
# Use output to create graph
#
echo "STARTING GRAPH GENERATION:"
if [ $input == 'network' ]
then
$php ./$input''$network_size''_graph.php > ../htdocs/graphs/$input-current.jpg
else
$php ./$input''_graph.php > ../htdocs/graphs/$input-current.jpg
fi
cp -a ../htdocs/graphs/$input-current.jpg ../htdocs/graphs/$input-$date.jpg
echo "=========== Completed $1 ==========="
echo " "
