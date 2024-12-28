<?

use Bitrix\Main\Type\DateTime;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (isset($arResult["CANONICAL"]) && !empty($arResult["CANONICAL"])) {
    $APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL"]);
}

if (isset($_REQUEST["REPORT_ADD"])) {
    $el = new CIBlockElement;
    if ($USER->IsAuthorized()) {
        $user = "ID: " . $USER->GetID() . ", Login:" . $USER->GetLogin() . ", Name:" . $USER->GetFullName();
    } else {
        $user = "Не авторизован";
    }

    $reportData = [
        'ACTIVE_FROM' => new \Bitrix\Main\Type\DateTime(),
        'USER' => '',
        'NEWS_ID' => $_REQUEST["REPORT_ADD"]
    ];

    if ($USER->IsAuthorized()) {
        $reportData['USER'] = implode(' - ', [$USER->GetID(), $USER->GetLogin(), $USER->GetFullName()]);
    }
    else {
        $reportData['USER'] = GetMessage('USER_UNAUTH');
    }

    $reportORM = new CIBLockElement;
    $elem = [
        'IBLOCK_ID' => 8,
        "NAME" => GetMessage('REPORT_NAME', ['#NEWS_ID#' => $reportData['NEWS_ID']]),
        'PROPERTY_VALUES' => [
            'USER' => $reportData['USER'],
            'NEWS_ID' => $reportData['NEWS_ID']
        ],
        'ACTIVE_FROM' => $reportData['ACTIVE_FROM']
    ];

    $reportId = $reportORM->Add($elem);
    if ($reportId > 0) {
        $msg = GetMessage('REPORT_SUCCESS', ['#REPORT_ID#' => $reportId]);
    }
    else {
        $msg = GetMessage('REPORT_ERROR');
    }

    if ($arParams["AJAX_REPORT"] === "Y") {
        $APPLICATION->RestartBuffer();
        echo json_encode([
            'content' => $msg
        ]);
        die();
    } else {
?>
        <script>
            document.getElementById('report-result').textContent = '<?= $msg ?>';
        </script>
<?
    }
}
