<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("Ex2", "Ex2_50"));
AddEventHandler("main", "OnEpilog", array("Ex2", "Ex2_93"));
AddEventHandler("main", "OnBeforeEventAdd", array("Ex2", "Ex2_51"));
AddEventHandler("main", "OnBuildGlobalMenu", array("Ex2", "Ex2_95"));
class Ex2
{
	const PRODUCTS_IBLOCK_ID = 2;
	const MAX_SHOW_COUNTER = 2;
	public static function Ex2_50(&$arFields)
	{
		if ($arFields["IBLOCK_ID"] == self::PRODUCTS_IBLOCK_ID && $arFields["ACTIVE"] === "N") {
			$rsEl = CIBlockElement::GetList(
				[],
				[
					"IBLOCK_ID" => self::PRODUCTS_IBLOCK_ID,
					"ID" => $arFields["ID"]
				],
				false,
				false,
				[
					"ID",
					"SHOW_COUNTER"
				]

			);

			if ($el = $rsEl->Fetch()) {
				if ($el["SHOW_COUNTER"] > self::MAX_SHOW_COUNTER) {
					global $APPLICATION;
					$APPLICATION->throwException(GetMessage("UNABLE_DICTIVATE_PRODUCT", ["#COUNT#" => $el["SHOW_COUNTER"]]));
					return false;
				}
			}
		}
	}

	public static function Ex2_93()
	{
		if (defined("ERROR_404") && ERROR_404 === "Y") {
			global $APPLICATION;
			CEventLog::Add(
				[
					"SEVERITY" => "INFO",
					"AUDIT_TYPE_ID" => "ERROR_404",
					"MODULE_ID" => "main",
					"DESCRIPTION" => $APPLICATION->GetCurPage(),
				]
			);
		}
	}

	public static function Ex2_51(&$event, &$lid, &$arFields)
	{
		if ($event === "FEEDBACK_FORM") {
			global $USER;
			$str = "";
			if ($USER->IsAuthorized()) {
				$str = GetMessage(
					"FEEDBACK_AUTH",
					[
						"#ID#" => $USER->GetID(),
						"#LOGIN#" => $USER->GetLogin(),
						"#USER_NAME#" => $USER->GetFirstName(),
						"#NAME#" => $arFields["AUTHOR"],
					]
				);
			} else {
				$str = GetMessage(
					"FEEDBACK_NOT_AUTH",
					[
						"#NAME#" => $arFields["AUTHOR"],
					]
				);
			}

			$arFields["AUTHOR"] = $str;
		}
	}

	public static function Ex2_95(&$aGlobalMenu, &$aModuleMenu)
	{
		global $USER;
		$adminId = 1;
		$contentId = 5;
		$groups = $USER->GetUserGroupArray();
		if(!(!in_array($adminId,$groups) && in_array($contentId,$groups)))
		{
			return;
		}
		$aGlobalMenu = ["global_menu_content"=>$aGlobalMenu["global_menu_content"]];
		foreach($aModuleMenu as $key => $value)
		{
			if($value["items_id"] === "menu_iblock_/news")
			{
				$newaModuleMenu = [$key => $value];
				break;
			}
		}
		$aModuleMenu = $newaModuleMenu;
	}
}
