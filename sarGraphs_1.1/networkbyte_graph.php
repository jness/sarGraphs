<?php
// Pull in SAR data
$handle = fopen("datadir/network", "rb");
$ydata = array();

//Define some Variables
$seq=1;
$count='0';
$next='0';

        while (!feof($handle)) {
                 $line=fgets($handle);

                //Validate Variable
                if ($line != NULL) {

                // Get Recieved Network Data
                $part=explode(" ", $line);
                        if (!trim($part[2]) == '') {
                        $ydata[]=trim($part[2] / 1024);
                        }

                // Get Sent Network Data
                $part=explode(" ", $line);
                        if (!trim($part[2]) == '') {
                        $ydata2[]=trim($part[3] / 1024);
                        }

                // Get X Graph Data
                $time=explode(":", $part[0]);
                        if (!trim($time[0]) == '') {
				if ( $seq == 1 OR $count == $time[0] OR $next == $time[0] ) {
	                        	$xdata[]='';
					$count=$time[0];
					$seq++;
				}else{
	                        	$xdata[]=trim($time[0]);
					$count=$time[0];
					$next=$time[0];
					$next++;
					$seq++;
				}
                        }
                }
        }

  //Close the connection
  fclose($handle);

  // Include Global Config
  include("includes/graph_conf.php");

  // Standard inclusions
  include("$pChart_path/pData.class");
  include("$pChart_path/pChart.class");

  // Dataset definition
  $DataSet = new pData;
  $DataSet->AddPoint($ydata,"Serie1");
  $DataSet->AddPoint($ydata2,"Serie2");
  $DataSet->AddPoint($xdata,"Serie3");
  $DataSet->AddSerie("Serie1");
  $DataSet->AddSerie("Serie2");
  $DataSet->SetAbsciseLabelSerie("Serie3");
  $DataSet->SetSerieName("Incoming kb","Serie1");
  $DataSet->SetSerieName("Outgoing kb","Serie2");
  #$DataSet->SetYAxisName("MB");
  #$DataSet->SetYAxisUnit("%");
  #$DataSet->SetXAxisFormat("date");

  // Initialise the graph   
  $Test = new pChart(900,250);
  $Test->setColorPalette(0,69,252,69);
  #$Test->setColorPalette(1,126,185,245);
  $Test->setFontProperties("$font",8);
  $Test->setGraphArea(50,35,890,215);
  #$Test->drawFilledRoundedRectangle(7,7,450,223,5,240,240,240);
  #$Test->drawRoundedRectangle(5,5,450,225,5,230,230,230);
  $Test->drawGraphArea(255,255,255,FALSE);
  $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);
  $Test->drawGrid(1,TRUE,240,240,240);
  #$Test->drawGrid(4,TRUE);
  
  // Draw the 0 line   
  $Test->setFontProperties("$font",6);
  $Test->drawTreshold(0,143,55,72,TRUE,TRUE);
  
  // Draw the line graph
  $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
  $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),.1,0);
  
  // Finish the graph
  $Test->setFontProperties("$font",8);
  $Test->drawLegend(800,45,$DataSet->GetDataDescription(),255,255,255);
  $Test->setFontProperties("$font",11);
  $Test->drawTitle(325,25,"Network",150,150,150,585);
  $Test->Stroke();
?>
 
