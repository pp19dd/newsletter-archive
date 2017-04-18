<?php
require( "vendor/autoload.php" );
require( "data.php" );
require( "config.php" );

$newsletters = new NewsletterParser();

$smarty = new Smarty();
$newsletters->getCountsFormat("%Y-%m-%d")->groupCountsByYearMonth();
$smarty->assign( "counts", $newsletters->data );

$canonical = CONFIG_HOME . "/";

if( isset( $_GET['all']) ) {
    $canonical .= "all/";
    $view = "all";
    $template = "all.tpl";
} else {
    $template = "home.tpl";

    if( !isset( $_GET['view']) ) {
        // show latest entry
        $very_first_year = array_shift($newsletters->data);
        $very_first_month = array_shift($very_first_year);
        $very_first_day = each($very_first_month);
        $view = $very_first_day["key"];
    } else {
        $view = $_GET['view'];
        $canonical .= "day-" . $view . "/";
    }
}

$smarty->assign( "posts", $newsletters->getPosts($view) );

$smarty->assign( "home", CONFIG_HOME );
$smarty->assign( "canonical", $canonical );
$smarty->assign( "view", $view );

if( isset( $_GET['missing']) ) {
    $smarty->assign( "missing", true );
}

$smarty->display( $template );
