<?php

/**
* 
*/
class SPSEO_CMP_ConsoleComponent extends BASE_CMP_ConsoleDropdownHover
{
	public function __construct()
    {
        parent::__construct('SEO');

        $languages = BOL_LanguageService::getInstance()->getLanguages();
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
