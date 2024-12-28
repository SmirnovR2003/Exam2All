<?

use Bitrix\Main\Type\DateTime;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

function CheckUserCount()
{
    $lastTime = COption::GetOptionString("main", "registed_user_counter_time");
    if(!$lastTime)
    {
        $lastTime = (new DateTime(0));
    }
    else
    {
        $lastTime = DateTime::createFromText($lastTime);

    }

    $rsUsers = CUser::GetList(
        '',
        '',
        [
            "DATE_REGISTER_1" => $lastTime->toString()
        ],
        [
            "FIELDS" => ["ID"]
        ],
    );

    $userCount = 0;
    while ($rsUsers->Fetch()) {
        $userCount++;
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/myLog.log', print_r($userCount,true), FILE_APPEND);

    $rsUsers = CUser::GetList(
        '',
        '',
        [
            "GROUPS_ID" => 1
        ],
        [
            "FIELDS" => ["EMAIL"]
        ],
    );

    $adminEmails = [];
    while ($user = $rsUsers->Fetch()) {
        $adminEmails[] = $user["EMAIL"];
    }

    $curTime = new DateTime();
    $dif = $curTime->getTimestamp() - $lastTime->getTimestamp();
    $dif /= (60 * 60 * 24);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/myLog.log', print_r($dif,true)."\n", FILE_APPEND);

    $arEventFields = array(
        "EMAIL_TO" => implode(",", $adminEmails),
        "COUNT" => $userCount,
    );
    CEvent::Send("REGISTED_USER_COUNT", SITE_ID, $arEventFields);

    COption::SetOptionString("main", "registed_user_counter_time", $curTime->toString());
    
    return "CheckUserCount();";
}
