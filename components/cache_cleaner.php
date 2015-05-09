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
class SPSEO_CMP_CacheCleaner extends OW_Component
{
	public function __construct( $uri ) {
        $language = OW::getLanguage();

        $cleanCacheForm = new SPSEO_FORM_CleanCacheForm( $uri );

        $this->addForm($cleanCacheForm);

        $this->initJs();
    }

    public function initJs() {
        $language = OW::getLanguage();
        $js = "
            owForms['cleanCacheForm'].bind('submit',function(ev) { 
            	$.post($(this).attr('action'),$(this).serialize(),function(data){
                    if (data.result == true || data.result == 'true') {
					    window.cachecleanerAjaxFloatBox.close();
                        OW.message('".$language->text('spseo','clcachef_msg_success')."','info');
                    } else {
                        OW.message('".$language->text('spseo','clcachef_msg_failed_unknown')."','error');
                    }
            	},'json')
					.fail(function(){
                        OW.message('".$language->text('spseo','clcachef_msg_no_connection')."','error');
					});
                return false;
            });
        ";

        OW::getDocument()->addOnloadScript($js);
    }

}
