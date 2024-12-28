<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach ($arResult["VARIABLES"] as $key => $value) {
    echo $key . " => " . $value . "<br>";
}
?>