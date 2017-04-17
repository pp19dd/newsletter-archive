<?php
require( "vendor/autoload.php" );
require( "data.php" );
require( "config.php" );

$newsletters = new NewsletterParser();

$smarty = new Smarty();
$newsletters->getCountsFormat("%Y-%m-%d")->groupCountsByYearMonth();
$smarty->assign( "counts", $newsletters->data );

$canonical = CONFIG_HOME . "/";

if( !isset( $_GET['view']) ) {
    // show latest entry
    $view = "2017-02-22";
} else {
    $view = $_GET['view'];
    $canonical .= "day-" . $view . "/";
}

$smarty->assign( "posts", $newsletters->getPosts($view) );

$smarty->assign( "home", CONFIG_HOME );
$smarty->assign( "canonical", $canonical );
$smarty->assign( "view", $view );

if( isset( $_GET['missing']) ) {
    $smarty->assign( "missing", true );
}

$smarty->display( "home.tpl" );
