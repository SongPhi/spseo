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

class SPSEO_FORM_CleanCacheForm extends Form
{
	
    public function __construct()
    {
        parent::__construct('cleanCacheForm');
        $language = OW::getLanguage();

        $this->setAction(OW::getRouter()->urlForRoute('spseo.cleancache',array()));

        $optCurrentPage = new CheckboxField('optCurrentPage');
        $optCurrentPage->setLabel($language->text('spseo','clcachef_lbl_current_page'));
        $optCurrentPage->setValue(true);
        $this->addElement($optCurrentPage);

        $optAllPages = new CheckboxField('optAllPages');
        $optAllPages->setLabel($language->text('spseo','clcachef_lbl_all_pages'));
        $optAllPages->setValue(false);
        $this->addElement($optAllPages);

        $optAllData = new CheckboxField('optAllData');
        $optAllData->setLabel($language->text('spseo','clcachef_lbl_all_data'));
        $optAllData->setValue(false);
        $this->addElement($optAllData);

        // submit
        $submit = new Submit('clean');
        $submit->setValue($language->text('spseo', 'btn_clean'));
        $this->addElement($submit);
    }

    public function process()
    {
        $values = $this->getValues();

        return array('result' => true);
    }
}