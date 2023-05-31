<?php
use Bitrix\Main\Loader,
    Bitrix\Main\SystemException,
    Bitrix\Main\Mail\Event;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class SendApplication extends CBitrixComponent
{
    private array $arPost;
    private bool $bIsAjax;

    public function __construct($component = null)
    {
        parent::__construct($component);
        $this->arPost = $this->request->getPostList()->toArray();
        $this->arResult["STATUS"] = "SUCCESS";
        $this->arResult["ERRORS"] = array();
        $this->bIsAjax = $this->arPost["IS_AJAX"] === "Y";
    }

    private static function validateStringField($sString, bool $bIsRequired = false, string $sInputName = "", string $sPlaceHolder = "") : array
    {
        $sRegExp = "/^[A-zА-яЁё0-9\s,\.!?()_\-+=;:«»@#$^*№ ]+$/u";
        $arResult = array(
            "SUCCESS" => true,
            "ERRORS" => array(),
            "DEBUG" => array(),
        );
        $sString = trim($sString);
        $sString = strip_tags($sString);
        if($bIsRequired && empty($sString)){
            $arResult["SUCCESS"] = false;
            $arResult["ERRORS"][] = array($sInputName => "Поле $sPlaceHolder обязательно для заполнения");
        }else if(!empty($sString) && !preg_match($sRegExp, $sString)){
            $arResult["SUCCESS"] = false;
            $arResult["ERRORS"][] = array($sInputName => "Поле $sPlaceHolder заполнено неверно");
        }
        return $arResult;
    }

    private function validateRequest(): void
    {
        $arInputFields = $this->arPost["FIELDS"];
        $arValidatedRequestFields = array(
            "CATEGORY" => SendApplication::validateStringField($arInputFields["CATEGORY"], true, "FIELDS[CATEGORY]", "Категория"),
            "COMMENT" => SendApplication::validateStringField($arInputFields["COMMENT"], false, "FIELDS[COMMENT]", "Комментарий"),
            "STOCK" => SendApplication::validateStringField($arInputFields["STOCK"], false, "FIELDS[STOCK]", "Склад поставки"),
            "TITLE" => SendApplication::validateStringField($arInputFields["TITLE"], true, "FIELDS[TITLE]", "Заголовок Заявки"),
            "TYPE" => SendApplication::validateStringField($arInputFields["TYPE"], true, "FIELDS[TYPE]", "Вид заявки"),
        );
        foreach($arValidatedRequestFields as $arField){
            $this->arResult["ERRORS"] = array_merge($this->arResult["ERRORS"], $arField["ERRORS"]);
        }
        foreach($this->arPost["COMPOSITION"] as $arComposition){
            $arValidateComposition = array(
                "BRAND" => SendApplication::validateStringField($arComposition["BRAND"], false, "COMPOSITION[BRAND]", "Брэнд"),
                "CLIENT" => SendApplication::validateStringField($arComposition["CLIENT"], false, "COMPOSITION[CLIENT]", "Клиент"),
                "NAME" => SendApplication::validateStringField($arComposition["NAME"], false, "COMPOSITION[NAME]", "Наименование"),
                "PACKAGING" => SendApplication::validateStringField($arComposition["PACKAGING"], false, "COMPOSITION[PACKAGING]", "Фасовка"),
                "QUANTITY" => SendApplication::validateStringField($arComposition["QUANTITY"], false, "COMPOSITION[QUANTITY]", "Количество"),
            );
            foreach($arValidateComposition as $arCompositionField){
                $this->arResult["ERRORS"] = array_merge($this->arResult["ERRORS"], $arCompositionField["ERRORS"]);
            }
        }

        if(count($this->arResult["ERRORS"]) > 0 || !check_bitrix_sessid()){
            $this->arResult["STATUS"] = "ERROR";
        }
    }

    private function sendEmail(): void
    {
        $arParams = array(
            "BRAND" => $arInputFields["BRAND"],
            "CLIENT" =>$arInputFields["CLIENT"],
            "NAME" => $arInputFields["NAME"],
            "PACKAGING" => $arInputFields["PACKAGING"],
            "QUANTITY" => $arInputFields["QUANTITY"],
            "CATEGORY" => $arInputFields["CATEGORY"],
            "COMMENT" => $arInputFields["COMMENT"],
            "STOCK" => $arInputFields["STOCK"],
            "TITLE" => $arInputFields["TITLE"],
            "TYPE" => $arInputFields["TYPE"],
            "FILE" => $_FILES["FILE"],
        );
        Event::send(array(
                "EVENT_NAME" => "SEND_APPLICATION",
                "LID" => "s1",
                "C_FIELDS" => $arParams,
            )
        );
    }

    private function setResult() : void
    {
        if(!empty($this->arPost["FIELDS"])){
            $this->validateRequest();
            if($this->arResult["STATUS"] !== "ERROR"){
                $this->sendEmail();
                $this->arResult["REQUEST"] = $arInputFields;
            }
        }
    }

    public function executeComponent()
    {
        global $APPLICATION;
        try{
            if(Loader::includeModule("iblock")){
                $this->setResult();
                if($this->bIsAjax){
                    $APPLICATION->RestartBuffer();
                    echo json_encode($this->arResult, JSON_UNESCAPED_UNICODE);
                    CMain::FinalActions();
                }
                $this->includeComponentTemplate();
            }else{
                throw new SystemException("Модуль iblock не подключен!");
            }
        }catch(Exception $oException){
            AddMessage2Log("Ошибка в компоненте " . $this->__name . "! ERROR: " . $oException->getMessage());
        }
    }
}