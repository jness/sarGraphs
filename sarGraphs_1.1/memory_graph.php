<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once( "jpgraph/src/jpgraph_date.php" );

// Pull in SAR data
$handle = fopen("datadir/memory", "rb");
$ydata = array();
	while (!feof($handle)) {
		 $line=fgets($handle);

                //Validate Variable
                if ($line != NULL) {

		// Get Y Graph Data
		$part=explode(" ", $line);
			if (!trim($part[2]) == '') {
			$ydata[]=trim($part[2]);
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
$width=450;
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
$graph->title->Set('Memory');
$graph->subtitle->Set('(Memory Usage in MB)');

// Create the linear plot
$lineplot=new LinePlot($ydata,$xdata);
 
// Add the plot to the graph
$graph->Add($lineplot);

$lineplot -> SetColor ( 'green' );
 
// Display the graph
$graph->Stroke();
?>
