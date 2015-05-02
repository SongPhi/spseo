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

class SPSEO_BOL_PageUrlsDao extends OW_BaseDao
{
	protected static $classInstance = null;

	public static function getInstance() {
		if (self::$classInstance === null) {
			self::$classInstance = new self();
		}

		return self::$classInstance;
	}

    public function getDtoClassName() {
        return 'SPSEO_BOL_PageUrls';
    }

    public function getTableName() {
        return OW_DB_PREFIX . 'spseo_page_urls';
    }

    public function updatePageUrls($pageHash, array $urlHashes) {
    	$sql = "";
    	$updated = time();
    	foreach ($urlHashes as $urlHash) {
    		$sql .= "INSERT INTO `".$this->getTableName()."`"
    			 ." (`page_hash`,`url_hash`,`updated`) VALUES (\"$pageHash\",\"$urlHash\",\"$updated\")"
    			 ." ON DUPLICATE KEY UPDATE `updated`=\"$updated\";\n";
    	}
		$this->dbo->update($sql);
    }

}