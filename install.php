<?php

/**
 * SPSEO - Simple Search Engine Optimization toolkit for Oxwall platform
 * Copyright (C) 2015 SONGPHI LLC.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$dbPref = OW_DB_PREFIX.'spseo_';
$tblPage = $dbPref.'page';
$tblPageUrls = $dbPref.'page_urls';
$tblUrl = $dbPref.'url';

$installSQL = "CREATE TABLE IF NOT EXISTS `$tblPage` ( 
	`id` INT UNSIGNED AUTO_INCREMENT NOT NULL, 
	`hash` VARCHAR( 32 ) NOT NULL, 
	`uri` VARCHAR( 255 ) NOT NULL, 
	`meta_description` TEXT NULL, 
	`meta_keywords` TEXT NULL,
	 PRIMARY KEY ( `id` )
, 
	CONSTRAINT `unique_hash` UNIQUE( `hash` ), 
	CONSTRAINT `unique_id` UNIQUE( `id` ), 
	CONSTRAINT `unique_uri` UNIQUE( `uri` ) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `$tblPageUrls` ( 
	`id` INT UNSIGNED AUTO_INCREMENT NOT NULL, 
	`page_hash` VARCHAR( 32 ) NOT NULL, 
	`url_hash` VARCHAR( 32 ) NOT NULL, 
	`updated` INT UNSIGNED NOT NULL,
	 PRIMARY KEY ( `page_hash`,`url_hash` )
, 
	CONSTRAINT `unique_id` UNIQUE( `id` ) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `$tblUrl` ( 
	`id` INT UNSIGNED AUTO_INCREMENT NOT NULL, 
	`uri` VARCHAR( 255 ) NOT NULL, 
	`prefix` VARCHAR( 255 ) NULL, 
	`slug` VARCHAR( 255 ) NULL, 
	`friendly_uri` TEXT NULL, 
	`updated` INT UNSIGNED NULL, 
	`target_id` INT UNSIGNED NULL, 
	`hash` VARCHAR( 32 ) NOT NULL,
	 PRIMARY KEY ( `id` )
, 
	CONSTRAINT `unique_id` UNIQUE( `id` ), 
	CONSTRAINT `unique_uri` UNIQUE( `uri` ) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8;
";

OW::getDbo()->query($installSQL);

try {
	OW::getPluginManager()->addPluginSettingsRouteName('spseo', 'spseo.admin');
} catch (Exception $e) { }

try {
	BOL_LanguageService::getInstance()->addPrefix('spseo','SimpleSEO');
} catch (Exception $e) { }

$path = dirname(__FILE__) . DS . 'langs.zip';
BOL_LanguageService::getInstance()->importPrefixFromZip($path, 'spseo');