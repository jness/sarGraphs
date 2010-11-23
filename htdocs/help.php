<?php

if (!$_GET) {
header("Location: index.php");
}

include('includes/head.php');
include('includes/slim_banner.php');
?>

<table with='950' align='center'>
<tr><td>

<?php
 if ($_GET['type'] == 'cpu') {
?>

<b>Example SAR Graph</b>
<pre>
In the graph below the Y-Axis will represent the reverse of %idle or CPU usage, while the X-Axis will display
the hour this data was taken at.
</pre>
<center>
<img src='images/cpu-example.jpg'></img>
</center>
<br>
<br>

<b>Example SAR output</b>
<pre>
09:10:01          CPU     %user     %nice   %system   %iowait    %steal     %idle
09:20:01          all      0.10      0.00      0.08      0.06      0.08     99.69
09:30:02          all      0.01      0.00      0.04      0.02      0.06     99.87
09:40:01          all      0.02      0.00      0.04      0.03      0.03     99.87
09:50:01          all      0.01      0.00      0.04      0.08      0.07     99.80
10:00:02          all      0.03      0.00      0.05      0.04      0.06     99.83
10:10:01          all      0.02      0.00      0.04      0.02      0.03     99.88
10:20:01          all      0.17      0.00      0.11      0.20      0.10     99.42
Average:          all      0.04      0.00      0.05      0.08      0.06     99.77
</pre>
<br>
<b>What does the above show?</b>
<pre>
%user
       Percentage of CPU utilization that occurred while executing at the user level (application). Note that this field includes
       time spent running virtual processors.

%nice
       Percentage of CPU utilization that occurred while executing at the user level with nice priority.

%system
       Percentage of CPU utilization that occurred while executing at the system level (kernel). Note that  this  field  includes
       time spent servicing hardware and software interrupts.

%iowait
       Percentage of time that the CPU or CPUs were idle during which the system had an outstanding disk I/O request.

%steal
       Percentage of time spent in involuntary wait by the virtual CPU or CPUs while the hypervisor was servicing another virtual
       processor.

%idle
       Percentage of time that the CPU or CPUs were idle and the system did not have an outstanding disk I/O request.

</pre>

<?php
}else if ($_GET['type'] == 'io') {
?>

<b>Example SAR Graph</b>
<pre>
In the graph below the Y-Axis will represent the %iowait, while the X-Axis will display the hour this data was taken at.
</pre>
<center>
<img src='images/io-example.jpg'></img>
</center>
<br>
<br>

<b>Example SAR output</b>
<pre>
09:10:01          CPU     %user     %nice   %system   %iowait    %steal     %idle
09:20:01          all      0.10      0.00      0.08      0.06      0.08     99.69
09:30:02          all      0.01      0.00      0.04      0.02      0.06     99.87
09:40:01          all      0.02      0.00      0.04      0.03      0.03     99.87
09:50:01          all      0.01      0.00      0.04      0.08      0.07     99.80
10:00:02          all      0.03      0.00      0.05      0.04      0.06     99.83
10:10:01          all      0.02      0.00      0.04      0.02      0.03     99.88
10:20:01          all      0.17      0.00      0.11      0.20      0.10     99.42
Average:          all      0.04      0.00      0.05      0.08      0.06     99.77
</pre>
<br>
<b>What does the above show?</b>
<pre>
%user
       Percentage of CPU utilization that occurred while executing at the user level (application). Note that this field includes
       time spent running virtual processors.

%nice
       Percentage of CPU utilization that occurred while executing at the user level with nice priority.

%system
       Percentage of CPU utilization that occurred while executing at the system level (kernel). Note that  this  field  includes
       time spent servicing hardware and software interrupts.

%iowait
       Percentage of time that the CPU or CPUs were idle during which the system had an outstanding disk I/O request.

%steal
       Percentage of time spent in involuntary wait by the virtual CPU or CPUs while the hypervisor was servicing another virtual
       processor.

%idle
       Percentage of time that the CPU or CPUs were idle and the system did not have an outstanding disk I/O request.

</pre>


<?php
}else if ($_GET['type'] == 'memory') {
?>

<b>Example SAR Graph</b>
<pre>
In the graph below the Y-Axis will represent the total memory usage:

         kbmemused - kbbuffers - kbcached = "total memory used"

The X-Axis will display the hour this data was taken at.
</pre>
<center>
<img src='images/memory-example.jpg'></img>
</center>
<br>
<br>

<b>Example SAR output</b>
<pre>
09:10:01    kbmemfree kbmemused  %memused kbbuffers  kbcached kbswpfree kbswpused  %swpused  kbswpcad
09:20:01        17512    311524     94.68     26396     86056    965988     82572      7.87     12740
09:30:02        16944    312092     94.85     26676     86160    965988     82572      7.87     12800
09:40:01        16528    312508     94.98     27028     86220    966016     82544      7.87     12784
09:50:01        11664    317372     96.46     27832     86980    966016     82544      7.87     12784
10:00:02        12792    316244     96.11     28168     88116    966020     82540      7.87     12780
10:10:01        13376    315660     95.93     28460     88160    966020     82540      7.87     12780
10:20:01        39792    289244     87.91     26960     82856    965808     82752      7.89     12704
10:30:01        16880    312156     94.87     28572     90932    965836     82724      7.89     12696
10:40:01        41976    287060     87.24     23656     85372    965548     83012      7.92     12812
Average:        18722    310314     94.31     23293     89641    967156     81404      7.76     11833
</pre>
<br>
<b>What does the above show?</b>
<pre>
kbmemfree
          Amount of free memory available in kilobytes.

kbmemused
          Amount of used memory in kilobytes. This does not take into account memory used by the kernel itself.

%memused
          Percentage of used memory.

kbbuffers
          Amount of memory used as buffers by the kernel in kilobytes.

kbcached
          Amount of memory used to cache data by the kernel in kilobytes.

kbswpfree
          Amount of free swap space in kilobytes.

kbswpused
          Amount of used swap space in kilobytes.

%swpused
          Percentage of used swap space.

kbswpcad
          Amount of cached swap memory in kilobytes.  This is memory that once was swapped out, is swapped back 
          in but still also is in the swap area (if memory is needed it doesn't need to be swapped out again 
          because it is already in the swap area. This saves I/O).

</pre>

<?php
}else if ($_GET['type'] == 'swap') {
?>

<b>Example SAR Graph</b>
<pre>
In the graph below the Y-Axis will represent the %swpused, while the X-Axis will display the hour this data was taken at.
</pre>
<center>
<img src='images/swap-example.jpg'></img>
</center>
<br>
<br>

<b>Example SAR output</b>
<pre>
09:10:01    kbmemfree kbmemused  %memused kbbuffers  kbcached kbswpfree kbswpused  %swpused  kbswpcad
09:20:01        17512    311524     94.68     26396     86056    965988     82572      7.87     12740
09:30:02        16944    312092     94.85     26676     86160    965988     82572      7.87     12800
09:40:01        16528    312508     94.98     27028     86220    966016     82544      7.87     12784
09:50:01        11664    317372     96.46     27832     86980    966016     82544      7.87     12784
10:00:02        12792    316244     96.11     28168     88116    966020     82540      7.87     12780
10:10:01        13376    315660     95.93     28460     88160    966020     82540      7.87     12780
10:20:01        39792    289244     87.91     26960     82856    965808     82752      7.89     12704
10:30:01        16880    312156     94.87     28572     90932    965836     82724      7.89     12696
10:40:01        41976    287060     87.24     23656     85372    965548     83012      7.92     12812
Average:        18722    310314     94.31     23293     89641    967156     81404      7.76     11833
</pre>
<br>
<b>What does the above show?</b>
<pre>
kbmemfree
          Amount of free memory available in kilobytes.

kbmemused
          Amount of used memory in kilobytes. This does not take into account memory used by the kernel itself.

%memused
          Percentage of used memory.

kbbuffers
          Amount of memory used as buffers by the kernel in kilobytes.

kbcached
          Amount of memory used to cache data by the kernel in kilobytes.

kbswpfree
          Amount of free swap space in kilobytes.

kbswpused
          Amount of used swap space in kilobytes.

%swpused
          Percentage of used swap space.

kbswpcad
          Amount of cached swap memory in kilobytes.  This is memory that once was swapped out, is swapped back 
          in but still also is in the swap area (if memory is needed it doesn't need to be swapped out again 
          because it is already in the swap area. This saves I/O).

</pre>


<?php
}else if ($_GET['type'] == 'load') {
?>

<b>Example SAR Graph</b>
<pre>
In the graph below the Y-Axis will represent the 'ldavg-1' , while the X-Axis will display
the hour this data was taken at.
</pre>
<center>
<img src='images/load-example.jpg'></img>
</center>
<br>
<br>

<b>Example SAR output</b>
<pre>
09:10:01      runq-sz  plist-sz   ldavg-1   ldavg-5  ldavg-15
09:20:01            2       183      0.00      0.00      0.00
09:30:02            2       183      0.00      0.00      0.00
09:40:01            2       183      0.00      0.00      0.00
09:50:01            1       186      0.00      0.00      0.00
10:00:02            4       186      0.00      0.00      0.00
10:10:01            4       183      0.00      0.00      0.00
10:20:01            1       184      0.00      0.00      0.00
10:30:01            1       184      0.00      0.00      0.00
10:40:01            1       184      0.00      0.00      0.00
10:50:01            5       189      0.02      0.01      0.00
Average:            3       184      0.00      0.00      0.00

</pre>
<br>
<b>What does the above show?</b>
<pre>
runq-sz
        Run queue length (number of processes waiting for run time).

plist-sz
        Number of processes and threads in the process list.

ldavg-1
        System load average for the last minute.

ldavg-5
        System load average for the past 5 minutes.

ldavg-15
        System load average for the past 15 minutes.


</pre>

<?php
}else if ($_GET['type'] == 'network') {
?>

<b>Example SAR Graph</b>
<pre>
In the graph below the Y-Axis will represent the Kilobytes for Incoming and Outgoing data on the IFACE.
The X-Axis will display the hour this data was taken at.
</pre>
<center>
<img src='images/network-example.jpg'></img>
</center>
<br>
<br>

<b>Example SAR output</b>
<pre>
10:30:01        IFACE   rxpck/s   txpck/s   rxbyt/s   txbyt/s   rxcmp/s   txcmp/s  rxmcst/s
10:00:02         eth0      1.53      0.93    145.45    537.67      0.00      0.00      0.00
10:10:01         eth0      0.77      0.51     74.06    639.07      0.00      0.00      0.00
10:20:01         eth0      3.33      2.18    351.02   1331.85      0.00      0.00      0.00
10:30:01         eth0     11.15      4.68   9469.71   1188.51      0.00      0.00      0.00
10:40:01         eth0      5.52      3.53    559.19   1522.90      0.00      0.00      0.00
10:50:01         eth0      4.21      2.80    432.27    883.11      0.00      0.00      0.00
Average:         eth0      0.92      0.59    220.43    425.43      0.00      0.00      0.00
</pre>
<br>
<b>What does the above show?</b>
<pre>
IFACE
        Name of the network interface for which statistics are reported.

rxpck/s
        Total number of packets received per second.

txpck/s
        Total number of packets transmitted per second.

rxbyt/s
        Total number of bytes received per second.

txbyt/s
        Total number of bytes transmitted per second.

rxcmp/s
        Number of compressed packets received per second (for cslip etc.).

txcmp/s
        Number of compressed packets transmitted per second.

rxmcst/s
        Number of multicast packets received per second.

</pre>



<?php
}else{
header("Location: index.php");
}
?>

</td></tr>
</table>
<?php
include('includes/footer.php');
?>
