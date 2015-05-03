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

class SPSEO_BOL_PageDao extends OW_BaseDao
{
	protected static $classInstance = null;

	public static function getInstance() {
		if (self::$classInstance === null) {
			self::$classInstance = new self();
		}

		return self::$classInstance;
	}

    public function getDtoClassName() {
        return 'SPSEO_BOL_Page';
    }

    public function getTableName() {
        return OW_DB_PREFIX . 'spseo_page';
    }

    public function findByUri( $uri ) {
    	$example = new OW_Example();

        $example->andFieldEqual('uri', $uri);

        return $this->findObjectByExample($example);
    }

    public function update( $page ) {
    	$tbl = $this->getTableName();
    	$sql = "INSERT INTO $tbl ( `uri`,`hash`,`meta_description`,`meta_keywords` ) VALUES(?,?,?,?)
    		ON DUPLICATE KEY UPDATE `meta_description` = ?, `meta_keywords`=?";
    	return $this->dbo->update($sql, array(
    		$page->uri,
    		$page->hash,
    		$page->meta_description,
    		$page->meta_keywords,
    		$page->meta_description,
    		$page->meta_keywords
		));
    }

}