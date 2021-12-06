<?php

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/../../../../');
require_once(DOKU_INC . 'inc/init.php');
if(!defined('DOKU_TPL')) define('DOKU_TPL', tpl_basedir());

$helper = plugin_load('helper', 'linkscollection');
global $conf;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>" lang="<?php echo $conf['lang']?>" dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php $helper->getLang('title'); ?></title>
        <?php tpl_metaheaders()?>
        <link rel="shortcut icon" href="<?php echo DOKU_TPL?>images/favicon.ico" />
    </head>
    <body>
        <div class="dokuwiki">
            <?php echo $helper->locale_xhtml('intro'); ?>
            <div id="plugin_linkscollection__wrapper">
                <?php echo $helper->getSitemap(); ?>
                <button type="submit" id="plugin_linkscollection__insert"><?php echo $helper->getLang('button'); ?></button>
            </div>
        </div>
    </body>
</html>
