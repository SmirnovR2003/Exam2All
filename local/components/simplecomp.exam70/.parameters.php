<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"NEWS_UF_LINK" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_UF_LINK"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);