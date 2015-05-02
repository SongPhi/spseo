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
 * @package spseo.controllers
 * @since 1.0
 */


class SPSEO_CTRL_Admin extends ADMIN_CTRL_Abstract 
{
    private $menu = null;
    private $language;

	function __construct() {
		$this->language = OW::getLanguage();
		$this->menu = $this->getMenu();
		$this->addComponent( 'menu', $this->menu );
		parent::__construct();
	}

	function setPageHeading( $heading ) {
		$heading = 'SIMPLESEO :: ' . $heading;
		return parent::setPageHeading( $heading );
	}

	function index() {
	    $this->setPageHeading( $this->language->text( 'spseo', 'adm_configuration' ) );
	}

	function pages() {
	    $this->setPageHeading( $this->language->text( 'spseo', 'adm_menu_pages' ) );
	}

	function robotstxt() {
	    $robotstxtForm = new SPSEO_CLASS_RobotstxtForm();
        
        $this->assign('isFtpRequired', $robotstxtForm->isFtpRequired());

        $this->addForm($robotstxtForm);

        if ( OW::getRequest()->isPost() && $robotstxtForm->isValid($_POST) )
        {
            $robotstxtForm->process();
            OW::getFeedback()->info($this->language->text('spseo', 'robotstxt_updated'));
            $this->redirect(OW::getRouter()->urlForRoute('spseo.admin_robotstxt'));
        } else {
	    	$this->setPageHeading( $this->language->text( 'spseo', 'adm_menu_robottxt' ) );
        }
	}

	function getMenu() {
		$menu = new BASE_CMP_ContentMenu();
		$menuItems = array();

		$item = new BASE_MenuItem();
		$item->setLabel( $this->language->text( 'spseo', 'adm_menu_configuration' ) );
		$item->setUrl( OW::getRouter()->urlForRoute( 'spseo.admin' ) );
		$item->setKey( 'index' );
		$item->setIconClass( 'ow_ic_gear_wheel' );
		$item->setOrder( 0 );
		$menuItems[] = $item;

		// $item = new BASE_MenuItem();
		// $item->setLabel( $this->language->text( 'spseo', 'adm_menu_pages' ) );
		// $item->setUrl( OW::getRouter()->urlForRoute( 'spseo.admin_pages' ) );
		// $item->setKey( 'pages' );
		// $item->setIconClass( 'ow_ic_files' );
		// $item->setOrder( 1 );
		// $menuItems[] = $item;

		// $item = new BASE_MenuItem();
		// $item->setLabel( $this->language->text( 'spseo', 'adm_menu_urls' ) );
		// $item->setUrl( OW::getRouter()->urlForRoute( 'spseo.admin_urls' ) );
		// $item->setKey( 'urls' );
		// $item->setIconClass( 'ow_ic_link' );
		// $item->setOrder( 2 );
		// $menuItems[] = $item;

		// $item = new BASE_MenuItem();
		// $item->setLabel( $this->language->text( 'spseo', 'adm_menu_sitemap' ) );
		// $item->setUrl( OW::getRouter()->urlForRoute( 'spseo.admin_sitemap' ) );
		// $item->setKey( 'sitemap' );
		// $item->setIconClass( 'ow_ic_push_pin' );
		// $item->setOrder( 3 );
		// $menuItems[] = $item;

		$item = new BASE_MenuItem();
		$item->setLabel( $this->language->text( 'spseo', 'adm_menu_robottxt' ) );
		$item->setUrl( OW::getRouter()->urlForRoute( 'spseo.admin_robotstxt' ) );
		$item->setKey( 'robotstxt' );
		$item->setIconClass( 'ow_ic_file' );
		$item->setOrder( 4 );
		$menuItems[] = $item;

		$item = new BASE_MenuItem();
		$item->setLabel( $this->language->text( 'spseo', 'adm_menu_help' ) );
		$item->setUrl( OW::getRouter()->urlForRoute( 'spseo.admin_help' ) );
		$item->setKey( 'help' );
		$item->setIconClass( 'ow_ic_help' );
		$item->setOrder( 5 );
		$menuItems[] = $item;

		$menu->setMenuItems( $menuItems );
		$menu->deactivateElements();

		return $menu;
	}
}

