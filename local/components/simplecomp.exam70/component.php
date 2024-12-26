<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if (!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (
	intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0
	&& intval($arParams["NEWS_IBLOCK_ID"]) > 0
	&& !empty($arParams["NEWS_UF_LINK"])
) {
	if ($this->StartResultCache()) {
		$rsElements = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				"ACTIVE" => "Y"
			],
			false,
			false,
			[
				"ID",
				"NAME",
				"ACTIVE_FROM",
			],
		);
		$newsIds = [];
		while ($arElement = $rsElements->GetNext()) {
			$arResult["NEWS"][$arElement["ID"]] = $arElement;
			$newsIds[] = $arElement["ID"];
		}


		$rsSections = CIBlockSection::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				$arParams["NEWS_UF_LINK"] => $newsIds,
				"ACTIVE" => "Y"
			],
			false,
			[
				"ID",
				"NAME",
				$arParams["NEWS_UF_LINK"]
			],
			false
		);
		$sectionsIds = [-1];

		while ($arSection = $rsSections->GetNext()) {
			foreach ($arSection[$arParams["NEWS_UF_LINK"]] as $key => $value) {
				$arResult["NEWS"][$value]["SECTIONS"][$arSection["ID"]] = $arSection;
				$arResult["NEWS"][$value]["SECTIONS_NAMES"][] = $arSection["NAME"];
			}
			$sectionsIds[] = $arSection["ID"];
		}


		$rsElements = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"IBLOCK_SECTION_ID" => $sectionsIds,
				"ACTIVE" => "Y"
			],
			false,
			false,
			[
				"ID",
				"IBLOCK_SECTION_ID",
				"NAME",
				"PROPERTY_ARTNUMBER",
				"PROPERTY_MATERIAL",
				"PROPERTY_PRICE",
			],
		);
		$prodIds = [];
		while ($arElement = $rsElements->GetNext()) {
			foreach ($arResult["NEWS"] as $key => $value) {
				if (array_key_exists($arElement["IBLOCK_SECTION_ID"],$value["SECTIONS"])) {
					$arResult["NEWS"][$key]["ITEMS"][$arElement["ID"]] = $arElement;
				}
			}
			$prodIds[$arElement["ID"]]=$arElement["ID"];
		}

		$arResult["PRODUCTS_COUNT"] = count($prodIds);
		$this->SetResultCacheKeys(["PRODUCTS_COUNT"]);

		$this->includeComponentTemplate();
	}
	$APPLICATION->SetTitle(GetMessage("PRODUCTS_COUNT", ["#COUNT#"=>$arResult["PRODUCTS_COUNT"]]));
}
