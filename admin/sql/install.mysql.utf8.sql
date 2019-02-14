
DROP TABLE IF EXISTS #__gm_circle;
CREATE TABLE `#__gm_circle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_map` int(3) NOT NULL,
  `circle_position1_lat` varchar(20) NOT NULL,
  `circle_position1_lng` varchar(20) NOT NULL,
  `circle_radius` int(20) NOT NULL,
  `circle_farbe_linie` varchar(10) NOT NULL,
  `circle_linie_breite` int(2) NOT NULL,
  `circle_transparent_linie` varchar(5) NOT NULL,
  `circle_farbe_fuellung` varchar(10) NOT NULL,
  `circle_transparent_fuellung` varchar(5) NOT NULL,
  `circle_parameter` text NOT NULL,
  `circle_beschreibung` text NOT NULL,
  `access_group` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS #__gm_config;
CREATE TABLE `#__gm_config` (
  `id` int(5) NOT NULL DEFAULT '1',
  `conf_map_breite` varchar(5) NOT NULL,
  `conf_map_hoehe` varchar(5) NOT NULL,
  `conf_start_zoom` varchar(5) NOT NULL,
  `conf_center_lat` varchar(20) NOT NULL,
  `conf_center_lng` varchar(20) NOT NULL,
  `conf_parameter` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `#__gm_config` VALUES (1, '600', '600', '5', '52.05688697392451', '10.249298095703118', '');

DROP TABLE IF EXISTS #__gm_lang;
CREATE TABLE IF NOT EXISTS `#__gm_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_title` varchar(80) NOT NULL,
  `lang_short` varchar(5) NOT NULL,
  `lang_map_view_roadmap` varchar(100) NOT NULL,
  `lang_map_view_terrain` varchar(100) NOT NULL,
  `lang_map_view_satellite` varchar(100) NOT NULL,
  `lang_map_view_hybrid` varchar(100) NOT NULL,
  `lang_layer_bike` varchar(100) NOT NULL,
  `lang_layer_traffic` varchar(100) NOT NULL,
  `lang_layer_transit` varchar(100) NOT NULL,
  `lang_layer_weather` varchar(100) NOT NULL,
  `lang_layer_streetview` varchar(100) NOT NULL,
  KEY `id` (`id`)
) DEFAULT CHARSET=utf8 ;

INSERT INTO `#__gm_lang` (`id`, `lang_title`, `lang_short`, `lang_map_view_roadmap`, `lang_map_view_terrain`, `lang_map_view_satellite`, `lang_map_view_hybrid`, `lang_layer_bike`, `lang_layer_traffic`, `lang_layer_transit`, `lang_layer_weather`, `lang_layer_streetview`) VALUES
(1, 'German', 'de','Straßenkarte', 'Geländekarte', 'Satellit', 'Satellit & Beschriftung','Radwege', 'Straßenverkehr', 'Öffentliche Verkehrsmittel', 'Wetter', 'Street View'),
(2, 'English', 'en', 'Road map', 'Terrain map', 'Satellite', 'Satellite & Marking', 'Bike paths', 'Road Traffic', 'Public transport', 'Weather', 'Streetview'),
(3, 'French', 'fr', 'Carte routière', 'Carte du terrain', 'Satellite', 'Satellite & Marquage', 'Les pistes cyclables', 'Circulation routière', 'Transport en commun', 'Météo', 'Street View');

DROP TABLE IF EXISTS #__gm_line;
CREATE TABLE `#__gm_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_map` int(3) NOT NULL,
  `line_titel` varchar(100) NOT NULL,
  `line_breite` int(2) NOT NULL,
  `line_farbe` varchar(10) NOT NULL,
  `line_transparent` varchar(3) NOT NULL,
  `line_punkte` text NOT NULL,
  `line_parameter` text NOT NULL,
  `line_beschreibung` text NOT NULL,
  `access_group` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS #__gm_map;
CREATE TABLE `#__gm_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_titel` varchar(255) NOT NULL,
  `map_beschreibung` text NOT NULL,
  `map_center_lat` varchar(30) NOT NULL,
  `map_center_lng` varchar(30) NOT NULL,
  `map_zoom` varchar(3) NOT NULL,
  `map_parameter` text NOT NULL,
  `street_view_parameter` text NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS #__gm_marker;
CREATE TABLE `#__gm_marker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_map` int(3) NOT NULL,
  `marker_titel` varchar(100) NOT NULL,
  `marker_strasse` varchar(150) NOT NULL,
  `marker_plz` varchar(6) NOT NULL,
  `marker_ort` varchar(50) NOT NULL,
  `marker_beschreibung` text NOT NULL,
  `marker_icon` varchar(60) NOT NULL,
  `marker_lng` varchar(30) NOT NULL,
  `marker_lat` varchar(30) NOT NULL,
  `marker_parameter` text NOT NULL,
  `access_group` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS #__gm_rectangle;
CREATE TABLE `#__gm_rectangle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_map` int(3) NOT NULL,
  `rectangle_position1_lat` varchar(20) NOT NULL,
  `rectangle_position1_lng` varchar(20) NOT NULL,
  `rectangle_position2_lat` varchar(20) NOT NULL,
  `rectangle_position2_lng` varchar(20) NOT NULL,
  `rectangle_farbe_linie` varchar(10) NOT NULL,
  `rectangle_linie_breite` int(2) NOT NULL,
  `rectangle_transparent_linie` varchar(5) NOT NULL,
  `rectangle_farbe_fuellung` varchar(10) NOT NULL,
  `rectangle_transparent_fuellung` varchar(5) NOT NULL,
  `rectangle_parameter` text NOT NULL,
  `rectangle_beschreibung` text NOT NULL,
  `access_group` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS #__gm_polygon;
CREATE TABLE `#__gm_polygon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_map` int(10) NOT NULL,
  `polygon_titel` varchar(100) NOT NULL,
  `polygon_color_line` varchar(10) NOT NULL,
  `polygon_width_line` varchar(2) NOT NULL,
  `polygon_transparent_line` varchar(5) NOT NULL,
  `polygon_color_fill` varchar(10) NOT NULL,
  `polygon_transparent_fill` varchar(5) NOT NULL,
  `polygon_path` text NOT NULL,
  `polygon_parameter` text NOT NULL,
  `polygon_beschreibung` text NOT NULL,
  `access_group` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS #__gm_text;
CREATE TABLE `#__gm_text` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_map` int(5) NOT NULL,
  `text_text` text NOT NULL,
  `text_lat` varchar(20) NOT NULL,
  `text_lng` varchar(20) NOT NULL,
  `text_parameter` text NOT NULL,
  `access_group` int(2) NOT NULL,
  KEY `id` (`id`)
) DEFAULT CHARSET=utf8;

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
(1, 'Sample KML', 'http://www.joomla-24.de/kml/sample.kml', 'Beispiel Text für ein Info Fenster', '');

DROP TABLE IF EXISTS `#__gm_line_style`;
CREATE TABLE IF NOT EXISTS `#__gm_line_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `path` text NOT NULL,
  `anchor_x` varchar(5) NOT NULL,
  `anchor_y` varchar(3) NOT NULL,
  `fillColor` varchar(8) NOT NULL,
  `fillOpacity` varchar(3) NOT NULL DEFAULT '0',
  `strokeColor` varchar(8) NOT NULL,
  `strokeWeight` varchar(8) NOT NULL DEFAULT '1',
  `strokeOpacity` varchar(8) NOT NULL DEFAULT '0',
  `rotation` varchar(3) NOT NULL DEFAULT '0',
  `scale` varchar(3) NOT NULL DEFAULT '0',
  `parameter` text NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `#__gm_line_style` (`id`, `title`, `path`, `anchor_x`, `anchor_y`, `fillColor`, `fillOpacity`, `strokeColor`, `strokeWeight`, `strokeOpacity`, `rotation`, `scale`, `parameter`) VALUES
(1, 'Quadrat', 'm -0.5,-0.5\r\nl 1 0, 0 1, -1 0  z\r\n           ', '0', '0', '#ff001e', '4', '#141412', '1', '0', '0', '1', ''),
(2, 'Linie', 'm -0.2,1 \r\n0,-3 0.2,0 0,3', '-0.01', '0', '#030303', '0', '#696767', '1', '0', '90', '3', ''),
(3, 'Kreispunkt', 'm -0.6, 0 \r\na 0.6,0.6 0 0,0 1.2,0\r\na 0.6,0.6 0 0,0 -1.2,0', '', '', '#ffd900', '0', '#8f5959', '1', '10', '0', '2', '');