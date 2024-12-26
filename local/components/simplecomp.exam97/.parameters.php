<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"AUTHOR_PROPERTY" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_AUTHOR_PROPERTY"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"USER_AUTHOR_PROPERTY" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_USER_AUTHOR_PROPERTY"),
			"TYPE" => "STRING",
			"PARENT" => "BASE"
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);