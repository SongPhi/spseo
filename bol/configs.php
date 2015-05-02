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

class SPVIDEOLITE_BOL_Configs
{
    const PLUGINKEY = 'spseo';
    
    /**
     * Default configurations
     */
    public $defaults = array(
        'features.video' => true,
        'features.blogs' => true,
        'features.forum' => true,
        'features.events' => true,
        'features.groups' => true,
        'options.redirect301' => true,
    );
    
    protected static $classInstance = null;
    
    private $configs = null;
    
    private $changes = array();
    
    public static function getInstance() {
        if (null === self::$classInstance) {
            self::$classInstance = new self();
        }
        return self::$classInstance;
    }
    
    protected function __construct() {
        $this->configs = OW::getConfig()->getValues(self::PLUGINKEY);
        if (!is_array($this->configs)) $this->configs = array();
        register_shutdown_function(array(&$this, 'saveConfigs'));
    }
    
    public function get($key) {
        if (!isset($this->configs[$key])) {
            if (isset($this->defaults[$key])) $this->configs[$key] = $this->defaults[$key];
            else throw new Exception("Error Reading Configuration", 1);
        }
        return $this->configs[$key];
    }
    
    public function keyExists($key) {
        return in_array($key, array_keys($this->getValues()));
    }
    
    public function set($key, $value) {
        if (isset($this->configs[$key]) && $this->configs[$key] == $value) return;
        $this->changes[] = $key;
        $this->configs[$key] = $value;
    }
    
    public function searchKey($keyPattern) {
        $matches = array();
        preg_match_all($keyPattern, implode(PHP_EOL, array_keys($this->getValues())), $matches);
        if (is_array($matches) && count($matches) > 0 && is_array($matches[0])) return $matches[0];
        else return false;
    }
    
    public function getValues() {
        return array_merge($this->defaults, $this->configs);
    }
    
    public function saveConfigs() {
        if (!count($this->changes) > 0) return;
        foreach ($this->changes as $key) {
            if (OW::getConfig()->configExists(self::PLUGINKEY, $key)) {
                OW::getConfig()->saveConfig(self::PLUGINKEY, $key, $this->configs[$key]);
            } else {
                OW::getConfig()->addConfig(self::PLUGINKEY, $key, $this->configs[$key]);
            }
        }
    }
}
