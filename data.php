<?php

class NewsletterParser {

    function __construct() {
        $this->data = array();

        try {
            $this->db = new PDO(CONFIG_DSN, CONFIG_USER, CONFIG_PASS);
        } catch( Exception $e ) {
            die( "DB error" );
        }
    }

    function Query($sql, $params = array()) {
        $this->statement = $this->db->prepare( $sql );
        $this->statement->execute( $params );
        $this->data = $this->statement->fetchAll(PDO::FETCH_ASSOC);
        return( $this );
    }

    function Index($by) {
        $r = array();
        foreach( $this->data as $k => $v ) {
            $r[$v[$by]] = $v;
        }
        $this->data = $r;
        return( $this );
    }

    function Flatten($by) {
        $r = array();
        foreach( $this->data as $k => $v ) {
            $r[$k] = $v[$by];
        }
        $this->data = $r;
        return( $this );
    }

    function getCounts() {
        # return( $this->getCountsFormat("%Y-%m-%d") ); # y-m-d
        return( $this->getCountsFormat("%Y-%m") ); # y-m
        # return( $this->getCountsFormat("%x-%u") ); # y-w
    }

    function getCountsFormat($date_format) {

        $this->Query(
            "select " .
                "count(*) as `rows`, " .
                "date_format(`post_date`, '{$date_format}') as `time-unit` " .
            "from `wp_postmeta` " .
            "left join `wp_posts` " .
                "on `wp_posts`.`ID`=`wp_postmeta`.`post_id` " .
            "where " .
                "`meta_key`='timeline_renderer' " .
                "and `meta_value`='timeline_renderer_newsletter' and " .
                "`wp_posts`.`post_status`='publish' " .
            "group by `time-unit` " .
            "order by `time-unit` desc"
        )->Index("time-unit")->Flatten("rows");

        return( $this->data );
    }

}
