<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
$this->setFrameMode(true); ?>
<section class="container">
    <form action="<?=$APPLICATION->GetCurPage();?>" name="APPLICATION_FORM" method="POST" class="application-form col-12">
        <?=bitrix_sessid_post();?>
        <div class="form-field col-2">
            <h2>Новая заявка</h2>
            <label for="application-title" class="application-title">
                <span>Заголовок заявки</span>
                <input
                    required
                    type="text"
                    id="application-title"
                    name="FIELDS[TITLE]"
                >
            </label>
        </div>
        <div class="form-field col-6">
            <h2>Категория</h2>
            <label for="application-category_0">
                <input
                    required
                    id="application-category_0"
                    type="radio"
                    name="FIELDS[CATEGORY]"
                    value="Масла, автохимия, фильтры. Аксессуары, обогреватели, запчасти, сопутствующие товары."
                >
                <span>Масла, автохимия, фильтры. Аксессуары, обогреватели, запчасти, сопутствующие товары.</span>
            </label>
            <label for="application-category_1">
                <input
                    required
                    id="application-category_1"
                    type="radio"
                    name="FIELDS[CATEGORY]"
                    value="Шины, диски"
                >
                <span>Шины, диски</span>
            </label>
        </div>
        <div class="form-field col-3">
            <h2>Вид заявки</h2>
            <label for="application-type_0">
                <input
                    required
                    id="application-type_0"
                    type="radio"
                    name="FIELDS[TYPE]"
                    value="Запрос цены и сроков поставки"
                >
                <span>Запрос цены и сроков поставки</span>
            </label>
            <label for="application-type_1">
                <input
                    required
                    id="application-type_1"
                    type="radio"
                    name="FIELDS[TYPE]"
                    value="Пополнение складов"
                >
                <span>Пополнение складов</span>
            </label>
            <label for="application-type_2">
                <input
                    required
                    id="application-type_2"
                    type="radio"
                    name="FIELDS[TYPE]"
                    value="Спецзаказ"
                >
                <span>Спецзаказ</span>
            </label>
        </div>
        <div class="form-field col-2">
            <h2>Склад поставки</h2>
            <select name="FIELDS[STOCK]" id="">
                <option value="">Выберите склад поставки</option>
                <option value="Склад №1">Склад №1</option>
                <option value="Склад №2">Склад №2</option>
                <option value="Склад №3">Склад №3</option>
                <option value="Склад №4">Склад №4</option>
            </select>
        </div>
        <div class="form-field col-8 inputs-line_parent">
            <h2>Состав заявки</h2>
            <div class="application-composition">
                <label for="application-brand">
                    <span>Бренд</span>
                    <select name="COMPOSITION[0][BRAND]" id="application-brand">
                        <option value="">Выберите бренд</option>
                        <option value="Бренд №1">Бренд №1</option>
                        <option value="Бренд №2">Бренд №2</option>
                        <option value="Бренд №3">Бренд №3</option>
                        <option value="Бренд №4">Бренд №4</option>
                    </select>
                </label>
                <label for="application-name">
                    <span>Наименование</span>
                    <input
                        id="application-name"
                        type="text"
                        name="COMPOSITION[0][NAME]"
                    >
                </label>
                <label for="application-quantity">
                    <span>Колличество</span>
                    <input
                        id="application-quantity"
                        type="number"
                        name="COMPOSITION[0][QUANTITY]"
                    >
                </label>
                <label for="application-packaging">
                    <span>Фасовка</span>
                    <input
                        id="application-packaging"
                        type="text"
                        name="COMPOSITION[0][PACKAGING]"
                    >
                </label>
                <label for="application-client">
                    <span>Клиент</span>
                    <input
                        id="application-client"
                        type="text"
                        name="COMPOSITION[0][CLIENT]"
                    >
                </label>
                <div class="add-input-line">
                    <input type="button" value="+" class="add-line">
                    <input type="button" value="-" class="delete-line">
                </div>
            </div>
        </div>
        <div class="form-field col-2">
            <input type="file" name="FILE" class="application-file">
        </div>
        <div class="form-field col-5">
            <label for="application-comment" class="application-comment">
                <span>Комментарий</span>
                <textarea
                    name="FIELDS[COMMENT]"
                    id="application-comment"
                    cols="30"
                    rows="10"></textarea>
            </label>
        </div>
        <div class="form-field col-2">
            <input type="submit">
        </div>
    </form>
</section>
<div class="form--dark_background ">
    <div class="dark_background--item_detail">
        <div class="dark_background--item--name"></div>
        <div class="dark_background--item--description"></div>
        <button class="form--response-button">Понятно</button>
    </div>
</div>