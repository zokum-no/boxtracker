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
	function delta($box, $hendelse) {
		print("$box er naa $hendelse<br/>");
		$q = "UPDATE boxtracker SET delta = '$hendelse' WHERE box LIKE '$box'";
		mysql_query($q);

		$nu = time(NULL);
		$q = "INSERT INTO delta SET box = '$box', tid = '$nu', hendelse = '$hendelse'";
		mysql_query($q);
	}

	$q = "SELECT box, tid, delta FROM boxtracker order by box";
	$res = mysql_query($q);

	while($row = mysql_fetch_object($res)) {
		$nu = time();

		$d = $row->delta;
		$t = $row->tid;
		$b = $row->box;

		if ($t < ($nu - 90)) { // ikke noe liv siste 90 sek
			if ($d == "nede") {
				 // gjør ingenting
			} else if ($d == "oppe") {
				// oppdater med ny deltahendelse
				delta($b, "nede");
			}

		}
		else {
			if ($d == "oppe") {
				// gjør ingenting
			} else /* if ($d == "nede") */ {
				// oppdater med ny deltahendelse
				delta($b, "oppe");
			}
		}
	}

?>
