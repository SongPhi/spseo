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

class SPSEO_CTRL_Spseo extends OW_ActionController
{
	public function savepage() {
		$language = OW::getLanguage();

		$uri = '';

		if (isset($_POST['uri'])) $uri = $_POST['uri'];

        $pageMetaForm = new SPSEO_FORM_PageMetaForm( $uri );
        $resp = array();

        if ( OW::getRequest()->isPost() && $pageMetaForm->isValid($_POST) )
        {
            $resp = $pageMetaForm->process();
            // OW::getFeedback()->info($this->language->text('spseo', 'robotstxt_updated'));
        } else {
        	$resp = array(
        		'result' => 'false',

        	);
        }

        header('Content-type: application/json');
        $template = OW::getPluginManager()->getPlugin('spseo')->getCtrlViewDir() . 'spseo_savepage.html';
        $this->setTemplate($template);

        $this->assign('json', json_encode($resp));
        die($this->render());
	}

	public function cleancache() {
		
	}
}

