<?php
require( "config.php" );
require( "vendor/autoload.php" );
require( "data.php" );

$newsletters = new NewsletterParser();

$smarty = new Smarty();
$smarty->assign( "version", time() );
$smarty->assign( "metrics", CONFIG_METRICS );
$newsletters->getCountsFormat("%Y-%m-%d")->groupCountsByYearMonth();
$smarty->assign( "counts", $newsletters->data );

$canonical = CONFIG_HOME . "/";

$most_recent = $newsletters->getMostRecent();

if( isset( $_GET['all']) ) {
    // show all archived days
    $canonical .= "all/";
    $view = "all";
    $template = "all.tpl";

    $pubdate = $most_recent;
} else {
    $template = "home.tpl";

    if( !isset( $_GET['view']) ) {
        // show latest entry
        $view = $most_recent;
        $pubdate = $most_recent;
    } else {
        // show requested entry
        $view = $_GET['view'];
        $canonical .= "day-" . $view . "/";
        $pubdate = $view;
    }
}

$smarty->assign( "posts", $newsletters->getPosts($view) );

$smarty->assign( "home", CONFIG_HOME );
$smarty->assign( "canonical", $canonical );
$smarty->assign( "view", $view );

if( isset( $_GET['missing']) ) {
    $smarty->assign( "missing", true );
}

$smarty->assign( "pubdate", $pubdate );
$smarty->display( $template );
