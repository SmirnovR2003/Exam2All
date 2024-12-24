<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SPECIALDATE" => Array(
		"NAME" => GetMessage("SPECIALDATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		"PARENT" => 'BASE',
	),
	"CANONICAL" => Array(
		"NAME" => GetMessage("CANONICAL"),
		"TYPE" => "STRING",
		"PARENT" => 'BASE',
	),
);
?>
