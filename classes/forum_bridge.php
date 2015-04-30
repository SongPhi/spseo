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
class SPSEO_CLASS_ForumBridge implements SPSEO_CLASS_BridgeInterface
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
			array(
				'forum/' => 'forumGroupRule',
				'forum/section/' => 'forumSectionRule',
				'forum/topic/' => 'forumTopicRule'
			)
		);
	}

	public function handleRoutes() {
		$matches = array();
        if (preg_match('#^forum/topic/.*?\-(\d+)$#i', OW::getRouter()->getUri(), $matches)) {
            OW::getRouter()->setUri('forum/topic/'.$matches[1]);
            return true;
        }
        if (preg_match('#^forum/section/.*?\-(\d+)$#i', OW::getRouter()->getUri(), $matches)) {
            OW::getRouter()->setUri('forum/section/'.$matches[1]);
            return true;
        }
        if (preg_match('#^forum/.*?\-(\d+)$#i', OW::getRouter()->getUri(), $matches)) {
            OW::getRouter()->setUri('forum/'.$matches[1]);
            return true;
        }
        return false;
	}

	public function forumTopicRule( $id ) {
        $topic = FORUM_BOL_ForumService::getInstance()->findTopicById($id);
        $slug = SPSEO_BOL_Service::getInstance()->slugify($topic->title).'-'.$topic->id;

        $friendlyUrl = 'forum/topic/'.$slug;

        return $friendlyUrl;
    }

    public function forumGroupRule( $id ) {
        $group = FORUM_BOL_ForumService::getInstance()->findGroupById($id);
        $slug = SPSEO_BOL_Service::getInstance()->slugify($group->name).'-'.$group->id;

        $friendlyUrl = 'forum/'.$slug;

        return $friendlyUrl;
    }

    public function forumSectionRule( $id ) {
        $section = FORUM_BOL_ForumService::getInstance()->findSectionById($id);
        $slug = SPSEO_BOL_Service::getInstance()->slugify($section->name).'-'.$section->id;

        $friendlyUrl = 'forum/section/'.$slug;

        return $friendlyUrl;
    }
}