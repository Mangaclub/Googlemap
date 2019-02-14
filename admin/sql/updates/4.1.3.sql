DROP TABLE IF EXISTS #__gm_kml;
CREATE TABLE IF NOT EXISTS `#__gm_kml` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`kml_title` varchar(100) NOT NULL,
	`kml_pfad` varchar(200) NOT NULL,
	`kml_beschreibung` text NOT NULL,
	`kml_parameter` text NOT NULL,
	KEY `id` (`id`)
)  DEFAULT CHARSET=utf8;

INSERT INTO `#__gm_kml` (`id`, `kml_title`, `kml_pfad`, `kml_beschreibung`, `kml_parameter`) VALUES
(1, 'Sample KML', 'http://www.joomla.de.com/kml/sample.kml', 'Beispiel Text für ein Info Fenster', '');