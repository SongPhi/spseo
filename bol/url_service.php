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
 * @author Thao Le <thaolt@songphi.com>
 * @package spseo.bol
 * @since 1.0
 */

class SPSEO_BOL_UrlService
{
	protected static $classInstance = null;

	private $urlDao = null;

	public static function getInstance() {
		if (self::$classInstance === null) {
			self::$classInstance = new self();
		}

		return self::$classInstance;
	}

	protected function __construct() {
		$this->urlDao = SPSEO_BOL_UrlDao::getInstance();
	}

	public function findByUri( $uri ) {
		return $this->urlDao->findByUri( $uri );
	}

	public function insert($uri,$friendlyUri,$prefix,$id,$hash,$pagehash) {
		$obj = new SPSEO_BOL_Url();
		$obj->uri = $uri;
		$obj->friendly_uri = $friendlyUri;
		$obj->prefix = $prefix;
		$obj->target_id = $id;
		$obj->hash = $hash;
		$obj->updated = time();
		$obj->slug = substr($friendlyUri, strlen($prefix));
		$obj->slug = substr($obj->slug, 0, 0-(strlen($id)+1));
		$this->urlDao->save( $obj );
	}

	public function updateSlug( SPSEO_BOL_Url $url ) {
		$url->updated = time();
		$url->friendly_uri = $url->prefix . $url->slug . '-' . $url->target_id;
		$this->urlDao->save($url);

		SPSEO_BOL_CacheService::getInstance()->updatePageSlug( $url->hash, $url->slug );

		$pageUrlsDao = SPSEO_BOL_PageUrlsDao::getInstance();

		$example = new OW_Example();
        $example->andFieldEqual('url_hash', $url->hash);

        $pages = $pageUrlsDao->findListByExample($example);

        foreach ($pages as $page) {
        	$cacheHash = $page->page_hash;
        	SPSEO_BOL_CacheService::getInstance()->modifyPageUrl($cacheHash, $url->uri, $url->friendly_uri);
        }
	}
}
