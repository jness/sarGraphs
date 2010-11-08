<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once( "jpgraph/src/jpgraph_date.php" );

// Pull in SAR data
$handle = fopen("datadir/network", "rb");
$ydata = array();
	while (!feof($handle)) {
		 $line=fgets($handle);

                //Validate Variable
                if ($line != NULL) {

		// Get Incoming Network Data
		$part=explode(" ", $line);
			if (!trim($part[2]) == '') {
			$ydata[]=trim($part[2]);
		 	}

                // Get Sent Network Data
                $part=explode(" ", $line);
                        if (!trim($part[2]) == '') {
                        $ydata2[]=trim($part[3]);
                        }


		// Get X Graph Data
		$time=explode(":", $part[0]);
		$time = mktime($time[0],$time[1],$time[2]);
			if (!trim($time) == '') {
	 		$xdata[]=trim($time);
			 }
		}
	}

//Close the connection
fclose($handle);

// Size of the overall graph
$width=900;
$height=250;
 
// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph($width,$height);
$graph->SetScale('datlin');


// Set X Graph Time format and Skip rate
$graph->xaxis->SetTextLabelInterval(2);
$graph->xaxis->scale->SetDateFormat('H');

// Setup margin and titles
$graph->SetMargin(40,20,20,40);
$graph->title->Set('Network');
$graph->subtitle->Set('(Network Usage in Bytes)');

// Incoming Data
$lineplot=new LinePlot($ydata,$xdata);
$lineplot->SetFillColor('#61a9f3');

// Sent Data
$lineplot2=new LinePlot($ydata2,$xdata);

// Legent
$lineplot->SetLegend('Incoming Traffic');
$lineplot2->SetLegend('Sent Traffic');

// Add the plot to the graph
$graph->Add($lineplot);
$graph->Add($lineplot2);
 
// Display the graph
$graph->Stroke();
?>
