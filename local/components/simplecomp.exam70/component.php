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
	&& intval($arParams["NEWS_IBLOCK_ID"]) > 0
	&& !empty($arParams["NEWS_UF_LINK"])
)) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_UNCORECT_INPUT_PARAMS"));
	return;
}
if ($this->StartResultCache(false, isset($_GET["F"]))) {
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


	$arFilter = [
		"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
		"IBLOCK_SECTION_ID" => $sectionsIds,
		"ACTIVE" => "Y"
	];

	if (isset($_GET["F"])) {
		$dopFilter = [
			"LOGIC" => "OR",
			[
				"<=PROPERTY_PRICE" => 1700,
				"PROPERTY_MATERIAL" => "Дерево, ткань"
			],
			[
				"<PROPERTY_PRICE" => 1500,
				"PROPERTY_MATERIAL" => "Металл, пластик"

			],
		];
		$arFilter[] = $dopFilter;
		$this->AbortResultCache();
	}


	$rsElements = CIBlockElement::GetList(
		[],
		$arFilter,
		false,
		false,
		[
			"ID",
			"IBLOCK_ID",
			"IBLOCK_SECTION_ID",
			"NAME",
			"PROPERTY_ARTNUMBER",
			"PROPERTY_MATERIAL",
			"PROPERTY_PRICE",
		],
	);
	$prodIds = [];
	while ($arElement = $rsElements->GetNext()) {

		$arButtons = CIBlock::GetPanelButtons(
			$arElement["IBLOCK_ID"],
			$arElement["ID"],
			0,
			array("SECTION_BUTTONS" => false, "SESSID" => false)
		);

		$arElement["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"] ?? '';
		$arElement["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"] ?? '';

		foreach ($arResult["NEWS"] as $key => $value) {
			if (!isset($value["SECTIONS"]))
				continue;
			if (array_key_exists($arElement["IBLOCK_SECTION_ID"], $value["SECTIONS"])) {
				$arResult["NEWS"][$key]["ITEMS"][$arElement["ID"]] = $arElement;
			}
		}
		$prodIds[$arElement["ID"]] = $arElement["ID"];
		$arResult["LAST_ITEM_IBLOCK_ID"] = $arElement["IBLOCK_ID"];
	}

	$arButtons = CIBlock::GetPanelButtons($arResult["LAST_ITEM_IBLOCK_ID"], 0, 0, array("SECTION_BUTTONS" => false));

	echo '<pre>';
	print_r($arButtons);
	echo '</pre>';
	$this->addIncludeAreaIcons(
		array_merge(
			CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons),
			[
				[
					'URL'   => $arButtons["submenu"]["element_list"]["ACTION_URL"],
					'TITLE' => GetMessage("IB_ADMIN"),
					"IN_PARAMS_MENU" => true,
				]
			]
		)
	);

	$arResult["PRODUCTS_COUNT"] = count($prodIds);
	$this->SetResultCacheKeys(["PRODUCTS_COUNT"]);
	$this->includeComponentTemplate();
}
$APPLICATION->SetTitle(GetMessage("PRODUCTS_COUNT", ["#COUNT#" => $arResult["PRODUCTS_COUNT"]]));
