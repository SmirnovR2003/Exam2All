<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
---
<br>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?>:</b></p>
<? if (!empty($arResult["NEWS"])) { ?>
    <ul>
        <? foreach ($arResult["NEWS"] as $key => $value) { ?>
            <li>
                <b><?= $value["NAME"] ?></b> - <?= $value["ACTIVE_FROM"] ?> (<?= implode(", ", $value["SECTIONS_NAMES"]) ?>)
                <? if (!empty($value["ITEMS"])) { ?>
                    <ul>
                        <? foreach ($value["ITEMS"] as $key => $value) { ?>
                            <li>
                                <?= $value["NAME"] ?>
                                - <?= $value["PROPERTY_PRICE_VALUE"] ?>
                                - <?= $value["PROPERTY_MATERIAL_VALUE"] ?>
                                - <?= $value["PROPERTY_ARTNUMBER_VALUE"] ?>
                            </li>
                        <? } ?>
                    </ul>
                <? } ?>
            </li>
        <? } ?>
    </ul>
<? } ?>