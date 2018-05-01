<?php

class htmlTool{

    static function presentButton($elemType = "button", $type = "", $text = "", $class = "", $link = "#"){
        $accHtml = ""; // Accumalated html
        $accHtml = "<$elemType type='$type' class='$class' href='$link'>$text</$elemType>";
        return $accHtml;
    }
    static function presentLinkButton($link = "#", $class = "btn btn-primary", $text = ""){
        $accHtml = "";
        $accHtml .= "<a href='$link' class='$class'>$text</a>";
        return $accHtml;
    }
    static function presentIcon($class = "", $text = ""){
        $accHtml = "";
        $accHtml = "<i class='$class'>$text</i>";
        return $accHtml;
    }
    static function presentLinkIcon($link = "#", $icon = ""){
        $accHtml = "";
        $accHtml = "<a href='$link'><i class='material-icons'>$icon</i></a>";
        return $accHtml;
    }  
    
    static function date2local($date){
        $dkMonths = array(1 => "Januar", "Februar", "Marts", "April", "Maj", "Juni",
                        "Juli", "August", "September", "Oktober". "November");
        return date("j", $date).". ".$dkMonths[date("n",$date)]. "". date("y", $date);
    }
    static function datetime2local($date){
        return self::date2local($date) . " Kl ". date("H:i", $date);
    }
    static function boolTranslate($bool){
        $accHtml = "";
        if($bool){
            $accHtml = "Ja";
        } else {
            $accHtml = "Nej";
        }
        return $accHtml;
    }
}
// $values["created] = date(#d. M y H:i), $values["created]
?>