<?php
//Définition des variables communes à tous les rapports
$rappLng = require_once( (file_exists("application/language/".Auth::user()->language."/reports.php")) ? "application/language/".Auth::user()->language."/reports.php" : "application/language/en/reports.php"); 
$compte = 0;
$colorStatus = array(
	0 => array(220,220,220),
	1 => array(255,255,255),
	2 => array(100,100,255),
	3 => array(100,255,100),
	4 => array(255,225,50),
	5 => array(255,70,70)
	);
$rendu = "";
$SautPage = false;
$untel = "";

function EnTete ($pdf, $colonnes, $untel, $rappLng) {
	global $_POST;
	$pdf->AddPage();
	$pdf->SetFillColor(hexdec(substr($_POST["Couleur"], 0, 2)), hexdec(substr($_POST["Couleur"], 2, 2)), hexdec(substr($_POST["Couleur"], 4, 2)));
	$pdf->Image("../images/logo.png", 12,20,40,18,"png", "");
	$pdf->SetFont("Times", "B", 15);
	$pdf->Text(86, 28,utf8_decode($rappLng[$_POST["RapType"]][0]));
	$pdf->SetFont("Times", "", 10);
	if (trim(@$_POST["DteInit"]) != '' ) { $pdf->Text(86, 32, " Date >= ".$_POST["DteInit"]); }
	if (trim(@$_POST["DteEnds"]) != '' ) { $pdf->Text(86, 35, " Date <= ".$_POST["DteEnds"]); }
	if (trim(@$_POST["FilterUser"]) > 0 ) {$pdf->Text(86, 38, " ... ".$untel); }

	$pdf->SetXY(10, 40);
	$pdf->SetFont("Times", "B", 12);
	foreach ($colonnes as $ind => $width) {
			$pdf->Cell($width, 15, utf8_decode($rappLng[$_POST["RapType"]][$ind+1]), 1, 0, "C", true, "");
	}
	$pdf->SetFont("Times", "", 10);
	$pdf->SetXY(10, 55);
}


//Selon le type de rapport demandé
include_once "application/models/reports/".$_POST["RapType"].".php";
////Definition de la requête, section du filtrage et du tri
if (trim(@$_POST["DteInit"]) != '' ) { $query .= $etOU." ".$ChampDTE." >= '".$_POST["DteInit"]."' "; $etOU = " AND ";}
if (trim(@$_POST["DteEnds"]) != '' ) { $query .= $etOU." ".$ChampDTE." <= '".$_POST["DteEnds"]."' "; $etOU = " AND ";}
if (trim(@$_POST["FilterUser"]) > 0 ) { 
	$query .= $etOU." ".$ChampUSR." = '".$_POST["FilterUser"]."' "; 
	$etOU = " AND ";
	$Untel = \DB::table('users')->where('id', '=', $_POST["FilterUser"])->get();
	$untel = strtoupper($Untel[0]->lastname).', '.$Untel[0]->firstname; 
}
$query .= "ORDER BY ".$OrdreTRI;
//echo $query;
//exit();
$results = \DB::query($query);


//Production du rapport lui-même
EnTete ($pdf, $colonnes, $untel,$rappLng);

foreach($results as $result) {
	if ($SautPage && $rendu != $result->zero && $rendu != '') { EnTete ($pdf, $colonnes, $untel,$rappLng); $compte = 0;}
	$rendu = $result->zero;
	$pdf->SetFillColor($colorStatus[$result->status][0],$colorStatus[$result->status][1],$colorStatus[$result->status][2]);
	$pdf->Cell($colonnes[0],10, 	utf8_decode($result->zero), 	1, 0, (($colonnes[0]  > 23) ? "L" : "C"), true, "");
	$pdf->Cell($colonnes[1],10, 	utf8_decode($result->prem), 	1, 0, (($colonnes[1]  > 23) ? "L" : "C"), true, "");
	$pdf->Cell($colonnes[2],10, 	utf8_decode($result->deux),	1, 0, (($colonnes[2]  > 23) ? "L" : "C"), true, "");
	$pdf->Cell($colonnes[3],10,	utf8_decode($result->troi),	1, 0, (($colonnes[3]  > 23) ? "L" : "C"), true, "");
	$pdf->Cell($colonnes[4],10,	utf8_decode($result->quat),	1, 0, (($colonnes[4]  > 23) ? "L" : "C"), true, "");
	$pdf->Cell($colonnes[5],10,	utf8_decode($result->cinq), 	1, 1, (($colonnes[5]  > 23) ? "L" : "C"), true, "");
	if ($result->status == 0 && isset($PosiX['inactif0'])) { $pdf->Text($PosiX['inactif0'], ($pdf->GetY())-1,  $result->inactif0); }
	if ($result->status == 0 && isset($PosiX['inactif1'])) { $pdf->Text($PosiX['inactif1'], ($pdf->GetY())-1,  $result->inactif1); }
	if ($result->status == 0 && isset($PosiX['inactif2'])) { $pdf->Text($PosiX['inactif2'], ($pdf->GetY())-1,  $result->inactif2); }
	if ($result->status == 0 && isset($PosiX['inactif3'])) { $pdf->Text($PosiX['inactif3'], ($pdf->GetY())-1,  $result->inactif3); }
	if (isset($PosiX['special0']) && isset($result->special0)) { $pdf->Text($PosiX['special0'], ($pdf->GetY())-1,  $result->special0); }
	if (isset($PosiX['special1']) && isset($result->special1)) { $pdf->Text($PosiX['special1'], ($pdf->GetY())-1,  $result->special1); }
	if (isset($PosiX['special2']) && isset($result->special2)) { $pdf->Text($PosiX['special2'], ($pdf->GetY())-1,  $result->special2); }
	if (isset($PosiX['special3']) && isset($result->special3)) { $pdf->Text($PosiX['special3'], ($pdf->GetY())-1,  $result->special3); }
	//$pdf->Text(150, ($pdf->GetY())-1, (($result->status == 1) ? '' : substr($result->updated_at,	0, 10)));
	if (++$compte >= 20) { EnTete ($pdf, $colonnes, $untel,$rappLng); $compte = 0;}
}
