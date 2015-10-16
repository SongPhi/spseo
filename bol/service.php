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
 * Description here
 * 
 * @author Thao Le <thaolt@songphi.com>
 * @package spseo.bol
 * @since 1.0
 */

class SPSEO_BOL_Service
{
    const PLUGIN_NAME = 'spseo';
    const PLUGIN_VER = 'v1.1.3';
    protected static $classInstance = null;

    private $bridges;
    private $patterns;
    private $collected;

    public $char_map;

    protected function __construct() {
        $this->bridges = array();
        $this->patterns = array();
        $this->collected = array();
        $this->char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
            'ß' => 'ss', 
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
            'Ž' => 'Z', 
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z', 

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
            'Ż' => 'Z', 
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z',

            // Vietnamese
            'á' => 'a', 'à' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a', 'â' => 'a', 
            'ấ' => 'a', 'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a', 'ă' => 'a', 
            'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a', 'é' => 'e', 
            'è' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e', 'ê' => 'e', 'ế' => 'e', 
            'ề' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e', 'í' => 'i', 'ì' => 'i', 
            'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i', 'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 
            'õ' => 'o', 'ọ' => 'o', 'ô' => 'o', 'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 
            'ỗ' => 'o', 'ộ' => 'o', 'ơ' => 'o', 'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 
            'ỡ' => 'o', 'ợ' => 'o', 'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 
            'ụ' => 'u', 'ư' => 'u', 'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 
            'ự' => 'u', 'đ' => 'd'
        );
    }

    public function registerBridge($instance, $patterns) {
        $className = get_class($instance);
        $this->bridges[$className] = $instance;
        foreach ($patterns as $key => $value) {
            $patterns[$key] = array('class'=>$className,'callback'=>$value);
        }

        $this->patterns = array_merge($this->patterns, $patterns);
    }

    public static function getInstance() {
        if ( null === self::$classInstance ) {
            self::$classInstance = new self();
        }
        return self::$classInstance;
    }

    public static function getPlugin() {
        return OW::getPluginManager()->getPlugin(self::PLUGIN_NAME);
    }

    public static function getJsUrl($filename) {
        return self::getPlugin()->getStaticJsUrl() . $filename . '.js?'.(self::PLUGIN_VER);
    }

    public static function getCssUrl($filename) {
        return self::getPlugin()->getStaticCssUrl() . $filename . '.css?'.(self::PLUGIN_VER);
    }

    public static function getRoute() {
        $route = OW::getRequestHandler()->getHandlerAttributes();
        if (is_array($route)) {
            return $route;
        }
        return false;
    }

    public static function isRoute( $controller, $action = null ) {
        $route = self::getRoute();

        if ( !$route )
            return false;

        if ( $route["controller"] == $controller ) {
            if ( $route["action"] == $action || !$action ) {
                return true;
            }
        }

        return false;
    }

    public static function declareRoutes() {
        // admin routes
        OW::getRouter()->addRoute(new OW_Route('spseo.admin', 'admin/plugins/spseo', 'SPSEO_CTRL_Admin', 'index'));
        // OW::getRouter()->addRoute(new OW_Route('spseo.admin_pages', 'admin/plugins/spseo/pages', 'SPSEO_CTRL_Admin', 'pages'));
        // OW::getRouter()->addRoute(new OW_Route('spseo.admin_urls', 'admin/plugins/spseo/urls', 'SPSEO_CTRL_Admin', 'index'));
        // OW::getRouter()->addRoute(new OW_Route('spseo.admin_sitemap', 'admin/plugins/spseo/sitemap', 'SPSEO_CTRL_Admin', 'index'));
        OW::getRouter()->addRoute(new OW_Route('spseo.admin_robotstxt', 'admin/plugins/spseo/robotstxt', 'SPSEO_CTRL_Admin', 'robotstxt'));
        OW::getRouter()->addRoute(new OW_Route('spseo.admin_help', 'admin/plugins/spseo/help', 'SPSEO_CTRL_Admin', 'help'));

        // front routes
        OW::getRouter()->addRoute(new OW_Route('spseo.savepage', 'spseo/savepage', 'SPSEO_CTRL_Spseo', 'savepage'));
        OW::getRouter()->addRoute(new OW_Route('spseo.cleancache', 'spseo/cleancache', 'SPSEO_CTRL_Spseo', 'cleancache'));
    }

    public function handleRoutes() {
        $uri = OW::getRouter()->getUri();
        $seoUrl = SPSEO_BOL_UrlService::getInstance()->findByUri( $uri );

        if (is_object($seoUrl)) {
            header("HTTP/1.1 301 Moved Permanently"); 
            header("Location: ".OW::getRouter()->getBaseUrl().$seoUrl->friendly_uri); die();
        }

        foreach ($this->bridges as $bridge) {
            $id = $bridge->handleRoutes();
            if ($id!==false) {
                $cacheService = SPSEO_BOL_CacheService::getInstance();
                $ogdata = $cacheService->getOpenGraphData();
                if ($ogdata === false) {
                    $ogdata = $bridge->getOpenGraphData($id);
                }
                if ($ogdata !== false) {
                    $cacheService->setOpenGraphData($ogdata);
                }
                break;
            }
        }
    }

    private function modifyLink( $matches ) {
        $uri = $matches[1];
        $id = $matches[3];

        $cacheService = SPSEO_BOL_CacheService::getInstance();
        $friendlyUri = $cacheService->findFriendlyUri($uri);
        
        if ($friendlyUri !== false) 
            return OW::getRouter()->getBaseUrl().$friendlyUri;
        
        $urlService = SPSEO_BOL_UrlService::getInstance();
        $hash = crc32($uri);

        $prefix = substr($uri, 0, 0-strlen($id) );

        $class = isset( $this->patterns[ $prefix ] ) ? $this->patterns[ $prefix ]['class'] : false;
        $callback = isset( $this->patterns[ $prefix ] ) ? $this->patterns[ $prefix ]['callback'] : false;

        $bridge = $class ? $this->bridges[ $class ] : false;

        if ($bridge !== false) {

            $friendlyUri = $urlService->findByUri($uri);

            if (is_object($friendlyUri)) {
                $friendlyUri = $friendlyUri->friendly_uri;
            } else {
                $friendlyUri = call_user_func_array(array($bridge, $callback), array( $id )) ;
                $urlService->insert($uri,$friendlyUri,$prefix,$id,$hash,$cacheService->pageHash());
            }
            $this->collected[] = $hash;

            $cacheService->updateFriendlyUri( $uri, $friendlyUri );
            return OW::getRouter()->getBaseUrl().$friendlyUri;
        }

        $cacheService->updateFriendlyUri( $uri, $uri );
        return OW::getRouter()->getBaseUrl().$uri;
    }

    public function applyPageModifications() {
        $cacheService = SPSEO_BOL_CacheService::getInstance();
        $doc = OW::getDocument();
        $newbody = $doc->getBody();
        // $time = microtime();
        $baseurl = preg_quote(OW::getRouter()->getBaseUrl(),'#');
        $pattern = '#'.$baseurl.'(([a-z0-9\-\_]+\/)+(\d+))#i';
        $newbody = preg_replace_callback($pattern, array($this,'modifyLink'), $newbody);
        // die(microtime()-$time);
        
        if (count($this->collected)>0)
            SPSEO_BOL_PageUrlsDao::getInstance()->updatePageUrls($cacheService->pageHash(), $this->collected);

        $doc->setBody($newbody);

        // modify page meta data
        $meta = $cacheService->getMetaData();
        $ogdata = $cacheService->getOpenGraphData();

        if (isset($meta['meta_description']) && strlen($meta['meta_description'])>0) {
            $doc->setDescription($meta['meta_description']);
        }

        if (isset($meta['meta_keywords']) && strlen($meta['meta_keywords'])>0) {
            $doc->setKeywords($meta['meta_keywords']);
        }

        if ($ogdata!==false && is_array($ogdata)) {
            foreach ($ogdata as $key => $value) {
                $doc->addMetaInfo('og:'.$key,$value,"property");
            }
        }
    }

    public function slugify($text) {
        $text = htmlspecialchars_decode($text);
        $text = str_replace(array_keys($this->char_map), $this->char_map, $text);
        $text = strtolower($text);
        
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = preg_replace('/[^a-z0-9\-]/i', '-', $text);
     
        $text = trim($text, '-');
     
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
     
        $text = preg_replace('~[^-\w]+~', '', $text);
     
        if (empty($text))
        {
            return 'n-a';
        }
     
        return $text;
    }

    public function defaultRobotsTxt() {
        $content = <<<TEXT
# 
# This file contains rules to prevent the crawling and indexing of certain parts 
# of your web site by spiders of a major search engines likes Google and Yahoo. 
# By managing these rules you can allow or disallow access to specific folders
# and files for such spyders. 
# The good way to hide private data or save a lot of bandwidth. 
#
#
# For more information about the robots.txt standard, see:
# http://www.robotstxt.org/wc/robots.html
#
# For syntax checking, see:
# http://www.sxw.org.uk/computing/robots/check.html


User-agent: *

#Files
Disallow: ow_version.xml
Disallow: INSTALL.txt
Disallow: LICENSE.txt
Disallow: README.txt
Disallow: UPDATE.txt
Disallow: CHANGES.txt

# URLs
Disallow: /admin/
TEXT;
        return $content;
    }

    public function getTempDir() {
        return self::getPlugin()->getPluginFilesDir() . 'tmp';
    }
    
}
