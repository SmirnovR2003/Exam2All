<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?
$APPLICATION->AddViewContent("PRODUCTS_PRICES",GetMessage(
    "PRODUCTS_PRICES",
    [
        "#MIN#" => $arResult["MIN_PRICE"],
        "#MAX#" => $arResult["MAX_PRICE"],
    ],
)); 
?>