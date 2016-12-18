<?
/*
   Boxtracker - Simple tracking of computer availability and ip-address.
   Copyright (C) <2016> <Kim Roar Fold&oslash;y Hauge>

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$version = "0.21-b2";
$versionstring = "Boxtracker " . $version;
$trackername = "SysRq";

// Databaseinfo
require("/home/prosjekt/boxtracker/db.php");

// POST og GET-data
include("getvask.php");

$lng =		getvask("lng");
$sp =		getvask("sp");
$p =		getvask("p");
$box =		getvask("box");
$seksjon = 	getvask("seksjon");
$historikk =	getvask("historikk");

$url = $_SERVER['REQUEST_URI'];

// Html-header, unicode ftw
header("Content-type:text/html; charset=utf-8");

// Håndtering av oppdatering av bokser og nye bokser
include("oppdaterboks.php");

// Diverse funksjoner
include("funksjoner.php");

// Session
session_start();

if (!isset($_SESSION['viseldre'])) $_SESSION['viseldre'] = 0;
if (!isset($_SESSION['topmodus'])) $_SESSION['topmodus'] = 0;

if (isset($_POST['konfigurasjon'])) {
	$_SESSION = array();
	$_SESSION['viseldre'] = postvask("viseldre");
	$_SESSION['topmodus'] = postvask("topmodus");
}

// Språk og tidssone
/*	if (strlen($lng))	setlocale(LC_ALL, $lng);
	else */			setlocale(LC_ALL, 'no_NO');

date_default_timezone_set("Europe/Berlin");

// HTML for vanlig websidevisning
/*
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
 */
?>
<!DOCTYPE html>
<head>
<title>AUTH TLS | CWD boxtracker | STAT -al 2004</title>
<link rel="stylesheet" type="text/css" media="screen" href="stiler.css"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<?php
if ($_SESSION['topmodus'] == 1) print("  <meta http-equiv=\"refresh\" content=\"60\" />\n");
?>

</head>
<body>

<? 

$urla = explode("?", $url);
$url = $urla[0];

menyvalg("Alle bokser", $url, "", $seksjon); // litt rare variablenavn...
menyvalg("Dokumentasjon", $url, "forklaring", $seksjon); 
menyvalg("Konfigurasjon", $url, "konfigurasjon", $seksjon);
menyvalg("Programvare", $url, "programvare", $seksjon);
//menyvalg("Nedlasting", $url, "nedlasting", $seksjon);
//menyvalg("Ny klient", $url, "innstallerklient", $seksjon);
//menyvalg("Ny server", $url, "innstallerserver", $seksjon);
//menyvalg("Lisens", $url, "gpl", $seksjon);
menyvalg("Endringslogg", $url, "endringslogg", $seksjon);
print("<hr/>\n");
/*
//print("&#91;<a href=\"$url\">Alle bokser</a>&#93;");
//print("&#91;<a href=\"$url?seksjon=forklaring#forklaring\">Forklaring</a>&#93;");
//print("&#91;<a href=\"$url?seksjon=konfigurasjon#konfigurasjon\">Konfigurasjon</a>&#93;");
//print("&#91;<a href=\"$url?seksjon=nedlasting#nedlasting\">Nedlasting</a>&#93;");
print("&#91;<a href=\"$url?seksjon=innstallerklient#innstallerklient\">Ny klient</a>&#93;");
print("&#91;<a href=\"$url?seksjon=innstallerserver#innstallerserver\">Server</a>&#93;");
print("&#91;<a href=\"$url?seksjon=gpl#gpl\">Lisens</a>&#93;");
print("&#91;<a href=\"$url?seksjon=endringslogg#endringslogg\">Endringslogg</a>&#93;");
 */
// print(" <span class=\"overskrift\"> - $trackername $versionstring</span><br/>");

if ($seksjon == "") {

	// Kode for å vite hvilke rekkefølge vi skal vise boksene i samt om alle skal vises.
	if ($_SESSION['viseldre'] != 1) { 
		$difftid = time() - 8640000;
	} else {
		$difftid = 0;
	}

	if (isset($_SESSION['order'])) {
		$order = $_SESSION['order'];
	} else {
		$order = "box";
	}

	if (isset($_GET['order'])) {
		$order = $_GET['order'];

		$urlorder = $order;

		if 	($order == "ip") 		$order = "ip ASC";
		else if ($order == "tilgjengelighet")	$order = "oppetikk / totaltikk DESC, tid DESC";
		else if ($order == "sett")		$order = "tid DESC";
		else 					$order = "box ASC";
	} else {
		$urlorder = "box";
	}

	$q = "SELECT oppetikk, totaltikk, box, ip, tid,url FROM boxtracker WHERE tid > '$difftid' ORDER by $order";
	$dbResult = sql($q);

	print("<table><tr><td>&nbsp;</td>\n");
	print("<th><a href=\"?order=box\">Boks</a></th>\n");
	print("<th><a href=\"?order=ip\">Host</a></th>\n");
	print("<th colspan=\"2\"><a href=\"?order=tilgjengelighet\">Tilgjengelighet</a></th>\n");
	print("<th colspan=\"1\"><a href=\"?order=sett\">Tid siden livstegn</a></th>\n");
	print("</tr>\n");
	while($dbRow = mysql_fetch_object($dbResult)) {
		$difftid = time() - ($dbRow->tid);
		$tidsiden = formatertidsiden($difftid);

		// Første kolonne
		print("<tr><td>");
		tegnikon($difftid);

		// Andre kolonne
		print("</td><td class=\"ip\"><a href=\"?seksjon=historikk&amp;=$urlorder&amp;historikk=$dbRow->box\">$dbRow->box</a>");

		// Tredje kolonne
		print("</td><td>");
		print(gethostbyaddr($dbRow->ip));
		print("</td>");

		// Fjerde og femte kolonne
		if ($dbRow->totaltikk > 0) {
			$pst = sprintf("%2.2f", ($dbRow->oppetikk / $dbRow->totaltikk)* 100);
		} else {
			$pst = "0.00";
		}
		print("<td class=\"pst\">$pst%</td>");

		// Sjette og sjuende kolonne
		print("<td>");
		//		strftime("%d.%m.%G &nbsp; %H:%M", $dbRow->tid );
		print("</td>");
		print("<td>$tidsiden</td></tr>\n");

	}
	print("</table>\n");

	/*
	   print("<a href=\"?lng=no_NO\">Norsk</a> ");
	   print("<a href=\"?lng=en_EN\">English</a> ");
	 */


} else if ($seksjon == "historikk") {
	print("<tr><td></td><td colspan=\"6\"><span class=\"deltavenstre\"><table class=\"deltalogg\">\n");

	$q = "SELECT * from delta WHERE box LIKE '$historikk' ORDER BY tid DESC";
	$res2 = sql($q);

	$rapporternedetid = -1;
	$opptid = 0;
	$nedtid = 0;
	$gammeldato = "";
	$statustid = 0;
	$nedegraf = ",";
	$tegnnedegraf = 0;
	$aar = 0;
	while ($row2 = mysql_fetch_object($res2)) {
		if ($statustid == 0) {

			$diff = time() - $row2->tid;

			/*
			   if ($row2->hendelse == "nede") {
			   if ($dbRow->tid < $row2->tid) { // fiks for bokser med lengre nedetid enn deltaloggingen
			   $diff = time() - $dbRow->tid;
			   }
			   } else {
			   $hendelse = "annen";
			   }
			 */
			$d = floor($diff / (3600*24));
			$diff -= ($d * 3600 * 24);

			$t = floor($diff / 3600);
			$diff -= ($t * 3600);

			$m = floor($diff / 60);
			$diff -= ($m * 60);

			$der = flertall("dag", $d);
			$ter = flertall("time", $t);

			if ($row2->hendelse != "annen") {
				print("<tr><td colspan=\"3\">Hendelseslogg");
				$boksinfo = "Boksen har vært $row2->hendelse i $d $der, $t $ter, $m minutt.";

				$fortsatt = "$d $der, $t $ter, $m minutt";
			}
			/*			if ($aar != strftime("%G", $nedtid)) {

						print("<tr><td>" . strftime("%G", $row2->tid));
						$aar = strftime("%G", $row2->tid);
						}*/

			$statustid = 1;
		}
		if ($aar != strftime("%G", $row2->tid)) {

			print("<tr><th colspan=\"2\">" . strftime("%G", $row2->tid) . "</th></tr>");
			$aar = strftime("%G", $row2->tid);
		}

		if ($row2->hendelse == "oppe") {
			$opptid = $row2->tid;
			$rapporternedetid = 0;
			$tegnnedegraf = 0;
		} else if ($row2->hendelse == "nede") {
			// grafkode
			if ($opptid > 0) {
				$tegnnedegraf = 1;
			}
			$rapporternedetid = 1;
			$nedtid = $row2->tid;
		}

		if ($tegnnedegraf == 1) {
			$nededager = $opptid - $nedtid + 60;

			$nedegraf .= floor(((time() - $row2->tid) / (3600*24))) . ",";

			$tidspunkt = $row2->tid;
			$n = 0;

			while ($nededager > (3600 * 24)) {
				$n--;
				$nydag = floor((time() - $tidspunkt ) / (3600*24)) - $n . "," ;
				$nedegraf .= $nydag;

				$nededager = $nededager - (3600 * 24);
			}
		}

		if ($rapporternedetid == 1) {
			$nedklokkeslett = strftime("%H:%M", $nedtid );
			$neddato = strftime("%d.%m", $nedtid);

			$oppklokkeslett = strftime("%H:%M", $opptid );
			$oppdato = strftime("%d.%m", $opptid);

			if ($oppdato == $neddato) {
				$oppdato = "";
			}

			if ($opptid > 0) {

				if ($neddato != $gammeldato) {
					print("<tr><td class=\"loggdato\">$neddato </td><td class=\"loggcelle\"> $nedklokkeslett - $oppdato $oppklokkeslett");
				} else {
					print("<tr><td class=\"loggdato\">...</td><td class=\"loggcelle\"> $nedklokkeslett - $oppklokkeslett");
				}
				if (($opptid - $nedtid) < 70) {
					print(" - Nede ca 1 minutt.</td></tr>\n");
				} else  {
					print(" - Nede " . formatertidsiden($opptid - $nedtid) . "</td></tr>\n");
				}
			} else {
				print("<tr><td class=\"loggdato\">$neddato </td><td class=\"loggcelle\"> $nedklokkeslett ");

				print(" - Nede i " . $fortsatt . "</td></tr>\n");
		
				$diff = time() - $row2->tid;
				$d = floor($diff / (3600*24));

				$brk = 0;
				
				for ($i = $d; $i != -1; $i--) {
					$nedegraf .= "$i,";

					$brk++;

					if ($brk == 400) {
						break;
					}
				}

			}

			$gammeldato = $neddato;
		} 
		//		print("</td></tr>\n");


	}
	print("</td></tr>\n</table></span>");
	print("<span class=\"deltahoyre\">");
	print("$boksinfo <br/><br/>");
	print("Tilgjengelighet siste 52 ukene<br/>");
	print("<img src=\"graf.png.php?nede=$nedegraf\"/>");
	/*
	   if (strlen($dbRow->url)) {
	   print("<span class=\"url\"><br/><a href=\"");
	   if (strstr($dbRow->url, "http")) {
	   print("$dbRow->url\">");
	   } else {
	   print("http://$dbRow->ip$dbRow->url\">http://$dbRow->ip");
	   }
	   print("$dbRow->url</a></span>\n");
	   }
	 */
	print("</span>");

	print("</td></tr>");




} else if ($seksjon == "forklaring") {
	print("<h2 id=\"forklaring\">Ikoner og kompabilitet</h2>");
	print("<p>Maskinene m&aring; selv si i fra n&aring;r de er i live, s&aring; blir dette registrert i en database.<br/>");

	tegnikon(99999999); 	print(" - Maskinen har v&aelig;rt nede i mer enn 30 dager.<br/>");
	tegnikon(259201); 	print(" - Maskinen har v&aelig;rt nede i 3 dager til 30 dager.<br/>");
	tegnikon(90);		print(" - Maskinen har v&aelig;rt nede i 1 minutt til 3 dager.<br/>");
	tegnikon(1);		print(" - Maskinen har v&aelig;rt aktiv i det siste minuttet.<br/>");

	print("<br/>Websida er utformet slik at det kan vises i alle mulige nettlesere, selv dem som er tekstbaserte som links, lynx og w3m.</p>");
	print("<p><a href=\"http://validator.w3.org/check?uri=referer\"><img src=\"valid-html5-button.png\" alt=\"Valid HTML 5\" height=\"31\" width=\"87\" /></a> <a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img style=\"border:0;width:88px;height:31px\" src=\"http://www.w3.org/Icons/valid-css2-blue.png\" alt=\"Valid CSS!\" /></a>");

	print("<h2 id=\"gpl\">Lisens</h2>");
	print("<pre>");
	include("gpl.txt");
	print("</pre>");


} else if ($seksjon == "konfigurasjon") {
	//	print("\n<h2 id=\"konfigurasjon\"> Konfigurasjon</h2>\n");
	print("<p>\n");
	print("\n<form action=\"$url\" method=\"post\">");
	print("\n<input type=\"hidden\" name=\"konfigurasjon\" value=\"endre\">");
	print("\n<input type=\"checkbox\" name=\"viseldre\" value=\"1\" />Vis bokser med lang nedetid.<br/>");
	print("\n<input type=\"checkbox\" name=\"topmodus\" value=\"1\" />Oppdater hvert minutt.<br/>");
	print("\n\n<br/>\n<input type=\"submit\" value=\"Oppdater sesjon\">");
	print("</form>\n</p>\n");

} else if ($seksjon == "programvare") {
	print("<h2 id=\"nedlasting\">Nedlasting</h2>");
	print("<p><a href=\"boxtracker-0.15-b1.tar\">0.15-b1</a> Nyeste utgitte versjon, antagelig stabil.</p>");
	//} else if ($seksjon == "innstallerklient") {
	print("<h2 id=\"innstallerklient\">Installasjon klient</h2>");
	print("<pre>echo \"wget -q -O /dev/null \\\"http://boxtracker.sysrq.no/index.php?box=[BOX]&amp;p=[PASSORD]\\\"\" > /root/boxtracker.sh\n");
	print("chmod +x /root/boxtracker.sh\n");
	print("crontab -e\n");
	print("*/1 * * * * /root/boxtracker.sh > /dev/null</pre>\n");
	// } else if ($seksjon == "innstallerserver") {
	/*	print("<h2 id=\"innstallerserver\">Innstallasjon server v0.19-b5+</h2>");
		print("Du trenger en mysql-database f&oslash;lgende tabeller:<pre>'boxtracker':\n");
		print(" box - varchar(100)\n");
		print(" ip - varchar(20)\n");
		print(" tid - bigint(20)\n");
		print(" gruppe - varchar(20)\n");
		print(" passord - varchar(50)\n");
		print(" url - varchar(200)\n");
		print(" oppetikk - bigint(20)\n");
		print(" totaltikk - bigint (20)\n");
		print(" delta - varchar(15)\n");

		print("\n'deltalogg':\n");
		print(" box - varchar(40)\n");
		print(" tid - int(32)\n");
		print(" hendelse - varchar(40)</pre>\n");
	 */
	print("<h2>Innstallasjon server v0.15-b</h2>");
	print("<pre>Du trenger en mysql-database med en tabell 'boxtracker' med f&oslash;lgende felter:\n");
	print("box - varchar(100)\n");
	print("ip - varchar(20)\n");
	print("tid - bigint(20)\n");
	print("gruppe - varchar(20)\n");
	print("passord - varchar(50)\n");
	print("url - varchar(200)\n\n");

	print("Putt index.php sammen med svg/png-bildene i en egnet katalog. ");
	print("Putt db.php i en katalog som ikke er lesbar for andre og endre index.php til &aring; ");
	print("peke til denne filens lokasjon.</pre>\n");
	} else if ($seksjon == "gpl") {
		/*	print("<h2 id=\"gpl\">Lisens</h2>");
			print("<pre>");
			include("gpl.txt");
			print("</pre>");*/
	} else if ($seksjon == "endringslogg") {
		print("<pre>\n");
		include("endringslogg.php");
		print("</pre>");
	} 
print("<hr/><span class=\"overskrift\">$versionstring @ $trackername</span><br/>");


?>
</body>
</html>
