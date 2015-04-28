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
 * @package spseo.classes
 * @since 1.0
 */

class SPSEO_CLASS_RobotstxtForm extends Form
{
	/**
     * Class constructor
     *
     */
    public function __construct()
    {
        parent::__construct('robotstxtForm');

        $language = OW::getLanguage();

        if (!is_writable(OW_DIR_ROOT.'robots.txt')) {
	        $ftpUserField = new TextField('username');
	        $ftpUserField->setRequired(true);
	        $this->addElement($ftpUserField);

	        $ftpPasswordField = new TextField('password');
	        $ftpPasswordField->setRequired(true);
	        $this->addElement($ftpPasswordField);
        }

        $fileContentField = new TextArea('content');
        $fileContentField->setRequired(true);        
        $fileContentField->setValue(file_get_contents(OW_DIR_ROOT.'robots.txt'));
        $this->addElement($fileContentField);

        // submit
        $submit = new Submit('save');
        $submit->setValue($language->text('spseo', 'btn_save'));
        $this->addElement($submit);
    }

    public function isFtpRequired() {
    	return !is_writable(OW_DIR_ROOT.'robots.txt');
    }

    /**
     * Updates video plugin configuration
     *
     * @return boolean
     */
    public function process()
    {
        $values = $this->getValues();

        $config = OW::getConfig();

        // $config->saveConfig('video', 'player_width', $values['playerWidth']);
        // $config->saveConfig('video', 'player_height', $values['playerHeight']);
        // $config->saveConfig('video', 'videos_per_page', $values['perPage']);
        // $config->saveConfig('video', 'user_quota', $values['quota']);

        return array('result' => true);
    }
}