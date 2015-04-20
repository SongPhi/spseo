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
 * @package spseo.bol
 * @since 1.0
 */

class SPSEO_BOL_Service
{
    const PLUGIN_NAME = 'spseo';
    const PLUGIN_VER = 'v1.0.0';
    protected static $classInstance = null;

    public static function getInstance() {
        if ( null === self::$classInstance ) {
            self::$classInstance = new self();
        }
        return self::$classInstance;
    }

    public static function getPlugin() {
        return OW::getPluginManager()->getPlugin(self::PLUGIN_NAME);
    }

    public static function getJsUrl($filename) {
        return self::getPlugin()->getStaticJsUrl() . $filename . '.js';
    }

    public static function getCssUrl($filename) {
        return self::getPlugin()->getStaticCssUrl() . $filename . '.css';
    }

    public static function getRoute() {
        $route = OW::getRequestHandler()->getHandlerAttributes();
        if (is_array($route)) {
            return $route;
        }
        return false;
    }

    public static function isRoute( $controller, $action = null ) {
        $route = self::getRoute();

        if ( !$route )
            return false;

        if ( $route["controller"] == $controller ) {
            if ( $route["action"] == $action || !$action ) {
                return true;
            }
        }

        return false;
    }

    public static function declareRoutes() {
        OW::getRouter()->addRoute(new OW_Route('spseo.admin', 'admin/plugins/spseo', 'SPSEO_CTRL_Admin', 'index'));
    }

}
