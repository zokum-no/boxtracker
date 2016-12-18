<?
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
?>
0.21-b2 (2015-11-13)
 * La till et enkelt favicon.ico

0.21-b1 (2015-11-06)
 * Endret på footeren.

0.20-b3 (2015-10-25)
 * Oppdaterte grafene, reversert til å tegne fra venstre, la til tall for hver
   fjerde uke.
 * Fikset en bug i loggsystemet ved å fjerne en gammel fiks.

0.20-b2 (2015-07-22)
 * Grafen på sidene med detaljert informasjon inneholder nedetidssinformasjon 
   fra samme dag.

0.20-b1 (2013-07-22)
 * Oppdatert til html 5. Fikset en rekke mindre bugs, lisensfila er ikke helt
   korrekt html5-formatert. Ny html 5-knapp.

0.19-b5 (2013-07-22)
 * Oppetidshistoriekken er n&aring; mye mer korrekt og sorteres slik at nyere
   hendelser er p&aring; toppen.

0.19-b5 (2013-02-24
 * Bokser som har vært nede i 64 sekund til til tre dager er nå oransje.

0.19-b4 (2013-02-22)
 * Bugfikser i boksloggingen. Registrerer opp, ned samt nye bokser.
 * Dynamiske urler benytter nå ip om urlen ikke inneholder http.
 * Mindre forbedringer i oppetidsloggen. Det gjenstår en del arbeid.

0.19-b3 (2013-02-20)
 * Informasjon om bokser ved å klikke på dem.

0.19-b2 (2013-02-09)
 * Historikk over oppetid per boks.
 * w3c-validert html.

0.19-b1 (2013-02-08)
 * Småfikser i kodestil.

0.18-r1 (2013-02-07)
 * Ubetydelige endringer.

0.18-b2 (2013-01-27)
 * Ørsmå forbedringer i et par rutiner.

0.18-b1 (2012-12-28)
 * Sortering etter andre kriterier enn boksnavn.
 * Top-mode i konfigurasjonen for automatisk omlasting av sida.
 * Delte opp koden i flere filer.

0.17-rc1 (2012-12-27)
 * Bokser som har vært offline i mer enn 100 dager vises ikke.

0.17-b5 (2012-10-12)
 * Benytter html-koder for spesialtegn.
 * Burde validere som HTML5.

0.17-b4 (2012-04-02)
 * Fikset en liten bug med bokser som er nede i 1-30 dager.

0.17-b3 (2012-03-26)
 * Bokser med nedetid over et &aring;r vises ikke lenger som standard.
 * En kan velge mellom svg, png eller tekstmodus-ikoner.
 * Nytt menysystem p&aring; bunnen, det begynte &aring; bli rotete.
 * Mulighet for konfigurere sm&aring;ting per sesjon. Det kommer mer her.
   Flere opsjoner og at den 'husker' hva du har huket av.
 * Kraftig omskriving av ikon-systemet.
 * Nytt datoformat, igjen.
 * Anker p&aring; alle linkene.
 * Lagt til informasjon om lisensen.

0.17-b2 (2012-03-26)
 * Fikset et problem med at programmet viste feil ikon.

0.17-b1 (2012-03-06)
 * Nye ikoner i svg-format.

0.16-b4 (2012-02-22)
 * Fikset noen advarsler som en nyere versjon av PHP spyttet ut.
 * Oppgradert til xhtml 1.1, css 2.1 samt fikset alle W3Cs validator-advarsler.
 * Bedre tidsangivelse p&aring; antall &aring;r/m&aring;neder siden, b&oslash;r skrives ny algoritme.

0.16-b3 (2012-01-24)
 * Fikset spr&aring;k p&aring; datoene, bruker locale-innstillinger.
 * Rudiment&aelig;r st&oslash;tte for andre spr&aring;k.

0.16-b2 (2012-01-07)
 * Mer kompakt og lettelst sist sett-format.
 * Ny kolonne tilgjengelighet, hvor god oppetid maskinen har.
 * Valideringsikoner nederst p&aring; sida.
 * Ny modell for tilgjengelighet med servertikk.
 * Fjernet parantes rundt data i siste kolonne.

0.16-b1 (2012-01-06)
 * Kun maskiner som er online vil vise http-link.
 * Er n&aring; xhtml strict og validerer 100%
 * CSS brukes for utseende, ny fil: stiler.css.

0.15-b2 (2012-01-06)
 * Sm&aring; forbedringer av html.

0.15-b1 (2012-01-06)
 * Forbedret sikkerhet, fjernet mulig SQL-injection.
 * Fjerne kolonne for 'link'. Denne funksjonaliteten er n&aring; en del av ip-kolonnen
 * Oppdatert dokumentasjonen, kort om installasjon p&aring; serverside.

0.14-r2 (2012-01-06)
 * Versjon 0.14 release 2 er n&aring; tilgjengelig som <a href="boxtracker-0.14r2.tar">download</a>.

0.14 (2011-11-25)
 * Koden er n&aring; tilgkengelig under en GPL3-lisens, ta kontakt p&aring; irc for kildekode.

0.13-rc4 (2011-10-22)
 * Fikset det slik at det n&aring;r st&aring;r m&aring;ned i entall om det kun er en m&aring;ned.
 * Endret bredden p&aring; tabellen til 100%.

0.13-rc3 (2011-08-13)
 * Maskiner med nedetid over 30 dager f&aring;r n&aring; nedetid i &aring;r og a&aring;neder.

0.13-rc2
 * Maskiner med [ osv i navnet kan ikke autoregistreres.

0.13-rc1
 * Du kan n&aring; registrere nye maskiner automatisk fra en god del av uninett,  
   kontakt zokum p&aring; EFNet for maskiner utenom uninett.

0.12-rc1
 * Flyttet over p&aring; egen prosjektkonto.

0.11
 * Sm&aring;fikser, husker ikke s&aring; godt.

0.10
 * F&oslash;rste offentlige versjon.
