CREATE TABLE `boxtracker` (
  `box` varchar(100) NOT NULL,
  `ip` varchar(60) NOT NULL,
  `tid` bigint(20) NOT NULL,
  `gruppe` varchar(20) NOT NULL,
  `passord` varchar(50) NOT NULL,
  `url` varchar(200) NOT NULL,
  `oppetikk` bigint(20) NOT NULL DEFAULT '1',
  `totaltikk` bigint(20) NOT NULL DEFAULT '1',
  `delta` varchar(15) NOT NULL DEFAULT 'nede'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `delta` (
  `id` int(11) NOT NULL,
  `box` varchar(40) NOT NULL,
  `tid` int(32) NOT NULL,
  `hendelse` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `boxtracker`
  ADD PRIMARY KEY (`box`);

ALTER TABLE `delta`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `delta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
