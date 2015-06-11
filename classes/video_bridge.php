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
class SPSEO_CLASS_VideoBridge implements SPSEO_CLASS_BridgeInterface
{
	protected static $classInstance = null;
	private $origUri;

	public static function getInstance() {
		if (self::$classInstance === null)  {
			self::$classInstance = new self();
		}
		return self::$classInstance;
	}

	protected function __construct() {
		SPSEO_BOL_Service::getInstance()->registerBridge($this,array('video/view/'=>'videoViewRule'));
	}

	public function handleRoutes() {
		$matches = array();
		$this->origUri = OW::getRouter()->getUri();
        if (preg_match('#^video/view/.*?\-(\d+)$#i', $this->origUri, $matches)) {
            OW::getRouter()->setUri('video/view/'.$matches[1]);
            return $matches[1];
        }
        return false;
	}

	public function videoViewRule( $id ) {
        $clip = VIDEO_BOL_ClipService::getInstance()->findClipById($id);
        $slug = SPSEO_BOL_Service::getInstance()->slugify($clip->title).'-'.$clip->id;
        return 'video/view/'.$slug;
    }

    public function getOpenGraphData($id) {
    	$clip = VIDEO_BOL_ClipService::getInstance()->findClipById($id);
        $cacheService = SPSEO_BOL_CacheService::getInstance();
        $image = $clip->thumbUrl;
        if (substr($image, 0,2)=='//')
                $image = 'http:' . $image;
        if (substr($image, 0,7)!='http://' && substr($image, 0,8)!='https://')
                $image = 'http://' . $image;
        $ogdata = array(
                'title' => addslashes( strip_tags($clip->title) ),
                'image' => $image,
                'type' => 'video',
                'url' => (OW::getRouter()->getBaseUrl() . $this->origUri),
                'description' => htmlentities( str_replace("\r", '', str_replace("\n", ' ', strip_tags($clip->description))) )
        );
        return $ogdata;
    }
}
