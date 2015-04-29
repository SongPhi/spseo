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

class SPSEO_CLASS_EventHandler
{


    protected static $classInstance = null;

    public static function getInstance() {
        if ( null === self::$classInstance ) {
            self::$classInstance = new self();
        }
        return self::$classInstance;
    }

    public static function initialization() {
        $instance = SPSEO_CLASS_EventHandler::getInstance();
        $em = OW::getEventManager();
        $em->bind(OW_EventManager::ON_PLUGINS_INIT, array($instance, 'onBeforeRouting'));
        $em->bind(OW_EventManager::ON_BEFORE_DOCUMENT_RENDER, array($instance, 'onDocumentRender'));
        $em->bind(BASE_CMP_Console::EVENT_NAME, array($instance, 'addConsoleItem'));
    }

    public function addConsoleItem( BASE_CLASS_EventCollector $event ) {
        $language = OW::getLanguage();
        $router = OW::getRouter();
        if ( OW::getUser()->isAdmin() ) {
            $item = new SPSEO_CMP_ConsoleComponent();
            $event->addItem($item, 999);
        }
    }

    public function onDocumentRender() {
        SPSEO_BOL_Service::getInstance()->applyPageModifications();
    }

    public function onBeforeRouting() {
        // init bridges
        SPSEO_CLASS_ForumBridge::getInstance();
        SPSEO_CLASS_VideoBridge::getInstance();
        SPSEO_CLASS_BlogBridge::getInstance();
        SPSEO_CLASS_GroupsBridge::getInstance();
        SPSEO_CLASS_EventsBridge::getInstance();

        SPSEO_BOL_Service::getInstance()->handleRoutes();
        SPSEO_BOL_CacheService::getInstance();
    }

}