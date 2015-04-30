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


@OW::getPluginManager()->addPluginSettingsRouteName('spseo', 'spseo.admin');

try {
	BOL_LanguageService::getInstance()->addPrefix('spseo','SimpleSEO');
} catch (Exception $e) { }

// -- CREATE TABLE "ow_spseo_url" ---------------------------------
// CREATE TABLE `ow_spseo_url` ( 
// 	`id` Int( 255 ) UNSIGNED AUTO_INCREMENT NOT NULL, 
// 	`uri` VarChar( 255 ) NOT NULL, 
// 	`prefix` VarChar( 255 ) NULL, 
// 	`slug` VarChar( 255 ) NULL, 
// 	`friendly_uri` Text NULL, 
// 	`cache_pages` VarChar( 255 ) NULL, 
// 	`updated` Int( 255 ) UNSIGNED NULL, 
// 	`target_id` Int( 255 ) UNSIGNED NULL, 
// 	`hash` VarChar( 32 ) NOT NULL,
// 	 PRIMARY KEY ( `id` )
// , 
// 	CONSTRAINT `unique_id` UNIQUE( `id` ), 
// 	CONSTRAINT `unique_uri` UNIQUE( `uri` ) );
// CREATE INDEX `index_hash` ON `ow_spseo_url`( `hash` )

// CREATE INDEX `index_id` ON `ow_spseo_url`( `id` )

// CREATE INDEX `index_slug` ON `ow_spseo_url`( `slug` )

// CREATE INDEX `index_uri` ON `ow_spseo_url`( `uri` );
// -- -------------------------------------------------------------
