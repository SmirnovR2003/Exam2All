<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("Ex2", "Ex2_50"));
class Ex2
{
	const PRODUCTS_IBLOCK_ID = 2;
	const MAX_SHOW_COUNTER = 2;
	public static function Ex2_50(&$arFields)
	{
		if($arFields["IBLOCK_ID"] == self::PRODUCTS_IBLOCK_ID && $arFields["ACTIVE"] === "N")
		{
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

			if($el = $rsEl->Fetch())
			{
				if($el["SHOW_COUNTER"] > self::MAX_SHOW_COUNTER)
				{
					global $APPLICATION;
					$APPLICATION->throwException(GetMessage("UNABLE_DICTIVATE_PRODUCT", ["#COUNT#" => $el["SHOW_COUNTER"]]));
					return false;
				}
			}
		}
	}
}
?>