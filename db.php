<?
/*
    Boxtracker - Simple tracking of computer availability and ip-address.
    Copyright (C) <2012> <Kim Roar Foldøy Hauge>

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

mysql_connect("localhost","boxtracker","PASSWORD")
or die("<br>Kan ikke koble seg mot databasen, vennligst send mail til <a href=\"maitlo:webmaster@domene\">webmaster</a> med feilmeldingen over.");

@mysql_select_db("boxtracker")
or die("<br>Kan ikke koble seg mot databasen, vennligst send mail til <a href=\"maitlo:webmaster@domene\">webmaster</a> med feilmeldingen over.");
?>
