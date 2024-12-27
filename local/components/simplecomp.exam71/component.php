<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if (!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (!(
	intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0
	&& intval($arParams["CLASSIFIER_IBLOCK_ID"]) > 0
	&& !empty($arParams["CLASSIFIER_PROPERTY"])
)) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_UNCORECT_INPUT_PARAMS"));
	return;
}
$arNavParams = array(
	"nPageSize" => $arParams["ELEMENTS_ON_PAGE"],
	"bShowAll" => true,
);
$arNavigation = CDBResult::GetNavParams($arNavParams);
if ($this->StartResultCache($arParams["CACHE_TIME"],[$USER->GetGroups(), $arNavigation])) {
	$rsElements = CIBlockElement::GetList(
		[],
		[
			"IBLOCK_ID" => $arParams["CLASSIFIER_IBLOCK_ID"],
			"ACTIVE" => "Y"
		],
		false,
		$arNavParams,
		[
			"ID",
			"NAME",
		],
	);
	$classIds = [];
	while ($arElement = $rsElements->GetNext()) {
		$arResult["CLASSIFIER"][$arElement["ID"]] = $arElement;
		$classIds[] = $arElement["ID"];
	}
	$arResult["NAV_STRING"] = $rsElements->GetPageNavStringEx($navComponentObject, GetMessage("NAV_TITLE"), '', 'Y');

	$arResult["CLASS_COUNT"] = count($classIds);
	$this->SetResultCacheKeys(["CLASS_COUNT"]);


	$rsElements = CIBlockElement::GetList(
		[
			"NAME" => "ASC",
			"SORT" => "ASC",
		],
		[
			"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
			"ACTIVE" => "Y",
			"PROPERTY_".$arParams["CLASSIFIER_PROPERTY"] => $classIds
		],
		false,
		false,
		[
			"ID",
			"CODE",
			"IBLOCK_SECTION_ID",
			"IBLOCK_SECTION_CODE",
			"NAME",
			"PROPERTY_ARTNUMBER",
			"PROPERTY_MATERIAL",
			"PROPERTY_PRICE",
			"PROPERTY_".$arParams["CLASSIFIER_PROPERTY"]
		],
	);
	$prodIds = [];
	while ($arElement = $rsElements->GetNext()) {
		$arElement["DETAIL_PAGE_URL"] = str_replace(
			[
				"#ELEMENT_ID#",
				"#ELEMENT_CODE#",
				"#SECTION_ID#",
				"#SECTION_CODE#",
			],
			[
				$arElement["ID"],
				$arElement["CODE"],
				$arElement["IBLOCK_SECTION_ID"],
				$arElement["IBLOCK_SECTION_CODE"],
			],
			$arParams["DETAIL_PAGE_TEMPLATE"]
		);
		$arResult["CLASSIFIER"][$arElement["PROPERTY_".$arParams["CLASSIFIER_PROPERTY"]."_VALUE"]]["ITEMS"][$arElement["ID"]] = $arElement;
	}

	$this->includeComponentTemplate();
}
$APPLICATION->SetTitle(GetMessage("CLASS_COUNT", ["#COUNT#" => $arResult["CLASS_COUNT"]]));
