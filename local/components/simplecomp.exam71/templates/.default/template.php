<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
---
<br>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?>:</b></p>
<?if (!empty($arResult["CLASSIFIER"])) { ?>
    <ul>
        <? foreach ($arResult["CLASSIFIER"] as $key => $value) { ?>
            <?if (!empty($value)) {?>
            <li>
                <b><?= $value["NAME"] ?></b>
                <? if (!empty($value["ITEMS"])) { ?>
                    <ul>
                        <? foreach ($value["ITEMS"] as $key => $value) { ?>
                            <li>
                                <?= $value["NAME"] ?>
                                - <?= $value["PROPERTY_PRICE_VALUE"] ?>
                                - <?= $value["PROPERTY_MATERIAL_VALUE"] ?>
                                - <?= $value["PROPERTY_ARTNUMBER_VALUE"] ?>
                                - <?= $value["DETAIL_PAGE_URL"] ?>
                            </li>
                        <? } ?>
                    </ul>
                <? } ?>
            </li>
            <?}?>
        <? } ?>
    </ul>
<? } ?>