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

/**
 * Description here
 * 
 * @author Thao Le <thaolt@songphi.com>
 * @package spseo.classes
 * @since 1.0
 */

/**
* 
*/
class SPSEO_CLASS_GroupsBridge implements SPSEO_CLASS_BridgeInterface
{
	protected static $classInstance = null;

	public static function getInstance() {
		if (self::$classInstance === null)  {
			self::$classInstance = new self();
		}
		return self::$classInstance;
	}

	protected function __construct() {
		SPSEO_BOL_Service::getInstance()->registerBridge($this);
	}

	public function handleRoutes() {
		$matches = array();
        if (preg_match('#^groups/.*?\-(\d+)$#i', OW::getRouter()->getUri(), $matches)) {
            OW::getRouter()->setUri('groups/'.$matches[1]);
            return true;
        }
        return false;
	}

	public function modifyLinks($body) {
		$baseurl = preg_quote(OW::getRouter()->getBaseUrl(),'#');
        $pattern = '#'.$baseurl.'groups\/(\d+)#i';
        $body = preg_replace_callback($pattern, array($this,'groupsRule'), $body);
        return $body;
	}

	public function groupsRule( array $matches ) {
        $group = GROUPS_BOL_Service::getInstance()->findGroupById($matches[1]);
        $slug = SPSEO_BOL_Service::getInstance()->slugify($group->title).'-'.$group->id;
        return OW::getRouter()->getBaseUrl().'groups/'.$slug;
    }
}