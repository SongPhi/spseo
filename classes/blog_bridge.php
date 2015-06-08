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
class SPSEO_CLASS_BlogBridge implements SPSEO_CLASS_BridgeInterface
{
	protected static $classInstance = null;

	public static function getInstance() {
		if (self::$classInstance === null)  {
			self::$classInstance = new self();
		}
		return self::$classInstance;
	}

	protected function __construct() {
		SPSEO_BOL_Service::getInstance()->registerBridge(
			$this,
			array('blogs/'=>'blogsRule','blogs/post/'=>'blogsRule')
		);
	}

	public function handleRoutes() {
		$matches = array();
		$this->origUri = OW::getRouter()->getUri();
        if (preg_match('#^blogs/.*?\-(\d+)$#i', $this->origUri, $matches)) {
            OW::getRouter()->setUri('blogs/'.$matches[1]);
            return $matches[1];
        }
        if (preg_match('#^blogs/post/.*?\-(\d+)$#i', $this->origUri, $matches)) {
            OW::getRouter()->setUri('blogs/'.$matches[1]);
            return $matches[1];
        }
        return false;
	}

	public function blogsRule( $id ) {
        $post = PostService::getInstance()->findById($id);
        $slug = SPSEO_BOL_Service::getInstance()->slugify($post->title).'-'.$post->id;
        return 'blogs/'.$slug;
    }

    private function findFirstImage($content) {
    	$matches = array();
    	$ok = preg_match_all('#<img.*?src=(\'|")(.*?)(\'|").*?>#i', $content, $matches);

    	if ($ok) 
    		return $matches[2][0];
    	return false;
    }

    public function getOpenGraphData($id) {
    	$post = PostService::getInstance()->findById($id);
    	$cacheService = SPSEO_BOL_CacheService::getInstance();
    	$ogdata = array(
    		'title' => addslashes( strip_tags($post->getTitle()) ),
    		'type' => 'article',
    		'url' => (OW::getRouter()->getBaseUrl() . $this->origUri)
		);
		$content = $post->getPost();

		$preview = explode("<!--more-->", $content);

		if ( !count($preview)>1 ) {
            $preview = explode('<!--page-->', $preview[0]);
        }

        $preview = $preview[0];

		$ogdata['description'] = htmlentities( str_replace("\r", '', str_replace("\n", ' ', strip_tags(
			UTIL_String::truncate( strip_tags($preview), 145, '...' )  
		))) );

		$image = $this->findFirstImage($content);
		if ($image!==false) {
			$ogdata['image'] = $image;
		}

		return $ogdata;
    }


}