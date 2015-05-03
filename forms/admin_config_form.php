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
 * @package spseo.forms
 * @since 1.0
 */

class SPSEO_FORM_AdminConfigForm extends Form
{
	
    public function __construct()
    {
        parent::__construct('adminConfigForm');
        $language = OW::getLanguage();
        $config = SPSEO_BOL_Configs::getInstance();

        $optRedirect = new CheckboxField('optRedirect');
        $optRedirect->setLabel($language->text('spseo','admincf_lbl_opt_redirect'));
        $optRedirect->setValue($config->get('options.redirect301'));
        $this->addElement($optRedirect);

        $optConsoleHide = new CheckboxField('optConsoleHide');
        $optConsoleHide->setLabel($language->text('spseo','admincf_lbl_opt_console_hide'));
        $optConsoleHide->setValue($config->get('console.console_menu_hide'));
        $this->addElement($optConsoleHide);

        $optConsoleOrder = new TextField('optConsoleOrder');
        $optConsoleOrder->setLabel($language->text('spseo','admincf_lbl_opt_console_order'));
        $optConsoleOrder->setValue($config->get('console.console_menu_order'));
        $this->addElement($optConsoleOrder);

        $bridgeForum = new CheckboxField('bridgeForum');
        $bridgeForum->setLabel($language->text('spseo','admincf_lbl_bridge_forum'));
        $bridgeForum->setValue($config->get('features.forum'));
        $this->addElement($bridgeForum);

        $bridgeBlogs = new CheckboxField('bridgeBlogs');
        $bridgeBlogs->setLabel($language->text('spseo','admincf_lbl_bridge_blogs'));
        $bridgeBlogs->setValue($config->get('features.blogs'));
        $this->addElement($bridgeBlogs);

        $bridgeGroups = new CheckboxField('bridgeGroups');
        $bridgeGroups->setLabel($language->text('spseo','admincf_lbl_bridge_groups'));
        $bridgeGroups->setValue($config->get('features.groups'));
        $this->addElement($bridgeGroups);

        $bridgeEvents = new CheckboxField('bridgeEvents');
        $bridgeEvents->setLabel($language->text('spseo','admincf_lbl_bridge_event'));
        $bridgeEvents->setValue($config->get('features.events'));
        $this->addElement($bridgeEvents);

        $bridgeVideo = new CheckboxField('bridgeVideo');
        $bridgeVideo->setLabel($language->text('spseo','admincf_lbl_bridge_video'));
        $bridgeVideo->setValue($config->get('features.video'));
        $this->addElement($bridgeVideo);

        // submit
        $submit = new Submit('save');
        $submit->setValue($language->text('spseo', 'btn_save'));
        $this->addElement($submit);

    }

    public function process()
    {
        $values = $this->getValues();
        $config = SPSEO_BOL_Configs::getInstance();

        foreach ($values as $key => $value) {
            if (!$values[$key])
                $values[$key] = false;
        }

        $config->set('options.redirect301',$values['optRedirect']);
        $config->set('console.console_menu_order',$values['optConsoleOrder']);
        $config->set('console.console_menu_hide',$values['optConsoleHide']);
        $config->set('features.forum',$values['bridgeForum']);
        $config->set('features.blogs',$values['bridgeBlogs']);
        $config->set('features.groups',$values['bridgeGroups']);
        $config->set('features.events',$values['bridgeEvents']);
        $config->set('features.video',$values['bridgeVideo']);
        $config->saveConfigs();

        return array('result' => true);
    }
}