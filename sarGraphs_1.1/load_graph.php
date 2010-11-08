<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once( "jpgraph/src/jpgraph_date.php" );

// Pull in SAR data
$handle = fopen("datadir/load", "rb");
$ydata = array();
	while (!feof($handle)) {
		 $line=fgets($handle);

                //Validate Variable
                if ($line != NULL) {

		// 1M Average
		$part=explode(" ", $line);
			if (!trim($part[2]) == '') {
			$ydata[]=trim($part[2]);
		 	}
/*
                // 5M Average
                $part=explode(" ", $line);
                        if (!trim($part[2]) == '') {
                        $ydata2[]=trim($part[3]);
                        }

                // 15M Average
                $part=explode(" ", $line);
                        if (!trim($part[2]) == '') {
                        $ydata3[]=trim($part[4]);
                        }

*/
		// Get X Graph Data
		$time=explode(":", $part[0]);
                // Check for AM/PM
                if ($part[1] == 'AM' OR $part[1] == 'PM') {
                        $clock='12';
                        $time = date("H:i:s", STRTOTIME("$time[0]:$time[1]:$time[2] $part[1]"));
                        $time = explode(":", $time);
                        $time = mktime($time[0],$time[1],$time[2]);
                }else{
			$time = mktime($time[0],$time[1],$time[2]);
		}
			if (!trim($time) == '') {
	 		$xdata[]=trim($time);
			 }
		}
	}

//Close the connection
fclose($handle);

// Size of the overall graph
$width=300;
$height=225;
 
// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph($width,$height);
$graph->SetScale('datlin');


// Set X Graph Time format and Skip rate
$graph->xaxis->SetTextLabelInterval(2);
$graph->xaxis->scale->SetDateFormat('H');

// Setup margin and titles
$graph->SetMargin(40,20,20,40);
$graph->title->Set('Load');
$graph->subtitle->Set('(1 Minute Load Average )');

// 1M Data
$lineplot=new LinePlot($ydata,$xdata);

// 5M Data
#$lineplot2=new LinePlot($ydata2,$xdata);

// 15M Data
#$lineplot3=new LinePlot($ydata3,$xdata);

// Legent
#$lineplot->SetLegend('1 Minute Average');
#$lineplot2->SetLegend('5 Minute Average');
#$lineplot3->SetLegend('15 Minute Average');

// Add the plot to the graph
$graph->Add($lineplot);
#$graph->Add($lineplot2);
#$graph->Add($lineplot3);

$lineplot -> SetColor ( 'orange' );
#$lineplot2 -> SetColor ( 'blue' );
#$lineplot3 -> SetColor ( 'green' );
 
// Display the graph
$graph->Stroke();
?>
