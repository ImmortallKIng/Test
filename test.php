<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->IncludeComponent(
    "test:sendApplication",
    ".default",
    array()
);