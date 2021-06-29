<?php
class Validation
{
    static function isRequired($param){
        if(empty($param)){
            return false;
        } else {
            return true;
        }
    }
}
?>