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

class SPSEO_FORM_RobotstxtForm extends Form
{
    public function __construct()
    {
        parent::__construct('robotstxtForm');

        $language = OW::getLanguage();

        if (!is_writable(OW_DIR_ROOT.'robots.txt')) {

            $ftpParams = is_array(OW::getSession()->get('ftpAttrs')) ? OW::getSession()->get('ftpAttrs') : false;
            
            $ftpConn = false;

            if ($ftpParams !== false) {
                try {
                    $ftpConn = UTIL_Ftp::getConnection();
                } catch (Exception $e) {
                    $ftpConn = false;
                }
            }

            if ($ftpConn === false) {
                $ftpUserField = new TextField('username');
                $ftpUserField->setRequired(true);
                if (isset($ftpParams['login'])) $ftpUserField->setValue($ftpParams['login']);
                $ftpUserField->addAttribute('placeholder',$language->text('spseo', 'fphldr_username'));
                $this->addElement($ftpUserField);

                $ftpPasswordField = new TextField('password');
                $ftpPasswordField->setRequired(true);
                if (isset($ftpParams['password'])) $ftpPasswordField->setValue($ftpParams['password']);
                $ftpPasswordField->addAttribute('placeholder',$language->text('spseo', 'fphldr_password'));
                $this->addElement($ftpPasswordField);

                $ftpHostField = new TextField('host');
                if (isset($ftpParams['host'])) 
                    $ftpHostField->setValue($ftpParams['host']); 
                else
                    $ftpHostField->setValue('localhost'); 
                $ftpHostField->addAttribute('placeholder',$language->text('spseo', 'fphldr_host'));
                $this->addElement($ftpHostField);

                $ftpPortField = new TextField('port');
                if (isset($ftpParams['port'])) $ftpPortField->setValue($ftpParams['port']);
                $ftpPortField->addAttribute('placeholder',$language->text('spseo', 'fphldr_port'));
                $this->addElement($ftpPortField);
            }
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

    public function process()
    {
        $values = $this->getValues();

        if (is_writable(OW_DIR_ROOT.'robots.txt')) {
            file_put_contents(OW_DIR_ROOT.'robots.txt', $values['content']);
        } else {
            $tmpDir = SPSEO_BOL_Service::getInstance()->getTempDir();
            $tmpFile = $tmpDir.DS.'robots.txt';

            if (!file_exists($tmpDir)) {
                mkdir($tmpDir, 0777, true);
            } else {
                if (!is_dir($tmpDir)) {
                    unlink($tmpDir);
                    mkdir($tmpDir, 0777, true);
                }
            }

            $tmpFile = $tmpDir.DS.'robots.txt';

            file_put_contents($tmpFile, $values['content']);

            $ftpParams = false;

            if (isset($values['username'])) {
                $ftpParams = array(
                    'login' => $values['username'],
                    'password' => $values['password'],
                    'host' => $values['host'],
                    'port' => $values['port']
                );
                OW::getSession()->set('ftpAttrs',$ftpParams);
            } else {
                $ftpParams = OW::getSession()->get('ftpAttrs');
            }

            $ftpConn = false;
            if ($ftpParams !== false) {
                $ftpConn = UTIL_Ftp::getConnection($ftpParams);
                $ftpConn->upload($tmpFile, 'robots.txt');
            }            
        }

        return true;
    }
}
