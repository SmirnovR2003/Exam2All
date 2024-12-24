<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(isset($arResult["CANONICAL"]) && !empty($arResult["CANONICAL"]))
{
    $APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL"]);
}