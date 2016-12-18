<?php
/*
    Boxtracker - Simple tracking of computer availability and ip-address.
    Copyright (C) <2013> <Kim Roar Fold&oslash;y Hauge>

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

function sql($str) {
	if(!($dbResult = mysql_query($str))) {
		print("Couldn't execute query!<BR>\n");
		print("MySQL reports: " . mysql_error() . "<br>\n");
		print("Query was: $Query<BR>\n");
		exit();
	}
	return $dbResult;
}

function flertall($substantiv, $i) {

	if (($i > 1) || ($i == 0) ) {
		if ($substantiv == "time") {
			return "timer";
		} else {
			return $substantiv . "er";
		}
	} else {
		return $substantiv;
	}

}

function tegnikon($tid) {
	if (!isset($_GET['ikon'])) {
		$_GET['ikon'] = "";
	}
	$ikon = htmlentities(strip_tags(mysql_real_escape_string($_GET['ikon'])), ENT_QUOTES, "UTF-8");

	if ($ikon == 2) $filtype = "png";
	else		$filtype = "svg";

	if ($ikon != 3) {
		if ($tid < 63)			print("<img width=\"16\" height=\"16\" src=\"smiley-happy.$filtype\" alt=\":-)\"/>");
		else if ($tid < 259200)		print("<img width=\"16\" height=\"16\" src=\"smiley-orange.$filtype\" alt=\":-|\"/>");
		else if ($tid < 2592000)	print("<img width=\"16\" height=\"16\" src=\"smiley-blue.$filtype\" alt=\":-(\"/>");
		else				print("<img width=\"16\" height=\"16\" src=\"smiley-grey.$filtype\" alt=\"X-|\"/>");
	} else {
		if ($tid < 63)			print(":-)");
		else if ($tid < 3601)		print(":-|");
		else if ($tid < 2592000)	print(":-(");
		else				print("X-|");
	}
}

function formatertidsiden($tid) {
	$difftid = $tid;

	$penaar = floor( $difftid / (3600 * 24 * 365));
	$difftid -= ($penaar * 3600 * 24 * 365);

	$penmnd = floor( $difftid / (3600 * 24 * 30.416666));
	$difftid -= floor($penmnd * (3600 * 24 * 30.4146666));

	$pendag = floor( $difftid / (3600 * 24));
	$difftid -= $pendag * (3600 * 24);

	$pentime = floor( $difftid / (3600));
	$difftid -= $pentime * (3600);

	$penmin = floor( $difftid / (60));
	$difftid -= $penmin * (60);

	// minst et år
	if ($penaar > 0) {
		$pensiden = "$penaar &aring;r";
		if ($penmnd > 0) {
			$pensiden = $pensiden . ", $penmnd " . flertall("m&aring;ned", $penmnd);
		}
		// minst en måned		
	} else if ($penmnd > 0) {
		$pensiden = "$penmnd " . flertall("m&aring;ned", $penmnd);
		if ($pendag > 0) {
			$pensiden = $pensiden . ", $pendag " . flertall("dag", $pendag);
		}
		// minst en dag
	} else if ($pendag > 0) {
		$pensiden = "$pendag " . flertall("dag", $pendag);
		if ($pentime > 0) {
			$pensiden = $pensiden . ", $pentime " . flertall("time", $pentime);
		}
		// minst en time
	} else if ($pentime > 0) {
		$pensiden = "$pentime " . flertall("time", $pentime);
		if ($penmin > 0) {
			$pensiden = $pensiden . ", $penmin " . flertall("minutt", $penmin);
		}
		// minst et minutt
	} else if ($penmin > 0) {
		$pensiden = "$penmin " . flertall("minutt", $penmin);
		if ($difftid > 0) {
			$pensiden = $pensiden . ", $difftid sekund";
		}
	} else {				// under et minutt
		$pensiden = "$difftid sekund" ;
	}
	return $pensiden;
}

function linje($farge, $x, $y) {
	$y = 3;
//       print("<div style=\"display:inline-block; width:100". "%" . "; background-color:$farge; min-height:" . $y . ";\"><img height=1px width=1px src=\"smiley-happy.svg\"/></div>\n");
	print("<p style=\"border-style:solid;border-width:1px;border-color:$farge\;padding: 0px;\"></p>\n");

}


function menyvalg($tekst, $url, $valg, $seksjon) {

	if ( $valg == $seksjon) {
		print("<span class=\"menyvalgt\">");
	} else {
		print("<span class=\"meny\">");
	}
	if (strlen($valg) > 0) {
		print("&#91;<a href=\"$url?seksjon=$valg#$valg\">$tekst</a>&#93;");
	} else {
		print("&#91;<a href=\"$url\">$tekst</a>&#93;");
	}
	print("</span>\n");
}	
?>
