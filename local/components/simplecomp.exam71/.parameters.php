<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"CLASSIFIER_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIFIER_IBLOCK_ID"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"DETAIL_PAGE_TEMPLATE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_DETAIL_PAGE_TEMPLATE"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"CLASSIFIER_PROPERTY" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIFIER_PROPERTY"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"ELEMENTS_ON_PAGE" => array(
			"NAME" => GetMessage("ELEMENTS_ON_PAGE"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);