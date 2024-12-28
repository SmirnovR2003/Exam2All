<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arParams["CANONICAL"]) && intval($arParams["CANONICAL"])>0)
{
    $rsCanonical = CIBlockElement::GetList(
        [],
        [
            "IBLOCK_ID"=>$arParams["CANONICAL"],
            "PROPERTY_NEW" => $arResult["ID"]
        ],
        false,
        false,
        [
            "ID",
            "NAME"
        ],
    );
    if($canonical = $rsCanonical->Fetch())
    {
        $arResult["CANONICAL"] = $canonical["NAME"];
        $this->__component->SetResultCacheKeys(["CANONICAL"]);
    }
}