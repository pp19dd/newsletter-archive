<?php
require( "vendor/autoload.php" );
require( "data.php" );
require( "config.php" );

$newsletters = new NewsletterParser();

$smarty = new Smarty();
$smarty->assign( "counts", $newsletters->getCountsFormat("%Y-%m-%d") );

$smarty->display( "home.tpl" );
