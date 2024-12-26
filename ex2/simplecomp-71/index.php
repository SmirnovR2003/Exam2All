<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой компонент 71");
?><?$APPLICATION->IncludeComponent(
	"simplecomp.exam71", 
	".default", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CLASSIFIER_IBLOCK_ID" => "7",
		"CLASSIFIER_PROPERTY" => "FIRMA",
		"DETAIL_PAGE_TEMPLATE" => "detail/#ELEMENT_ID#/#ELEMENT_CODE#/#SECTION_ID#/#SECTION_CODE#/",
		"PRODUCTS_IBLOCK_ID" => "2",
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_GROUPS" => "Y"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>