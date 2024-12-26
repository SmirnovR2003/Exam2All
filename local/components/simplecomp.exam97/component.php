<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if (!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (!(
	intval($arParams["NEWS_IBLOCK_ID"]) > 0
	&& !empty($arParams["AUTHOR_PROPERTY"])
	&& !empty($arParams["USER_AUTHOR_PROPERTY"])
)) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_UNCORECT_INPUT_PARAMS"));
	return;
}
if ($this->StartResultCache($arParams["CACHE_TIME"], $USER->GetID())) {

	$rsUser = CUser::GetByID($USER->GetID());
	$curUser = $rsUser->Fetch();

	$rsUsers = CUser::GetList(

		($by = "id"), 
		($order = "asc"), 
		[
			"!ID" => $USER->GetID(),
			"ACTIVE" => "Y", 
			$arParams["USER_AUTHOR_PROPERTY"] => $curUser[$arParams["USER_AUTHOR_PROPERTY"]]
		], 
		[
			"FIELDS" => ["ID", "LOGIN"],
			"SELECT" => [$arParams["USER_AUTHOR_PROPERTY"]]
		]
	);
	$usersIds = [];
	while ($user = $rsUsers->GetNext()) {
		$arResult["USERS"][$user["ID"]] = $user;
		$usersIds[$user["ID"]]=$user["ID"];
	}
	
	$rsElements = CIBlockElement::GetList(
		[],
		[
			"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
			"ACTIVE" => "Y",
			"PROPERTY_".$arParams["AUTHOR_PROPERTY"] => array_keys($arResult["USERS"]),
		],
		false,
		false,
		[
		],
	);
	$newsIds = [];
	while ($arElement = $rsElements->GetNextElement()) {
		$props = $arElement->GetProperties();
		$fields = $arElement->GetFields();

		if(!in_array($curUser["ID"], $props[$arParams["AUTHOR_PROPERTY"]]["VALUE"]))
		{
			foreach ($props[$arParams["AUTHOR_PROPERTY"]]["VALUE"] as $key => $value) {
				if(!in_array($value, $usersIds))
					continue;
				$arResult["USERS"][$value]["NEWS"][$fields["ID"]] = $fields;
			}
			$newsIds[$fields["ID"]] = $fields;
		}
	}

	$arResult["NEWS_COUNT"] = count($newsIds);
	$this->SetResultCacheKeys(["NEWS_COUNT"]);

	$this->includeComponentTemplate();
}
$APPLICATION->SetTitle(GetMessage("NEWS_COUNT", ["#COUNT#" => $arResult["NEWS_COUNT"]]));
