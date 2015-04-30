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
 * @package spseo.components
 * @since 1.0
 */
class SPSEO_CMP_ConsoleComponent extends BASE_CMP_ConsoleDropdownMenu
{
	public function __construct()
    {
        $language = OW::getLanguage();
        parent::__construct($language->text('spseo', 'console_menu_text'));


        $this->setUrl('javascript://');
        $this->addItem('main', array('class' => 'spseo_edit_page_meta','label' => $language->text('spseo', 'console_edit_page_meta'), 'url' => 'javascript://'));
        $this->addItem('main', array('class' => 'spseo_clear_urls_cache', 'label' => $language->text('spseo', 'console_clear_urls_cache'), 'url' => 'javascript://'));
    }

    protected function initJs()
    {
        // $js = UTIL_JsGenerator::newInstance();
        // $js->addScript('OW.Console.addItem(new OW_ConsoleDropdownHover({$uniqId}, {$contentIniqId}), {$key});', array(
        //     'key' => $this->getKey(),
        //     'uniqId' => $this->consoleItem->getUniqId(),
        //     'contentIniqId' => $this->consoleItem->getContentUniqId()
        // ));

        // OW::getDocument()->addOnloadScript($js);
    }
}
