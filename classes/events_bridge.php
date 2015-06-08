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
class SPSEO_CLASS_EventsBridge implements SPSEO_CLASS_BridgeInterface
{
	protected static $classInstance = null;

	public static function getInstance() {
		if (self::$classInstance === null)  {
			self::$classInstance = new self();
		}
		return self::$classInstance;
	}

	protected function __construct() {
		SPSEO_BOL_Service::getInstance()->registerBridge($this,array('event/'=>'eventRule'));
	}

	public function handleRoutes() {
		$matches = array();
		$this->origUri = OW::getRouter()->getUri();
        if (preg_match('#^event/.*?\-(\d+)$#i', $this->origUri, $matches)) {
            OW::getRouter()->setUri('event/'.$matches[1]);
            return true;
        }
        return false;
	}

	public function eventRule( $id ) {
        $event = EVENT_BOL_EventService::getInstance()->findEvent($id);
        $slug = SPSEO_BOL_Service::getInstance()->slugify($event->title).'-'.$event->id;
        return 'event/'.$slug;
    }

    public function getOpenGraphData($id) {
    	$event = EVENT_BOL_EventService::getInstance()->findEvent($id);
    	$cacheService = SPSEO_BOL_CacheService::getInstance();
    	$ogdata = array(
    		'title' => addslashes( strip_tags($event->title) ),
    		'image' => EVENT_BOL_EventService::getInstance()->generateImageUrl($event->getImage()),
    		'type' => 'website',
    		'url' => (OW::getRouter()->getBaseUrl() . $this->origUri),
    		'description' => htmlentities( str_replace("\r", '', str_replace("\n", ' ', strip_tags($event->description))) )
    	);
		return $ogdata;
    }
}