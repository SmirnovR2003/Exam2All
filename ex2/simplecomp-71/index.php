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
		"DETAIL_PAGE_TEMPLATE" => "/catalog_exam/#SECTION_ID#/#ELEMENT_CODE#.php",
		"PRODUCTS_IBLOCK_ID" => "2",
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_GROUPS" => "Y",
		"ELEMENTS_ON_PAGE" => "2"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>