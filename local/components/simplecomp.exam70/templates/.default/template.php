<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?= GetMessage("SIMPLECOMP_EXAM2_FILTER") ?> <a href="<?= $APPLICATION->GetCurPage() . "?F=Y" ?>"><?= $APPLICATION->GetCurPage() . "?F=Y" ?></a>
<br>
---
<br>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?>:</b></p>
<? if (!empty($arResult["NEWS"])) { ?>
    <ul>
        <? foreach ($arResult["NEWS"] as $key => $value) { ?>
            <? if (!empty($value)) { ?>
                <li>
                    <b><?= $value["NAME"] ?></b> - <?= $value["ACTIVE_FROM"] ?> (<?= !empty($value["SECTIONS_NAMES"]) ? implode(", ", $value["SECTIONS_NAMES"]) : "" ?>)
                    <? if (!empty($value["ITEMS"])) { ?>
                        <ul>
                            <? foreach ($value["ITEMS"] as $key => $arItem) { ?>
                                <?
                                $this->AddEditAction($value["ID"]."_".$arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($value["ID"]."_".$arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                ?>
                                <li id="<?= $this->GetEditAreaId($value["ID"]."_".$arItem['ID']); ?>">
                                    <?= $arItem["NAME"] ?>
                                    - <?= $arItem["PROPERTY_PRICE_VALUE"] ?>
                                    - <?= $arItem["PROPERTY_MATERIAL_VALUE"] ?>
                                    - <?= $arItem["PROPERTY_ARTNUMBER_VALUE"] ?>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </li>
            <? } ?>
        <? } ?>
    </ul>
<? } ?>