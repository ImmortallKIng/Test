<?php
use Bitrix\Main\Loader;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
Loader::includeModule("iblock");
$arComponentParameters = array(
    "PARAMETERS" => array(
        "VARIABLE_ALIASES" => array(
            "ELEMENT_CODE" => array(
                "NAME" => "Символьный код элемента",
            ),
            "SECTION_CODE" => array(
                "NAME" => "Символьный код раздела",
            ),
        ),
        "SEF_MODE" => array(             //Вкл/выкл режим ЧПУ. Каждый дочерний элемент - это шаблон, на котором подключаются простые компоненты.
            "section" => array(
                "NAME" => "Страница раздела",
                "DEFAULT" => "#SECTION_CODE#/",
                "VARIABLES" => array(
                    "SECTION_ID",
                    "SECTION_CODE",
                    "SECTION_CODE_PATH",
                ),
            ),
            "element" => array(
                "NAME" => "Детальная страница",
                "DEFAULT" => "#SECTION_CODE#/#ELEMENT_CODE#/",
                "VARIABLES" => array(
                    "ELEMENT_ID",
                    "ELEMENT_CODE",
                    "SECTION_ID",
                    "SECTION_CODE",
                    "SECTION_CODE_PATH",
                )
            )
        )
    )
);