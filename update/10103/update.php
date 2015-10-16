<?php

$plugin = OW::getPluginManager()->getPlugin('spseo');
$pluginFilesDir = $plugin->getPluginFilesDir();
$cacheDir = $pluginFilesDir . DIRECTORY_SEPARATOR . 'cache';

if ( file_exists($cacheDir) ) {
    UTIL_File::removeDir($cacheDir);
}

mkdir($cacheDir);

