<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
---
<br>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?>:</b></p>
<?if (!empty($arResult["USERS"])) { ?>
    <ul>
        <? foreach ($arResult["USERS"] as $key => $value) { ?>
            <?if (!empty($value)) {?>
            <li>
                [<?= $value["ID"] ?>] - <?= $value["LOGIN"] ?>
                <? if (!empty($value["NEWS"])) { ?>
                    <ul>
                        <? foreach ($value["NEWS"] as $key => $value) { ?>
                            <li>
                                <?= $value["NAME"] ?>
                            </li>
                        <? } ?>
                    </ul>
                <? } ?>
            </li>
            <?}?>
        <? } ?>
    </ul>
<? } ?>