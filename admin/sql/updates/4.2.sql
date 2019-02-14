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
ALTER TABLE `#__gm_map` DROP `panoramio_parameter`;
ALTER TABLE `#__gm_circle` ADD (access_group int(2) NOT NULL);
ALTER TABLE `#__gm_rectangle` ADD (access_group int(2) NOT NULL);
ALTER TABLE `#__gm_line` ADD (access_group int(2) NOT NULL);
ALTER TABLE `#__gm_marker` ADD (access_group int(2) NOT NULL);
ALTER TABLE `#__gm_polygon` ADD (access_group int(2) NOT NULL);
ALTER TABLE `#__gm_text` ADD (access_group int(2) NOT NULL);
ALTER TABLE `#__gm_lang` 
	DROP `lang_button_title`, 
	DROP `lang_slider_map_view`, 
	DROP `lang_slider_layer`, 
	DROP `lang_slider_panoramio`, 
	DROP `lang_panoramio_panoramio`;