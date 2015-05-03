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

class SPSEO_FORM_PageMetaForm extends Form
{
	private $slugAvailable;
    private $urlObj;
    private $pageObj;
	
    public function __construct($uri)
    {
        parent::__construct('pageMetaForm');
        $this->slugAvailable = false;

        $language = OW::getLanguage();

        $this->setAction(OW::getRouter()->urlForRoute('spseo.savepage',array()));

        $this->urlObj = SPSEO_BOL_UrlService::getInstance()->findByUri( $uri );
        $this->pageObj = SPSEO_BOL_PageService::getInstance()->findByUri( $uri );

        $uriField = new HiddenField('uri');
        $uriField->setValue($uri);
        $this->addElement($uriField);

        if (is_object($this->urlObj)) {
        	$slugField = new TextField('slug');
	        $slugField->setLabel($language->text('spseo','pgmtf_lbl_slug'));
	        $slugField->setValue($this->urlObj->slug);
            $slugValidator = new RegExpValidator('/^[a-z0-9\\-_]+$/i');
            $slugValidator->setErrorMessage('Invalid slug format, only alphanumeric and dash(-) are allowed!');
            $slugField->addValidator($slugValidator);
	        $this->addElement($slugField);

	        $this->slugAvailable = true;
        }

        $descriptionField = new TextArea('description');
        $descriptionField->setLabel($language->text('spseo','pgmtf_lbl_description'));
        if (is_object($this->pageObj)) $descriptionField->setValue($this->pageObj->meta_description);
        $this->addElement($descriptionField);

        $keywordsField = new TextArea('keywords');
        $keywordsField->setLabel($language->text('spseo','pgmtf_lbl_keywords'));
        if (is_object($this->pageObj)) $keywordsField->setValue($this->pageObj->meta_keywords);
        $this->addElement($keywordsField);

        // submit
        $submit = new Submit('save');
        $submit->setValue($language->text('spseo', 'btn_save'));
        $this->addElement($submit);
    }

    public function isSlugAvailable() {
    	return $this->slugAvailable;
    }

    public function process()
    {
        $values = $this->getValues();

        $page = new SPSEO_BOL_Page();
        $page->uri = $values['uri'];
        $page->hash = crc32($values['uri']);
        $page->meta_description = $values['description'];
        $page->meta_keywords = $values['keywords'];

        $resp = SPSEO_BOL_PageService::getInstance()->update($page) > 0;

        SPSEO_BOL_CacheService::getInstance()->updatePageMetaData(
            $page->hash,
            array(
                'meta_description' => $page->meta_description,
                'meta_keywords' => $page->meta_keywords
            )
        );

        if ($this->slugAvailable) {
            if ($this->urlObj->slug != $values['slug']) {
                $this->urlObj->slug = $values['slug'];
                SPSEO_BOL_UrlService::getInstance()->updateSlug($this->urlObj);
            }
        }

        $result = array('result' => $resp);

        return $result;
    }
}
