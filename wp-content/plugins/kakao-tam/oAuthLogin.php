<?php
class oAuthLogin {
    function debug($type, $value){
        if(Constants::DEBUG){
            echo esc_html($type) . " : " . esc_html($value) . '<br/>';
        }
    }
}
