<?
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/events/events.php"))
{
    include_once $_SERVER["DOCUMENT_ROOT"]."/local/php_interface/events/events.php";
}
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/agents/agents.php"))
{
    include_once $_SERVER["DOCUMENT_ROOT"]."/local/php_interface/agents/agents.php";
}