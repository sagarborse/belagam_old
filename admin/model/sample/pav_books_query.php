<?php 

$query['pavsliderlayer'][]  = "  DROP TABLE IF EXISTS `".DB_PREFIX ."pavoslidergroups`; ";
$query['pavsliderlayer'][]  = "  DROP TABLE IF EXISTS `".DB_PREFIX ."pavosliderlayers`; ";

$query['pavsliderlayer'][] = "
CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."pavoslidergroups` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`params` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
"; 


$query['pavsliderlayer'][] = "
CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."pavosliderlayers` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`parent_id` int(11) NOT NULL,
`group_id` int(11) NOT NULL,
`params` text NOT NULL,
`layersparams` text NOT NULL,
`image` varchar(255) NOT NULL,
`status` tinyint(1) NOT NULL,
`position` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;
"; 


$query['pavsliderlayer'][] ="
INSERT INTO `".DB_PREFIX ."pavoslidergroups` (`id`, `title`, `params`) VALUES
(3, 'Books Sliders', 'a:28:{s:5:\"title\";s:13:\"Books Sliders\";s:5:\"delay\";s:4:\"9000\";s:9:\"fullwidth\";s:9:\"fullwidth\";s:5:\"width\";s:3:\"940\";s:6:\"height\";s:3:\"443\";s:12:\"touch_mobile\";s:1:\"1\";s:13:\"stop_on_hover\";s:1:\"1\";s:12:\"shuffle_mode\";s:1:\"0\";s:14:\"image_cropping\";s:1:\"0\";s:11:\"shadow_type\";s:1:\"0\";s:14:\"show_time_line\";s:1:\"1\";s:18:\"time_line_position\";s:3:\"top\";s:16:\"background_color\";s:7:\"#604f32\";s:6:\"margin\";s:3:\"0px\";s:7:\"padding\";s:3:\"0px\";s:16:\"background_image\";s:1:\"0\";s:14:\"background_url\";s:0:\"\";s:14:\"navigator_type\";s:6:\"bullet\";s:16:\"navigator_arrows\";s:4:\"none\";s:16:\"navigation_style\";s:5:\"round\";s:17:\"offset_horizontal\";s:1:\"0\";s:15:\"offset_vertical\";s:2:\"20\";s:14:\"show_navigator\";s:1:\"1\";s:20:\"hide_navigator_after\";s:3:\"200\";s:15:\"thumbnail_width\";s:3:\"100\";s:16:\"thumbnail_height\";s:2:\"50\";s:16:\"thumbnail_amount\";s:1:\"5\";s:17:\"hide_screen_width\";s:0:\"\";}');
";
	

$query['pavsliderlayer'][] = "
INSERT INTO `".DB_PREFIX ."pavosliderlayers` (`id`, `title`, `parent_id`, `group_id`, `params`, `layersparams`, `image`, `status`, `position`) VALUES
(15, 'Banner Book 3', 0, 3, 'a:16:{s:2:\"id\";s:2:\"15\";s:15:\"slider_group_id\";s:1:\"3\";s:12:\"slider_title\";s:13:\"Banner Book 3\";s:13:\"slider_status\";s:1:\"1\";s:17:\"slider_transition\";s:6:\"random\";s:11:\"slider_slot\";s:1:\"7\";s:15:\"slider_rotation\";s:1:\"0\";s:15:\"slider_duration\";s:3:\"300\";s:12:\"slider_delay\";s:1:\"0\";s:11:\"slider_link\";s:0:\"\";s:16:\"slider_thumbnail\";s:0:\"\";s:15:\"slider_usevideo\";s:1:\"0\";s:14:\"slider_videoid\";s:0:\"\";s:16:\"slider_videoplay\";s:1:\"0\";s:9:\"slider_id\";s:2:\"15\";s:12:\"slider_image\";s:23:\"data/demo/bg-slider.png\";}', 'O:8:\"stdClass\":1:{s:6:\"layers\";a:6:{i:0;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:1;s:13:\"layer_content\";s:30:\"data/demo/banner-promotion.png\";s:10:\"layer_type\";s:5:\"image\";s:11:\"layer_class\";s:0:\"\";s:13:\"layer_caption\";s:17:\"Your Image Here 1\";s:15:\"layer_animation\";s:3:\"lfl\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"91\";s:10:\"layer_left\";s:2:\"36\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltl\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"2045\";}i:1;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:2;s:13:\"layer_content\";s:27:\"data/demo/banner-book-3.png\";s:10:\"layer_type\";s:5:\"image\";s:11:\"layer_class\";s:0:\"\";s:13:\"layer_caption\";s:17:\"Your Image Here 2\";s:15:\"layer_animation\";s:3:\"lfr\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"94\";s:10:\"layer_left\";s:3:\"266\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltr\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"2287\";}i:2;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:3;s:13:\"layer_content\";s:27:\"data/demo/banner-book-3.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:9:\"pav_small\";s:13:\"layer_caption\";s:12:\"Donec metus \";s:15:\"layer_animation\";s:3:\"lfr\";s:12:\"layer_easing\";s:10:\"easeInCirc\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"91\";s:10:\"layer_left\";s:3:\"662\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltr\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"2659\";}i:3;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:4;s:13:\"layer_content\";s:27:\"data/demo/banner-book-3.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:7:\"pav_big\";s:13:\"layer_caption\";s:5:\"OFFER\";s:15:\"layer_animation\";s:3:\"lfr\";s:12:\"layer_easing\";s:11:\"easeInCubic\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"150\";s:10:\"layer_left\";s:3:\"714\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltr\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"2747\";}i:4;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:5;s:13:\"layer_content\";s:27:\"data/demo/banner-book-3.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:8:\"pav_desc\";s:13:\"layer_caption\";s:96:\"Lorem isum dolor sit amet consectetur dipiscing elituce &lt;br/&gt; non massa sit amet vehicula \";s:15:\"layer_animation\";s:3:\"lfl\";s:12:\"layer_easing\";s:10:\"easeInQuad\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"236\";s:10:\"layer_left\";s:3:\"586\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltr\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"2000\";}i:5;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:6;s:13:\"layer_content\";s:27:\"data/demo/banner-book-3.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:16:\"pav-button-layer\";s:13:\"layer_caption\";s:94:\"&lt;a href=&quot;index.php?route=product/product_ASM_product_id=52&quot;&gt;Shop now&lt;/a&gt;\";s:15:\"layer_animation\";s:3:\"lft\";s:12:\"layer_easing\";s:10:\"easeInQuad\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"316\";s:10:\"layer_left\";s:3:\"818\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltb\";s:15:\"layer_endeasing\";s:14:\"easeInOutQuint\";s:10:\"time_start\";s:4:\"2400\";}}}', 'data/demo/bg-slider.png', 1, 0),
(8, 'Banner Book 1', 0, 3, 'a:16:{s:2:\"id\";s:1:\"8\";s:15:\"slider_group_id\";s:1:\"3\";s:12:\"slider_title\";s:13:\"Banner Book 1\";s:13:\"slider_status\";s:1:\"1\";s:17:\"slider_transition\";s:6:\"random\";s:11:\"slider_slot\";s:1:\"7\";s:15:\"slider_rotation\";s:1:\"0\";s:15:\"slider_duration\";s:3:\"600\";s:12:\"slider_delay\";s:1:\"0\";s:11:\"slider_link\";s:0:\"\";s:16:\"slider_thumbnail\";s:0:\"\";s:15:\"slider_usevideo\";s:1:\"0\";s:14:\"slider_videoid\";s:0:\"\";s:16:\"slider_videoplay\";s:1:\"1\";s:9:\"slider_id\";s:1:\"8\";s:12:\"slider_image\";s:25:\"data/demo/bg-slider-3.png\";}', 'O:8:\"stdClass\":1:{s:6:\"layers\";a:3:{i:0;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:1;s:13:\"layer_content\";s:27:\"data/demo/banner-book-1.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:9:\"pav_small\";s:13:\"layer_caption\";s:12:\"Donec metus \";s:15:\"layer_animation\";s:3:\"lfr\";s:12:\"layer_easing\";s:14:\"easeInOutQuint\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"63\";s:10:\"layer_left\";s:3:\"660\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltr\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"2324\";}i:1;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:2;s:13:\"layer_content\";s:30:\"data/demo/banner-promotion.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:7:\"pav_big\";s:13:\"layer_caption\";s:5:\"OFFER\";s:15:\"layer_animation\";s:3:\"lfr\";s:12:\"layer_easing\";s:11:\"easeOutBack\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"126\";s:10:\"layer_left\";s:3:\"705\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltl\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"3056\";}i:2;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:3;s:13:\"layer_content\";s:30:\"data/demo/banner-promotion.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:8:\"pav_desc\";s:13:\"layer_caption\";s:96:\"Lorem isum dolor sit amet consectetur dipiscing elituce &lt;br/&gt; non massa sit amet vehicula \";s:15:\"layer_animation\";s:3:\"lfl\";s:12:\"layer_easing\";s:11:\"easeOutBack\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"211\";s:10:\"layer_left\";s:3:\"597\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltr\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"2000\";}}}', 'data/demo/bg-slider-3.png', 1, 0),
(14, 'Banner Book 2', 0, 3, 'a:16:{s:2:\"id\";s:2:\"14\";s:15:\"slider_group_id\";s:1:\"3\";s:12:\"slider_title\";s:13:\"Banner Book 2\";s:13:\"slider_status\";s:1:\"1\";s:17:\"slider_transition\";s:6:\"random\";s:11:\"slider_slot\";s:1:\"7\";s:15:\"slider_rotation\";s:1:\"0\";s:15:\"slider_duration\";s:3:\"500\";s:12:\"slider_delay\";s:1:\"0\";s:11:\"slider_link\";s:0:\"\";s:16:\"slider_thumbnail\";s:0:\"\";s:15:\"slider_usevideo\";s:1:\"0\";s:14:\"slider_videoid\";s:0:\"\";s:16:\"slider_videoplay\";s:1:\"0\";s:9:\"slider_id\";s:2:\"14\";s:12:\"slider_image\";s:25:\"data/demo/bg-slider-2.png\";}', 'O:8:\"stdClass\":1:{s:6:\"layers\";a:5:{i:0;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:1;s:13:\"layer_content\";s:31:\"data/demo/banner_digital_01.png\";s:10:\"layer_type\";s:5:\"image\";s:11:\"layer_class\";s:0:\"\";s:13:\"layer_caption\";s:17:\"Your Image Here 2\";s:15:\"layer_animation\";s:3:\"lfl\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"43\";s:10:\"layer_left\";s:2:\"46\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltl\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:3:\"800\";}i:1;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:2;s:13:\"layer_content\";s:27:\"data/demo/banner-book-2.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:9:\"pav_small\";s:13:\"layer_caption\";s:12:\"Donec metus \";s:15:\"layer_animation\";s:3:\"lft\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"64\";s:10:\"layer_left\";s:3:\"659\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:4:\"auto\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"1200\";}i:2;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:3;s:13:\"layer_content\";s:27:\"data/demo/banner-book-2.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:7:\"pav_big\";s:13:\"layer_caption\";s:7:\"Caption\";s:15:\"layer_animation\";s:3:\"lft\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"122\";s:10:\"layer_left\";s:3:\"651\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:4:\"auto\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"1600\";}i:3;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:4;s:13:\"layer_content\";s:0:\"\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:8:\"pav_desc\";s:13:\"layer_caption\";s:95:\"Lorem isum dolor sit amet consectetur dipiscing elituce &lt;br&gt; non massa sit amet vehicula \";s:15:\"layer_animation\";s:3:\"lfb\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"207\";s:10:\"layer_left\";s:3:\"602\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltb\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"2400\";}i:4;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:5;s:13:\"layer_content\";s:0:\"\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:16:\"pav-button-layer\";s:13:\"layer_caption\";s:46:\"&lt;a href=&quot;#&quot;&gt;Shop now&lt;/a&gt;\";s:15:\"layer_animation\";s:3:\"lft\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"290\";s:10:\"layer_left\";s:3:\"808\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltl\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"1462\";}}}', 'data/demo/bg-slider-2.png', 1, 0),
(17, 'Banner Book 5', 0, 3, 'a:16:{s:2:\"id\";s:2:\"17\";s:15:\"slider_group_id\";s:1:\"3\";s:12:\"slider_title\";s:13:\"Banner Book 5\";s:13:\"slider_status\";s:1:\"1\";s:17:\"slider_transition\";s:6:\"random\";s:11:\"slider_slot\";s:1:\"7\";s:15:\"slider_rotation\";s:1:\"0\";s:15:\"slider_duration\";s:3:\"300\";s:12:\"slider_delay\";s:1:\"0\";s:11:\"slider_link\";s:0:\"\";s:16:\"slider_thumbnail\";s:0:\"\";s:15:\"slider_usevideo\";s:1:\"0\";s:14:\"slider_videoid\";s:0:\"\";s:16:\"slider_videoplay\";s:1:\"0\";s:9:\"slider_id\";s:2:\"17\";s:12:\"slider_image\";s:25:\"data/demo/bg-slider-5.png\";}', 'O:8:\"stdClass\":1:{s:6:\"layers\";a:5:{i:0;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:1;s:13:\"layer_content\";s:28:\"data/demo/banner_sandals.png\";s:10:\"layer_type\";s:5:\"image\";s:11:\"layer_class\";s:0:\"\";s:13:\"layer_caption\";s:17:\"Your Image Here 1\";s:15:\"layer_animation\";s:4:\"fade\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"-2\";s:10:\"layer_left\";s:2:\"46\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:4:\"auto\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:3:\"400\";}i:1;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:2;s:13:\"layer_content\";s:28:\"data/demo/banner_sandals.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:9:\"pav_small\";s:13:\"layer_caption\";s:12:\"Donec metus \";s:15:\"layer_animation\";s:3:\"lfb\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"67\";s:10:\"layer_left\";s:3:\"660\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:4:\"auto\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:3:\"800\";}i:2;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:3;s:13:\"layer_content\";s:28:\"data/demo/banner_sandals.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:7:\"pav_big\";s:13:\"layer_caption\";s:5:\"OFFER\";s:15:\"layer_animation\";s:3:\"lfl\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"133\";s:10:\"layer_left\";s:3:\"704\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltr\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"1200\";}i:3;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:4;s:13:\"layer_content\";s:28:\"data/demo/banner_sandals.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:14:\"pav_desc_white\";s:13:\"layer_caption\";s:96:\"Lorem isum dolor sit amet consectetur dipiscing &lt;br/&gt; elituce non massa sit amet vehicula \";s:15:\"layer_animation\";s:3:\"lft\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"210\";s:10:\"layer_left\";s:3:\"639\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltt\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"1600\";}i:4;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:5;s:13:\"layer_content\";s:28:\"data/demo/banner_sandals.png\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:16:\"pav-button-layer\";s:13:\"layer_caption\";s:46:\"&lt;a href=&quot;#&quot;&gt;Shop now&lt;/a&gt;\";s:15:\"layer_animation\";s:3:\"lfr\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"284\";s:10:\"layer_left\";s:3:\"805\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:3:\"ltr\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"1546\";}}}', 'data/demo/bg-slider-5.png', 1, 0),
(16, 'Banner Book 4', 0, 3, 'a:16:{s:2:\"id\";s:2:\"16\";s:15:\"slider_group_id\";s:1:\"3\";s:12:\"slider_title\";s:13:\"Banner Book 4\";s:13:\"slider_status\";s:1:\"1\";s:17:\"slider_transition\";s:6:\"random\";s:11:\"slider_slot\";s:1:\"7\";s:15:\"slider_rotation\";s:1:\"0\";s:15:\"slider_duration\";s:3:\"300\";s:12:\"slider_delay\";s:1:\"0\";s:11:\"slider_link\";s:0:\"\";s:16:\"slider_thumbnail\";s:0:\"\";s:15:\"slider_usevideo\";s:1:\"0\";s:14:\"slider_videoid\";s:0:\"\";s:16:\"slider_videoplay\";s:1:\"0\";s:9:\"slider_id\";s:2:\"16\";s:12:\"slider_image\";s:25:\"data/demo/bg-slider-4.png\";}', 'O:8:\"stdClass\":1:{s:6:\"layers\";a:3:{i:0;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:1;s:13:\"layer_content\";s:0:\"\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:9:\"pav_small\";s:13:\"layer_caption\";s:11:\"Donec metus\";s:15:\"layer_animation\";s:4:\"fade\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:2:\"53\";s:10:\"layer_left\";s:2:\"84\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:4:\"auto\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:3:\"800\";}i:1;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:2;s:13:\"layer_content\";s:0:\"\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:7:\"pav_big\";s:13:\"layer_caption\";s:5:\"OFFER\";s:15:\"layer_animation\";s:4:\"fade\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"113\";s:10:\"layer_left\";s:2:\"84\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:4:\"auto\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"1200\";}i:2;a:20:{s:16:\"layer_video_type\";s:7:\"youtube\";s:14:\"layer_video_id\";s:0:\"\";s:18:\"layer_video_height\";s:3:\"200\";s:17:\"layer_video_width\";s:3:\"300\";s:17:\"layer_video_thumb\";s:0:\"\";s:8:\"layer_id\";i:3;s:13:\"layer_content\";s:0:\"\";s:10:\"layer_type\";s:4:\"text\";s:11:\"layer_class\";s:8:\"pav_desc\";s:13:\"layer_caption\";s:95:\"Lorem isum dolor sit amet consectetur dipiscing&lt;br/&gt; elituce non massa sit amet vehicula \";s:15:\"layer_animation\";s:4:\"fade\";s:12:\"layer_easing\";s:11:\"easeOutExpo\";s:11:\"layer_speed\";s:3:\"350\";s:9:\"layer_top\";s:3:\"194\";s:10:\"layer_left\";s:2:\"85\";s:13:\"layer_endtime\";s:1:\"0\";s:14:\"layer_endspeed\";s:3:\"300\";s:18:\"layer_endanimation\";s:4:\"auto\";s:15:\"layer_endeasing\";s:7:\"nothing\";s:10:\"time_start\";s:4:\"1600\";}}}', 'data/demo/bg-slider-4.png', 1, 0);
"; 


$query['pavmegamenu'][]  = "DROP TABLE IF EXISTS `".DB_PREFIX ."megamenu`; ";
$query['pavmegamenu'][]  = "DROP TABLE IF EXISTS `".DB_PREFIX ."megamenu_description`; ";

$query['pavmegamenu'][]  = "	
CREATE TABLE `".DB_PREFIX ."megamenu` (
`megamenu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`image` varchar(255) NOT NULL DEFAULT '',
`parent_id` int(11) NOT NULL DEFAULT '0',
`is_group` smallint(6) NOT NULL DEFAULT '2',
`width` varchar(255) DEFAULT NULL,
`submenu_width` varchar(255) DEFAULT NULL,
`colum_width` varchar(255) DEFAULT NULL,
`submenu_colum_width` varchar(255) DEFAULT NULL,
`item` varchar(255) DEFAULT NULL,
`colums` varchar(255) DEFAULT '1',
`type` varchar(255) NOT NULL,
`is_content` smallint(6) NOT NULL DEFAULT '2',
`show_title` smallint(6) NOT NULL DEFAULT '1',
`type_submenu` varchar(10) NOT NULL DEFAULT '1',
`level_depth` smallint(6) NOT NULL DEFAULT '0',
`published` smallint(6) NOT NULL DEFAULT '1',
`store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
`position` int(11) unsigned NOT NULL DEFAULT '0',
`show_sub` smallint(6) NOT NULL DEFAULT '0',
`url` varchar(255) DEFAULT NULL,
`target` varchar(25) DEFAULT NULL,
`privacy` smallint(5) unsigned NOT NULL DEFAULT '0',
`position_type` varchar(25) DEFAULT 'top',
`menu_class` varchar(25) DEFAULT NULL,
`description` text,
`content_text` text,
`submenu_content` text,
`level` int(11) NOT NULL,
`left` int(11) NOT NULL,
`right` int(11) NOT NULL,
PRIMARY KEY (`megamenu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;				
";

$query['pavmegamenu'][]  = "	
CREATE TABLE `".DB_PREFIX ."megamenu_description` (
`megamenu_id` int(11) NOT NULL,
`language_id` int(11) NOT NULL,
`title` varchar(255) NOT NULL,
`description` text NOT NULL,
PRIMARY KEY (`megamenu_id`,`language_id`),
KEY `name` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
	
$query['pavmegamenu'][] = "
INSERT INTO `".DB_PREFIX ."megamenu` (`megamenu_id`, `image`, `parent_id`, `is_group`, `width`, `submenu_width`, `colum_width`, `submenu_colum_width`, `item`, `colums`, `type`, `is_content`, `show_title`, `type_submenu`, `level_depth`, `published`, `store_id`, `position`, `show_sub`, `url`, `target`, `privacy`, `position_type`, `menu_class`, `description`, `content_text`, `submenu_content`, `level`, `left`, `right`) VALUES
(1, '', 0, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 0, 0, NULL, NULL, 0, 'top', NULL, NULL, NULL, NULL, -5, 34, 47),
(2, '', 1, 0, NULL, NULL, NULL, 'col1=3 col2=3 col3=6', '25', '4', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(3, '', 1, 0, NULL, NULL, NULL, 'col1=3, col2=3, col3=3,col4=3', '20', '4', 'category', 0, 1, 'menu', 0, 1, 0, 99, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(5, '', 1, 0, NULL, NULL, NULL, '', '33', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', 'single', NULL, '', '', 0, 0, 0),
(7, '', 1, 0, NULL, NULL, NULL, '', '34', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(8, '', 2, 1, NULL, NULL, NULL, '', '40', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '&lt;p&gt;test&lt;/p&gt;\r\n', 0, 0, 0),
(9, '', 2, 1, NULL, NULL, NULL, '', '43', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(10, '', 8, 0, NULL, NULL, NULL, '', '46', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(11, '', 8, 0, NULL, NULL, NULL, '', '31', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(12, '', 8, 0, NULL, NULL, NULL, '', '66', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(13, '', 8, 0, NULL, NULL, NULL, '', '65', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(14, '', 8, 0, NULL, NULL, NULL, '', '45', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(15, '', 8, 0, NULL, NULL, NULL, '', '29', '1', 'category', 0, 1, 'menu', 0, 1, 0, 8, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(16, '', 8, 0, NULL, NULL, NULL, '', '70', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(17, '', 9, 0, NULL, NULL, NULL, '', '56', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(18, '', 9, 0, NULL, NULL, NULL, '', '54', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(19, '', 9, 0, NULL, NULL, NULL, '', '60', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(20, '', 9, 0, NULL, NULL, NULL, '', '68', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(21, '', 9, 0, NULL, NULL, NULL, '', '63', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(22, '', 9, 0, NULL, NULL, NULL, '', '61', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(23, '', 9, 0, NULL, NULL, NULL, '', '62', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(24, '', 2, 0, NULL, NULL, NULL, '', '', '1', 'html', 1, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '&lt;div class=&quot;pav-menu-video&quot;&gt;\r\n&lt;p&gt;&lt;embed height=&quot;200&quot; src=&quot;http://youtube.com/v/bIxfYHFGX34&quot; type=&quot;application/x-shockwave-flash&quot; width=&quot;400&quot;&gt;&lt;/embed&gt;&lt;/p&gt;\r\n\r\n&lt;h3&gt;Dorem ipsum dolor sit amet consectetur&lt;/h3&gt;\r\n\r\n&lt;p&gt;Dorem ipsum dolor sit amet consectetur adipiscing elit congue sit amet erat roin tincidunt vehicula lorem in adipiscing urna iaculis vel.&lt;/p&gt;\r\n&lt;/div&gt;\r\n', '', 0, 0, 0),
(29, '', 56, 0, NULL, NULL, NULL, '', '29', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(31, '', 56, 0, NULL, NULL, NULL, '', '69', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(32, '', 56, 0, NULL, NULL, NULL, '', '28', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(33, '', 56, 0, NULL, NULL, NULL, '', '32', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(34, '', 56, 0, NULL, NULL, NULL, '', '30', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(35, '', 56, 0, NULL, NULL, NULL, '', '45', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(36, '', 56, 0, NULL, NULL, NULL, '', '36', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(40, '', 1, 0, NULL, NULL, NULL, '', '', '1', 'url', 0, 1, 'menu', 0, 1, 0, 1, 0, '?route=common/home', NULL, 0, 'top', 'home', NULL, '', '', 0, 0, 0),
(41, '', 5, 0, NULL, NULL, NULL, '', '30', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(42, '', 5, 0, NULL, NULL, NULL, '', '47', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(43, '', 5, 0, NULL, NULL, NULL, '', '39', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(44, '', 5, 0, NULL, NULL, NULL, '', '32', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(45, '', 5, 0, NULL, NULL, NULL, '', '48', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(46, '', 5, 0, NULL, NULL, NULL, '', '42', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(48, '', 1, 0, NULL, NULL, NULL, '', '18', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(49, '', 8, 0, NULL, NULL, NULL, '', '32', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(50, '', 9, 0, NULL, NULL, NULL, '', '69', '1', 'category', 0, 1, 'menu', 0, 1, 0, 8, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(51, '', 52, 0, NULL, NULL, NULL, '', '69', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(53, '', 52, 0, NULL, NULL, NULL, '', '35', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(54, '', 52, 0, NULL, NULL, NULL, '', '53', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(55, '', 57, 0, NULL, NULL, NULL, '', '46', '1', 'product', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(56, '', 3, 1, NULL, NULL, NULL, '', '55', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(57, '', 3, 1, NULL, NULL, NULL, '', '60', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(58, '', 57, 0, NULL, NULL, NULL, '', '35', '1', 'product', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(59, '', 57, 0, NULL, NULL, NULL, '', '43', '1', 'product', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(60, '', 57, 0, NULL, NULL, NULL, '', '51', '1', 'product', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(61, '', 57, 0, NULL, NULL, NULL, '', '28', '1', 'product', 0, 1, 'menu', 0, 1, 0, 99, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(62, '', 57, 0, NULL, NULL, NULL, '', '42', '1', 'product', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(63, '', 57, 0, NULL, NULL, NULL, '', '45', '1', 'product', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(65, '', 3, 0, NULL, NULL, NULL, '', '', '1', 'html', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', '', NULL, '&lt;p&gt;&lt;img alt=&quot;System Z906&quot; src=&quot;image/data/demo/submenu_01.png&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Assumenda, quos quis labore maxime quasi sed quisquam quibusdam odit minus atque, nec convallis leo erat a nunc&lt;/p&gt;\r\n', '', 0, 0, 0),
(68, '', 67, 0, NULL, NULL, NULL, '', '35', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(69, '', 67, 0, NULL, NULL, NULL, '', '31', '1', 'category', 0, 1, 'menu', 0, 1, 0, 99, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(70, '', 3, 1, NULL, NULL, NULL, '', '70', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(71, '', 70, 0, NULL, NULL, NULL, '', '35', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(72, '', 70, 0, NULL, NULL, NULL, '', '31', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(73, '', 70, 0, NULL, NULL, NULL, '', '26', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(74, '', 70, 0, NULL, NULL, NULL, '', '67', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(75, '', 70, 0, NULL, NULL, NULL, '', '69', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(76, '', 70, 0, NULL, NULL, NULL, '', '62', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(77, '', 70, 0, NULL, NULL, NULL, '', '27', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(78, '', 1, 0, NULL, NULL, NULL, '', '', '1', 'url', 0, 1, 'menu', 0, 1, 0, 7, 0, 'index.php?route=pavblog/blogs', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(79, '', 5, 0, NULL, NULL, NULL, '', '50', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(80, '', 52, 0, NULL, NULL, NULL, '', '58', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(81, '', 52, 0, NULL, NULL, NULL, '', '53', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(82, '', 52, 0, NULL, NULL, NULL, '', '', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(83, '', 52, 0, NULL, NULL, NULL, '', '39', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(84, '', 52, 0, NULL, NULL, NULL, '', '50', '1', 'category', 0, 1, 'menu', 0, 1, 0, 8, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0);
";
	
$query['pavmegamenu'][] = "	
INSERT INTO `".DB_PREFIX ."megamenu_description` (`megamenu_id`, `language_id`, `title`, `description`) VALUES
(11, 1, 'Graphic Novels', ''),
(20, 1, 'Wallets', 'Sale'),
(41, 1, 'Music', ''),
(2, 1, 'Books', ''),
(8, 1, 'Action ', ''),
(8, 7, 'Action &amp; Adventure', ''),
(9, 1, 'Horror', ''),
(16, 7, 'Crafts &amp; Hobbies', ''),
(10, 7, 'Classics', ''),
(10, 1, 'Classics', ''),
(16, 1, 'Crafts &amp; Hobbies', ''),
(15, 1, 'Fantasy', 'New'),
(14, 7, 'Cooking, Food &amp; Wine', ''),
(14, 1, 'Cooking, Food', ''),
(13, 7, 'Erotica', ''),
(13, 1, 'Erotica', ''),
(12, 7, 'Computers &amp; Technology', ''),
(12, 1, 'Computers', ''),
(17, 7, 'Travel', ''),
(17, 1, 'Travel', ''),
(23, 1, 'Bags &amp; business', ''),
(18, 7, 'True Crime', ''),
(18, 1, 'True Crime', ''),
(72, 1, 'Scanners', 'promotion 5%'),
(19, 7, 'Accessories', ''),
(19, 1, 'Accessories', ''),
(23, 7, 'Bags &amp; business', ''),
(21, 7, 'Shoes', ''),
(21, 1, 'Shoes', ''),
(22, 7, 'Watches', 'sale'),
(40, 7, 'Home', ''),
(40, 1, 'Home', ''),
(36, 7, 'Dresses', ''),
(36, 1, 'Dresses', ''),
(35, 7, 'Evening', ''),
(35, 1, 'Evening', ''),
(34, 7, 'Sunglasses', ''),
(34, 1, 'Sunglasses', ''),
(33, 7, 'Web Cameras', ''),
(33, 1, 'Web Cameras', ''),
(32, 7, 'Shoes', ''),
(32, 1, 'Shoes', ''),
(29, 7, 'Handbags', ''),
(29, 1, 'Handbags', ''),
(7, 7, 'Magazines', ''),
(9, 7, 'Horror', ''),
(24, 1, 'Custom HTML', ''),
(41, 7, 'Music', ''),
(79, 1, 'Education', ''),
(42, 7, 'Games', ''),
(42, 1, 'Games', ''),
(43, 7, 'Occult', ''),
(43, 1, 'Occult', ''),
(44, 7, 'Children''s Series', ''),
(44, 1, 'Children''s Series', ''),
(79, 7, 'Education', ''),
(45, 7, 'Anthologies', ''),
(45, 1, 'Anthologies', ''),
(46, 7, 'Study Aids', ''),
(46, 1, 'Study Aids', ''),
(11, 7, 'Graphic Novels', ''),
(31, 7, 'Sollemnes', ''),
(31, 1, 'Sollemnes', ''),
(5, 7, 'Nook Books ', ''),
(7, 1, 'Magazines', ''),
(80, 1, 'Social Science', ''),
(53, 7, 'Evening', ''),
(48, 1, 'Audiobooks', ''),
(48, 7, 'Audiobooks', ''),
(2, 7, 'Books', ''),
(78, 7, 'Blog', ''),
(78, 1, 'Blog', ''),
(49, 1, 'Current Events', ''),
(50, 1, 'Sollemnes', ''),
(50, 7, 'Sollemnes', ''),
(24, 7, 'Custom HTML', ''),
(51, 7, 'Romance', ''),
(51, 1, 'Romance', ''),
(22, 1, 'Watches', ''),
(20, 7, 'Wallets', ''),
(53, 1, 'Evening', ''),
(54, 1, 'Westerns', ''),
(55, 1, 'Sony VAIO', ''),
(55, 7, 'Sony VAIO', ''),
(5, 1, 'Nook Books ', ''),
(80, 7, 'Social Science', ''),
(56, 1, 'Science Fiction', ''),
(57, 1, 'Accessories', ''),
(57, 7, 'Accessories', ''),
(56, 7, 'Science Fiction', ''),
(58, 1, 'Samsung galaxy note 2', ''),
(58, 7, 'Samsung galaxy note 2', ''),
(59, 7, 'MacBook', ''),
(59, 1, 'MacBook', ''),
(60, 1, 'Beatae esse dignissimos', ''),
(60, 7, 'Beatae esse dignissimos', ''),
(15, 7, 'Fantasy', ''),
(61, 7, 'HTC Touch HD', ''),
(61, 1, 'HTC Touch HD', ''),
(62, 7, 'Apple Cinema 30', ''),
(62, 1, 'Apple Cinema 30', ''),
(63, 7, 'MacBook Pro', ''),
(63, 1, 'MacBook Pro', ''),
(65, 1, 'Custom HTML 1', ''),
(65, 7, 'Custom HTML 1', ''),
(3, 7, 'Textbooks', ''),
(70, 7, 'Mobiles', 'New'),
(70, 1, 'Mobiles', ''),
(68, 6, 'Evening', ''),
(68, 4, 'Evening', ''),
(68, 1, 'Evening', ''),
(69, 6, 'Scanners', ''),
(69, 4, 'Scanners', ''),
(69, 1, 'Scanners', ''),
(71, 7, 'Evening', ''),
(71, 1, 'Evening', ''),
(72, 7, 'Scanners', ''),
(73, 1, 'Formal wear', ''),
(73, 7, 'Formal wear', ''),
(74, 7, 'Accessories', ''),
(74, 1, 'Accessories', ''),
(75, 1, 'Sollemnes', ''),
(75, 7, 'Sollemnes', ''),
(76, 1, 'Bags &amp; business', ''),
(76, 7, 'Bags &amp; business', ''),
(77, 1, 'Silver jewelry', ''),
(77, 7, 'Silver jewelry', ''),
(81, 1, 'Westerns', ''),
(49, 7, 'Current Events', ''),
(54, 7, 'Westerns', ''),
(81, 7, 'Westerns', ''),
(82, 1, 'Religious', ''),
(82, 7, 'Religious', ''),
(83, 1, 'Occult', ''),
(83, 7, 'Occult', ''),
(84, 1, 'Education', ''),
(84, 7, 'Education', ''),
(3, 1, 'Textbooks', '');
";



$query['pavblog'][]  = "  DROP TABLE IF EXISTS `".DB_PREFIX ."pavblog_blog`; ";
$query['pavblog'][]  = "   DROP TABLE IF EXISTS `".DB_PREFIX ."pavblog_blog_description`; ";
$query['pavblog'][]  = "  DROP TABLE IF EXISTS `".DB_PREFIX ."pavblog_category`; ";
$query['pavblog'][]  = "   DROP TABLE IF EXISTS `".DB_PREFIX ."pavblog_category_description`; ";
$query['pavblog'][]  = "   DROP TABLE IF EXISTS `".DB_PREFIX ."pavblog_comment`; ";


$query['pavblog'][]  = "
CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."pavblog_blog` (
`blog_id` int(11) NOT NULL AUTO_INCREMENT,
`category_id` int(11) NOT NULL,
`position` int(11) NOT NULL,
`created` date NOT NULL,
`status` tinyint(1) NOT NULL,
`user_id` int(11) NOT NULL,
`hits` int(11) NOT NULL,
`image` varchar(255) NOT NULL,
`meta_keyword` varchar(255) NOT NULL,
`meta_description` varchar(255) NOT NULL,
`meta_title` varchar(255) NOT NULL,
`date_modified` date NOT NULL,
`video_code` varchar(255) NOT NULL,
`params` text NOT NULL,
`tags` varchar(255) NOT NULL,
`featured` tinyint(1) NOT NULL,
`keyword` varchar(255) NOT NULL,
PRIMARY KEY (`blog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;
";			
			

$query['pavblog'][] ="
INSERT INTO `".DB_PREFIX ."pavblog_blog` (`blog_id`, `category_id`, `position`, `created`, `status`, `user_id`, `hits`, `image`, `meta_keyword`, `meta_description`, `meta_title`, `date_modified`, `video_code`, `params`, `tags`, `featured`, `keyword`) VALUES
(7, 21, 2, '2013-03-09', 1, 1, 49, 'data/pavblog/pav-i1.jpg', '', '', '', '2013-08-01', '', '', 'joomla, prestashop, magento', 1, ''),
(9, 21, 1, '2013-03-09', 1, 1, 87, 'data/pavblog/pav-c3.jpg', '', '', '', '2013-08-01', '', '', 'prestashop, magento, opencart', 0, ''),
(10, 21, 3, '2013-03-09', 1, 1, 243, 'data/pavblog/pav-c2.jpg', 'test test', '', 'Custom SEO Titlte', '2013-08-01', '', '', 'prestashop, magento, opencart', 0, ''),
(11, 21, 4, '2013-03-11', 1, 1, 104, 'data/pavblog/pav-c4.jpg', '', '', '', '2013-08-01', '', '', 'opencart', 0, ''),
(12, 1, 5, '2013-07-30', 1, 1, 1, 'data/pavblog/pav-c4.jpg', '', '', '', '2013-08-01', '', '', 'prestashop, magento, opencart', 0, 'opencart, magento, drupal'),
(13, 21, 6, '2013-07-30', 1, 1, 83, 'data/pavblog/pav-c3.jpg', '', '', '', '2013-08-01', '', '', 'joomla, prestashop, magento', 1, 'opencart, magento, drupal');
"; 				


$query['pavblog'][]  = "	
CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."pavblog_blog_description` (
`blog_id` int(11) NOT NULL,
`language_id` int(11) NOT NULL,
`title` varchar(255) NOT NULL,
`description` text NOT NULL,
`content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";



$query['pavblog'][] ="


INSERT INTO `".DB_PREFIX ."pavblog_blog_description` (`blog_id`, `language_id`, `title`, `description`, `content`) VALUES
(7, 1, 'Ac tincidunt Suspendisse malesuada', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, minima, culpa, sint maxime nisi voluptas necessitatibus tempora reiciendis ab et recusandae rerum ipsa qui eligendi earum reprehenderit laborum eum iste est perspiciatis velit ratione animi nihil harum laudantium&lt;/p&gt;\r\n', '&lt;div class=&quot;itemFullText&quot;&gt;\r\n&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n&lt;/div&gt;\r\n'),
(7, 7, 'Ac tincidunt Suspendisse malesuada', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, minima, culpa, sint maxime nisi voluptas necessitatibus tempora reiciendis ab et recusandae rerum ipsa qui eligendi earum reprehenderit laborum eum iste est perspiciatis velit ratione animi nihil harum laudantium&lt;/p&gt;\r\n', '&lt;div class=&quot;itemFullText&quot;&gt;\r\n&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n&lt;/div&gt;\r\n'),
(9, 1, 'Commodo laoreet semper tincidunt lorem ', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, minima, culpa, sint maxime nisi voluptas necessitatibus tempora reiciendis ab et recusandae rerum ipsa qui eligendi earum reprehenderit laborum eum iste est perspiciatis velit ratione animi nihil harum laudantium hic sit sequi&amp;nbsp;&lt;/p&gt;\r\n', '&lt;div class=&quot;itemFullText&quot;&gt;\r\n&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n&lt;/div&gt;\r\n'),
(9, 7, 'Commodo laoreet semper tincidunt lorem ', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, minima, culpa, sint maxime nisi voluptas necessitatibus tempora reiciendis ab et recusandae rerum ipsa qui eligendi earum reprehenderit laborum eum iste est perspiciatis velit ratione animi nihil harum laudantium hic sit sequi&amp;nbsp;&lt;/p&gt;\r\n', '&lt;div class=&quot;itemFullText&quot;&gt;\r\n&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n&lt;/div&gt;\r\n'),
(10, 1, 'Donec tempus sagittis consectetur', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, minima, culpa, sint maxime nisi voluptas necessitatibus tempora reiciendis ab et recusandae rerum ipsa qui eligendi earum reprehenderit laborum eum iste est perspiciatis velit ratione animi nihil harum laudantium&lt;/p&gt;\r\n', '&lt;p&gt;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&lt;/p&gt;\r\n'),
(10, 7, 'Donec tempus sagittis consectetur', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, minima, culpa, sint maxime nisi voluptas necessitatibus tempora reiciendis ab et recusandae rerum ipsa qui eligendi earum reprehenderit laborum eum iste est perspiciatis velit ratione animi nihil harum laudantium&lt;/p&gt;\r\n', '&lt;p&gt;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&lt;/p&gt;\r\n'),
(11, 1, 'Consectetur adipisicing elit', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, minima, culpa, sint maxime nisi voluptas necessitatibus tempora reiciendis ab et recusandae rerum ipsa qui eligendi earum reprehenderit laborum eum iste est perspiciatis velit ratione animi nihil harum laudantium&lt;/p&gt;\r\n', '&lt;div class=&quot;itemFullText&quot;&gt;\r\n&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n&lt;/div&gt;\r\n'),
(11, 7, 'Consectetur adipisicing elit', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, minima, culpa, sint maxime nisi voluptas necessitatibus tempora reiciendis ab et recusandae rerum ipsa qui eligendi earum reprehenderit laborum eum iste est perspiciatis velit ratione animi nihil harum laudantium&lt;/p&gt;\r\n', '&lt;div class=&quot;itemFullText&quot;&gt;\r\n&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n&lt;/div&gt;\r\n'),
(12, 1, 'Amet qui consequatur placeat magnam', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum, totam quia provident voluptates eveniet voluptas quae deserunt consequatur aspernatur distinctio? Voluptatum, vitae, in minima nam aspernatur fugit fugiat autem laborum veniam quos necessitatibus magni ducimus porro architecto cupiditate ratione officiis. Dolore, dicta, inventore, nesciunt facilis in perferendis sint accusamus amet qui consequatur placeat magnam molestias blanditiis libero ullam ducimus odio quam dolorem. Harum, possimus asperiores consequuntur incidunt quo iure perferendis nobis exercitationem voluptatibus eveniet repellat sapiente mollitia error id dignissimos recusandae nihil similique pariatur unde dolore nostrum rerum esse necessitatibus accusantium neque reiciendis laudantium ratione nesciunt natus laborum ab quidem magni vero?&lt;/p&gt;\r\n\r\n&lt;p&gt;Aliquid, iste, temporibus, neque est et sed in quasi ad tenetur officia libero deleniti nulla fugiat esse ipsum fuga quibusdam facilis repellendus pariatur accusamus enim! Inventore vitae officiis accusamus. Iste, minus porro numquam eligendi inventore illum deserunt alias. Dolorem, quam, pariatur molestias ea natus distinctio veniam maiores! In, optio, quae sint commodi saepe labore necessitatibus eaque ab explicabo fugit delectus alias aliquid quos laborum cumque doloribus autem. Tenetur, omnis, officiis possimus a ex vitae ducimus ratione consectetur pariatur sed vel deleniti nihil neque eaque ad laborum optio culpa architecto quo harum.&lt;/p&gt;\r\n\r\n&lt;p&gt;Quasi, laboriosam, voluptatem quis adipisci distinctio totam aliquam esse facere? Ratione, unde, recusandae obcaecati reiciendis alias quia odit dolore perferendis autem nobis dignissimos aspernatur accusantium quasi distinctio omnis similique quidem minus consectetur officiis beatae! Illum, temporibus, saepe vero ipsum porro officiis laborum iure velit obcaecati atque. Quis, quas, provident, debitis voluptate architecto laudantium ullam similique sequi aspernatur voluptatibus ad ipsa deserunt explicabo sapiente possimus incidunt fuga aperiam consectetur dolores culpa porro quia magnam maxime dicta nulla praesentium eveniet exercitationem hic molestias qui autem facilis numquam expedita. Accusamus, aliquam consequuntur et autem facere nulla necessitatibus illum non iusto voluptas nesciunt esse repellat cupiditate? Magni quo natus omnis minima?&lt;/p&gt;\r\n'),
(12, 7, 'Amet qui consequatur placeat magnam', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum, totam quia provident voluptates eveniet voluptas quae deserunt consequatur aspernatur distinctio? Voluptatum, vitae, in minima nam aspernatur fugit fugiat autem laborum veniam quos necessitatibus magni ducimus porro architecto cupiditate ratione officiis. Dolore, dicta, inventore, nesciunt facilis in perferendis sint accusamus amet qui consequatur placeat magnam molestias blanditiis libero ullam ducimus odio quam dolorem. Harum, possimus asperiores consequuntur incidunt quo iure perferendis nobis exercitationem voluptatibus eveniet repellat sapiente mollitia error id dignissimos recusandae nihil similique pariatur unde dolore nostrum rerum esse necessitatibus accusantium neque reiciendis laudantium ratione nesciunt natus laborum ab quidem magni vero?&lt;/p&gt;\r\n\r\n&lt;p&gt;Aliquid, iste, temporibus, neque est et sed in quasi ad tenetur officia libero deleniti nulla fugiat esse ipsum fuga quibusdam facilis repellendus pariatur accusamus enim! Inventore vitae officiis accusamus. Iste, minus porro numquam eligendi inventore illum deserunt alias. Dolorem, quam, pariatur molestias ea natus distinctio veniam maiores! In, optio, quae sint commodi saepe labore necessitatibus eaque ab explicabo fugit delectus alias aliquid quos laborum cumque doloribus autem. Tenetur, omnis, officiis possimus a ex vitae ducimus ratione consectetur pariatur sed vel deleniti nihil neque eaque ad laborum optio culpa architecto quo harum.&lt;/p&gt;\r\n\r\n&lt;p&gt;Quasi, laboriosam, voluptatem quis adipisci distinctio totam aliquam esse facere? Ratione, unde, recusandae obcaecati reiciendis alias quia odit dolore perferendis autem nobis dignissimos aspernatur accusantium quasi distinctio omnis similique quidem minus consectetur officiis beatae! Illum, temporibus, saepe vero ipsum porro officiis laborum iure velit obcaecati atque. Quis, quas, provident, debitis voluptate architecto laudantium ullam similique sequi aspernatur voluptatibus ad ipsa deserunt explicabo sapiente possimus incidunt fuga aperiam consectetur dolores culpa porro quia magnam maxime dicta nulla praesentium eveniet exercitationem hic molestias qui autem facilis numquam expedita. Accusamus, aliquam consequuntur et autem facere nulla necessitatibus illum non iusto voluptas nesciunt esse repellat cupiditate? Magni quo natus omnis minima?&lt;/p&gt;\r\n'),
(13, 1, 'Reprehenderit quaerat accusamus', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum, totam quia provident voluptates eveniet voluptas quae deserunt consequatur aspernatur distinctio? Voluptatum, vitae, in minima nam aspernatur fugit fugiat autem laborum veniam quos necessitatibus magni ducimus porro architecto cupiditate ratione officiis. Dolore, dicta, inventore, nesciunt facilis in perferendis sint accusamus amet qui consequatur placeat magnam molestias blanditiis libero ullam ducimus odio quam dolorem. Harum, possimus asperiores consequuntur incidunt quo iure perferendis nobis exercitationem voluptatibus eveniet repellat sapiente mollitia error id dignissimos recusandae nihil similique pariatur unde dolore nostrum rerum esse necessitatibus accusantium neque reiciendis laudantium ratione nesciunt natus laborum ab quidem magni vero?&lt;/p&gt;\r\n\r\n&lt;p&gt;Aliquid, iste, temporibus, neque est et sed in quasi ad tenetur officia libero deleniti nulla fugiat esse ipsum fuga quibusdam facilis repellendus pariatur accusamus enim! Inventore vitae officiis accusamus. Iste, minus porro numquam eligendi inventore illum deserunt alias. Dolorem, quam, pariatur molestias ea natus distinctio veniam maiores! In, optio, quae sint commodi saepe labore necessitatibus eaque ab explicabo fugit delectus alias aliquid quos laborum cumque doloribus autem. Tenetur, omnis, officiis possimus a ex vitae ducimus ratione consectetur pariatur sed vel deleniti nihil neque eaque ad laborum optio culpa architecto quo harum.&lt;/p&gt;\r\n\r\n&lt;p&gt;Quasi, laboriosam, voluptatem quis adipisci distinctio totam aliquam esse facere? Ratione, unde, recusandae obcaecati reiciendis alias quia odit dolore perferendis autem nobis dignissimos aspernatur accusantium quasi distinctio omnis similique quidem minus consectetur officiis beatae! Illum, temporibus, saepe vero ipsum porro officiis laborum iure velit obcaecati atque. Quis, quas, provident, debitis voluptate architecto laudantium ullam similique sequi aspernatur voluptatibus ad ipsa deserunt explicabo sapiente possimus incidunt fuga aperiam consectetur dolores culpa porro quia magnam maxime dicta nulla praesentium eveniet exercitationem hic molestias qui autem facilis numquam expedita. Accusamus, aliquam consequuntur et autem facere nulla necessitatibus illum non iusto voluptas nesciunt esse repellat cupiditate? Magni quo natus omnis minima?&lt;/p&gt;\r\n'),
(13, 7, 'Reprehenderit quaerat accusamus', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum, totam quia provident voluptates eveniet voluptas quae deserunt consequatur aspernatur distinctio? Voluptatum, vitae, in minima nam aspernatur fugit fugiat autem laborum veniam quos necessitatibus magni ducimus porro architecto cupiditate ratione officiis. Dolore, dicta, inventore, nesciunt facilis in perferendis sint accusamus amet qui consequatur placeat magnam molestias blanditiis libero ullam ducimus odio quam dolorem. Harum, possimus asperiores consequuntur incidunt quo iure perferendis nobis exercitationem voluptatibus eveniet repellat sapiente mollitia error id dignissimos recusandae nihil similique pariatur unde dolore nostrum rerum esse necessitatibus accusantium neque reiciendis laudantium ratione nesciunt natus laborum ab quidem magni vero?&lt;/p&gt;\r\n\r\n&lt;p&gt;Aliquid, iste, temporibus, neque est et sed in quasi ad tenetur officia libero deleniti nulla fugiat esse ipsum fuga quibusdam facilis repellendus pariatur accusamus enim! Inventore vitae officiis accusamus. Iste, minus porro numquam eligendi inventore illum deserunt alias. Dolorem, quam, pariatur molestias ea natus distinctio veniam maiores! In, optio, quae sint commodi saepe labore necessitatibus eaque ab explicabo fugit delectus alias aliquid quos laborum cumque doloribus autem. Tenetur, omnis, officiis possimus a ex vitae ducimus ratione consectetur pariatur sed vel deleniti nihil neque eaque ad laborum optio culpa architecto quo harum.&lt;/p&gt;\r\n\r\n&lt;p&gt;Quasi, laboriosam, voluptatem quis adipisci distinctio totam aliquam esse facere? Ratione, unde, recusandae obcaecati reiciendis alias quia odit dolore perferendis autem nobis dignissimos aspernatur accusantium quasi distinctio omnis similique quidem minus consectetur officiis beatae! Illum, temporibus, saepe vero ipsum porro officiis laborum iure velit obcaecati atque. Quis, quas, provident, debitis voluptate architecto laudantium ullam similique sequi aspernatur voluptatibus ad ipsa deserunt explicabo sapiente possimus incidunt fuga aperiam consectetur dolores culpa porro quia magnam maxime dicta nulla praesentium eveniet exercitationem hic molestias qui autem facilis numquam expedita. Accusamus, aliquam consequuntur et autem facere nulla necessitatibus illum non iusto voluptas nesciunt esse repellat cupiditate? Magni quo natus omnis minima?&lt;/p&gt;\r\n');

"; 	




$query['pavblog'][]  = "	
CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."pavblog_category` (
`category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`image` varchar(255) NOT NULL DEFAULT '',
`parent_id` int(11) NOT NULL DEFAULT '0',
`is_group` smallint(6) NOT NULL DEFAULT '2',
`width` varchar(255) DEFAULT NULL,
`submenu_width` varchar(255) DEFAULT NULL,
`colum_width` varchar(255) DEFAULT NULL,
`submenu_colum_width` varchar(255) DEFAULT NULL,
`item` varchar(255) DEFAULT NULL,
`colums` varchar(255) DEFAULT '1',
`type` varchar(255) NOT NULL,
`is_content` smallint(6) NOT NULL DEFAULT '2',
`show_title` smallint(6) NOT NULL DEFAULT '1',
`meta_keyword` varchar(255) NOT NULL DEFAULT '1',
`level_depth` smallint(6) NOT NULL DEFAULT '0',
`published` smallint(6) NOT NULL DEFAULT '1',
`store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
`position` int(11) unsigned NOT NULL DEFAULT '0',
`show_sub` smallint(6) NOT NULL DEFAULT '0',
`url` varchar(255) DEFAULT NULL,
`target` varchar(25) DEFAULT NULL,
`privacy` smallint(5) unsigned NOT NULL DEFAULT '0',
`position_type` varchar(25) DEFAULT 'top',
`menu_class` varchar(25) DEFAULT NULL,
`description` text,
`meta_description` text,
`meta_title` varchar(255) DEFAULT NULL,
`level` int(11) NOT NULL,
`left` int(11) NOT NULL,
`right` int(11) NOT NULL,
`keyword` varchar(255) NOT NULL,
PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;
";


$query['pavblog'][] ="
INSERT INTO `".DB_PREFIX ."pavblog_category` (`category_id`, `image`, `parent_id`, `is_group`, `width`, `submenu_width`, `colum_width`, `submenu_colum_width`, `item`, `colums`, `type`, `is_content`, `show_title`, `meta_keyword`, `level_depth`, `published`, `store_id`, `position`, `show_sub`, `url`, `target`, `privacy`, `position_type`, `menu_class`, `description`, `meta_description`, `meta_title`, `level`, `left`, `right`, `keyword`) VALUES
(1, '', 0, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 0, 0, NULL, NULL, 0, 'top', NULL, NULL, NULL, NULL, -5, 34, 47, ''),
(20, 'data/pavblog/pav-c3.jpg', 22, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 3, 0, NULL, NULL, 0, 'top', '', NULL, '', '', 0, 0, 0, 'Mobile '),
(21, 'data/pavblog/pav-c1.jpg', 22, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 1, 0, NULL, NULL, 0, 'top', '', NULL, '', '', 0, 0, 0, 'Miscellaneous '),
(22, 'data/pavblog/blog_books.jpg', 1, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 1, 0, NULL, NULL, 0, 'top', '', NULL, '', '', 0, 0, 0, 'personal'),
(23, 'data/pavblog/pav-c2.jpg', 22, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 2, 0, NULL, NULL, 0, 'top', '', NULL, '', '', 0, 0, 0, 'Technology '),
(24, 'data/pavblog/blog_books.jpg', 1, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 2, 0, NULL, NULL, 0, 'top', '', NULL, '', '', 0, 0, 0, 'E - Commerce'),
(25, '', 1, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '', 0, 1, 0, 99, 0, NULL, NULL, 0, 'top', '', NULL, '', '', 0, 0, 0, 'Corporate '),
(26, '', 1, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '', 0, 1, 0, 99, 0, NULL, NULL, 0, 'top', '', NULL, '', '', 0, 0, 0, 'Creative '),
(27, '', 1, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '', 0, 1, 0, 99, 0, NULL, NULL, 0, 'top', '', NULL, '', '', 0, 0, 0, '');
"; 	


$query['pavblog'][]  = "	
CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."pavblog_category_description` (
`category_id` int(11) NOT NULL,
`language_id` int(11) NOT NULL,
`title` varchar(255) NOT NULL,
`description` text NOT NULL,
PRIMARY KEY (`category_id`,`language_id`),
KEY `name` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";		


$query['pavblog'][] ="
INSERT INTO `".DB_PREFIX ."pavblog_category_description` (`category_id`, `language_id`, `title`, `description`) VALUES
(1, 1, 'ROOT', 'Menu Root'),
(22, 1, 'Personal', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et?&lt;/p&gt;\r\n\r\n&lt;p&gt;Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum&lt;/p&gt;\r\n'),
(24, 1, 'E - Commerce', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum?&lt;/p&gt;\r\n'),
(20, 7, 'Mobile ', '&lt;p&gt;Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis&lt;/p&gt;\r\n'),
(21, 1, 'Miscellaneous ', '&lt;p&gt;Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis&lt;/p&gt;\r\n'),
(23, 1, 'Technology ', '&lt;p&gt;Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis&lt;/p&gt;\r\n'),
(20, 1, 'Mobile ', '&lt;p&gt;Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis&lt;/p&gt;\r\n'),
(22, 7, 'Personal', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et?&lt;/p&gt;\r\n\r\n&lt;p&gt;Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum&lt;/p&gt;\r\n'),
(21, 7, 'Miscellaneous ', '&lt;p&gt;Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis&lt;/p&gt;\r\n'),
(23, 7, 'Technology ', '&lt;p&gt;Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis&lt;/p&gt;\r\n'),
(24, 7, 'E - Commerce', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum?&lt;/p&gt;\r\n'),
(25, 7, 'Corporate ', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum?&lt;/p&gt;\r\n'),
(25, 1, 'Corporate ', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum?&lt;/p&gt;\r\n'),
(26, 7, 'Creative ', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum?&lt;/p&gt;\r\n'),
(26, 1, 'Creative', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum?&lt;/p&gt;\r\n'),
(27, 1, 'Blog &amp; Magazine', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum?&lt;/p&gt;\r\n'),
(27, 7, 'Blog &amp; Magazine', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, molestias, debitis minus animi minima perspiciatis odio repellat distinctio unde eaque obcaecati fuga suscipit dolor quisquam accusantium. Deleniti vel dolorem incidunt perferendis et? Enim, architecto dolor reprehenderit quaerat accusamus placeat commodi culpa temporibus vel nam. Perferendis, voluptatibus iusto quos voluptatum rerum?&lt;/p&gt;\r\n');

"; 	

			
$query['pavblog'][]  = "
CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."pavblog_comment` (
`comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`blog_id` int(11) unsigned NOT NULL,
`comment` text NOT NULL,
`status` tinyint(1) NOT NULL DEFAULT '0',
`created` datetime DEFAULT NULL,
`user` varchar(255) NOT NULL,
`email` varchar(255) NOT NULL,
PRIMARY KEY (`comment_id`),
KEY `FK_blog_comment` (`blog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

";


$query['pavblog'][] ="
INSERT INTO `".DB_PREFIX ."pavblog_comment` (`comment_id`, `blog_id`, `comment`, `status`, `created`, `user`, `email`) VALUES
(6, 10, 'Adipisci, molestias, debitis minus animi minima perspiciatis', 1, '2013-03-12 14:23:09', 'ha cong tien', 'hatuhn@gmail.com'),
(7, 10, 'Adipisci, molestias, debitis minus animi minima perspiciatis', 1, '2013-03-12 14:25:19', 'ha cong tien', 'hatuhn@gmail.com'),
(8, 10, 'Adipisci, molestias, debitis minus animi minima perspiciatis', 1, '2013-03-12 14:30:17', 'Test Test ', 'ngoisao@aa.com');
";

?>