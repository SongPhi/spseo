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

if ( !defined('OW_CRON') ) {

	define('SPSEO_DIR_ROOT', dirname(__FILE__));
	define('SPSEO_DIR_FORMS', SPSEO_DIR_ROOT . DS . 'forms');

	define('SPSEO_DB_PREFIX', OW_DB_PREFIX . 'spseo_');

	// adding package pointers for importers
	OW::getAutoloader()->addPackagePointer('SPSEO_FORM', SPSEO_DIR_FORMS);

	// Routes declaration
	SPSEO_BOL_Service::declareRoutes();

	// Events handling
	SPSEO_CLASS_EventHandler::initialization();

}

