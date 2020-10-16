<?php

class Functions
{

    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

    }

    public function show_msg($msg, $type)
    {
        $alert = "";
        switch ($type) {
            case 'info':
                $alert = '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert">&times;</a>' . $msg . '</div>';
                break;
            case 'error':
                $alert = '<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert">&times;</a>' . $msg . '</div>';
                break;

        }

        return $alert;
    }

    function strip_tags_content($text, $tags = '', $invert = FALSE) {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if(is_array($tags) AND count($tags) > 0) {
            if($invert == FALSE) {
                return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            }
            else {
                return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
            }
        }
        elseif($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }
}