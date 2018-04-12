<?
print "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
</head>
<body>

<form action='' method='post'>
Name:<input type='text' name='name' value='Moppi Arbeit'><br>
Beschreibung:<input type='text' name='beschreibung' value='Moppi muss Arbeit'><br>
Ort:<input type='text' name='ort' value='Eschborn,Düsseldorferstr.19'><br>
Geo:<input type='text' name='geo' value='50.131279;8.5684298'><br>

Schichtdauer<input type='text' name='stunden' value='8'>:<input type='text' name='minuten' value='38'><br>
<input type='text' name='1schicht' value='F'> <input type='text' name='1zeit' value='05:30'><br> 
<input type='text' name='2schicht' value='Fs'> <input type='text' name='2zeit' value='07:30'><br>
<input type='text' name='3schicht' value='Ss'> <input type='text' name='3zeit' value='11:00'><br> 
<input type='text' name='4schicht' value='S'> <input type='text' name='4zeit' value='13:30'><br>
<input type='text' name='5schicht' value='N'> <input type='text' name='5zeit' value='21:30'><br> 

<textarea name='daten'>".$_POST['daten']."</textarea><br>



<input type='submit' name='absenden' Value='absenden'>
<input type='hidden' name='check' value='1'>
</form>

";



if ($_POST['check'] == 1 ){
	
	$dauer = ($_POST['stunden']*60*60)+($_POST['minuten']*60);

$ausgabe = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:Moppi-generator
METHOD:PUBLISH
";	

	$truemmer = explode("\r",$_POST['daten']);
	
	while(list($name,$zeile) = each($truemmer)){
		
			$werte = explode("\t",$zeile);
			
			$forwert = 0;
	
		for ($count = 1; $count <= 5; $count++) {
    	
    		if ($_POST[$count.'schicht'] == $werte[1]){
    			
    			$start = $_POST[$count.'zeit'];
    			
    			$forwert = 1;
    		}
    	
    	}
		
		if ($forwert == 1){
			$datum = explode(".",$werte[0]);
 			print "".$uhr[0].",".$uhr[1].",0,".$datum[1].",".$datum[0].",'20'.".$datum[2]." :zeile: ".$name." :zeile:<br>\n";
 			$uhr = explode(":",$start);
 		
 			$startstamp = mktime ($uhr[0],$uhr[1],0,$datum[1],$datum[0],'20'.$datum[2]);
 		
 			$stopstamp = ($startstamp + $dauer);

			$ausgabe .= "BEGIN:VEVENT
UID:".date("Ymd\THis",time())."".$name."Moppi-generator
SUMMARY:".$_POST['name']."
STATUS:CONFIRMED
TRANSP:OPAQUE
DTSTAMP:".date("Ymd\THis",time())."
DTSTART:".date("Ymd\THis",$startstamp)."
DTEND:".date("Ymd\THis",$stopstamp)."
LOCATION:".$_POST['ort']."
GEO:".$_POST['geo']."
DESCRIPTION:".$_POST['beschreibung']."
END:VEVENT
";
		}
	}
	
	$ausgabe .= "END:VCALENDAR";
	
	print "<textarea name='xxxxxx' rows='20' cols='50'>".$ausgabe."</textarea>";
}



Print "</body>";
?>
