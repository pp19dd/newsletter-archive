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
                "`meta_key`='timeline_renderer' and " .
                "`meta_value`='timeline_renderer_newsletter' and " .
                "`wp_posts`.`post_status`='publish' " .
            "group by `time-unit` " .
            "order by `time-unit` desc"
        )->Index("time-unit")->Flatten("rows");

        return( $this );
    }

    function groupCountsByYearMonth() {
        $r = array();
        foreach( $this->data as $date => $count ) {
            $ts = strtotime($date);
            $year = date("Y", $ts );
            $month = date("F", $ts );

            if( !isset($r[$year]) ) $r[$year] = array();
            if( !isset($r[$year][$month]) ) $r[$year][$month] = array();
            $r[$year][$month][$date] = $count;
        }
        $this->data = $r;
        return( $this );
    }

    function getPostIDs($date) {
        $this->Query(
            "select " .
                "`wp_posts`.`ID`, " .
                "`wp_posts`.`post_title` " .
            "from `wp_postmeta` " .
            "left join `wp_posts` " .
                "on `wp_posts`.`ID`=`wp_postmeta`.`post_id` " .
            "where " .
                "`meta_key`='timeline_renderer' and " .
                "`meta_value`='timeline_renderer_newsletter' and " .
                "`wp_posts`.`post_status`='publish' and " .
                "date(`wp_posts`.`post_date`)=:reqdate " .
            "order by `wp_posts`.`post_date` desc",
            array(
                "reqdate" => date("Y-m-d", strtotime($date) )
            )
        );
        return( $this );
    }

    function sanitize_post($post) {
        $post = mb_convert_encoding($post, "HTML-ENTITIES", "UTF-8");

        $doc = new DOMDocument();
        @$doc->loadHTML($post);
        $xpath = new DOMXpath($doc);

        // cleanup the insides
        // $elements = $xpath->evaluate("//*");
        // for( $i = 0; $i < $elements->length; $i++ ) {
        //     $element = $elements->item($i);
        //     $element->removeAttribute("style");
        // }

        // save modified html
        $generate = $doc->saveHTML($doc);

        // cheap, but, return only everything in the body block
        $pos_a = stripos($generate, "<body");
        $pos_b = stripos($generate, "</body>");

        // hack #2 : replace body tag with something else
        $middle = substr($generate, $pos_a, ($pos_b - $pos_a) + 7 );
        $middle = str_replace(
            array("<body", "</body>"),
            array("<newsletter-body", "</newsletter-body>"),
            $middle
        );

        return( $middle );
    }

    function sanitize($posts) {
        foreach( $posts as $k => $post ) {
            $posts[$k]["html"] = $this->sanitize_post($post["html"]);
        }
        return( $posts );
    }

    function getPosts($date) {
        $cache_filename = "cache/" . md5($date) . ".html";

        if( file_exists($cache_filename) ) {
            return( $this->sanitize(unserialize(file_get_contents($cache_filename)), true) );
        }

        $this->getPostIDs($date);
        $r = array();
        foreach( $this->data as $post ) {
            $url = sprintf(
                "%s/preview/?timeline=%s&preview&format=bare&archive",
                CONFIG_TE,
                $post["ID"]
            );

            $r[] = array(
                "ID" => $post["ID"],
                "title" => $post["post_title"],
                "html" => file_get_contents($url)
            );
        }

        file_put_contents($cache_filename, serialize($r));
        return( $this->sanitize($r) );
    }
}
