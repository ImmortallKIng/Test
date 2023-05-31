$(function(){
    let $html = $("html"),
        $successfulDarkBackground = $(".form--dark_background"),
        $popUpTitle = $(".dark_background--item--name"),
        $popUpDescription = $(".dark_background--item--description"),
        $responseButton = $(".form--response-button"),
        $input = $("input"),
        lineIndex = 0;

    $("form.application-form").on("submit", function(event){
        event = event.originalEvent;
        event.preventDefault();
        let $form = $(this),
            pathName = window.location.pathname,
            formData = new FormData($form.get(0));
        formData.set("IS_AJAX", "Y");
        $.ajax({
            method: "POST",
            url: pathName,
            data: formData,
            contentType: false,
            processData: false,
            fileName: "FILE",
            success: function(data){
                data = JSON.parse(data);
                let $errorField = $(".field-error");
                if($errorField.length > 0){
                    $errorField.remove();
                    $(".add__form--input").removeClass("error_input");
                }
                if(data.STATUS === "ERROR"){
                    $form.before("<div class='form-errors'></div>");
                    for(let i = 0; i < data.ERRORS.length; i++){
                        let $errorInput = $form.find("[name='" + Object.keys(data.ERRORS[i])[0] + "']");
                        $errorInput.before("<div class='field-error'>" + Object.values(data.ERRORS[i]) + "</div>");
                        $errorInput.addClass("error_input");
                    }
                    $html.css("overflow", "hidden");
                    $successfulDarkBackground.css("display", "flex");
                    $popUpTitle.text("Ошибка!");
                    $popUpDescription.text("Исправьте ошибки в неправильно заполненных полях");
                    $responseButton.text("Понятно");
                }else{
                    $html.css("overflow", "hidden");
                    $successfulDarkBackground.css("display", "flex");
                    $popUpTitle.text("Принято!");
                    $popUpDescription.text("Ваша заявка успешно отправлена");
                    $responseButton.text("Понятно");
                }
            },
            error: function(data){
                console.error(data);
            }
        });
        if(event){
            event.preventDefault();
            event.stopPropagation();
        }
        return false;
    });

    $successfulDarkBackground.on("click", function(event){
        event.originalEvent;
        $this = $(this);
        if(event && $(event.target).closest(".show__news-preview_wrapper").length <= 0 && $this.css("display") === "flex"){
            event.stopPropagation();
            event.preventDefault();
            $html.css("overflow", "auto");
            $this.css("display", "none");
        }
    });

    $responseButton.on("click", function(event){
        event.stopPropagation()
        event.preventDefault();
        $html.css("overflow", "auto");
        $successfulDarkBackground.css("display", "none");
    });

    $input.on("input change", function(){
        let $this = $(this);
        $this.removeClass("error_input");
        $this.closest("label").find(".field-error").remove();
    });

    $(".add-line").on("click", function(){
        lineIndex++;
        let $inputLine = `<div class=\"form-field col-8 inputs-line\">\n` +
            "            <h2>Состав заявки</h2>\n" +
            "            <div class=\"application-composition\">\n" +
            "                <label for=\"application-brand\">\n" +
            "                    <span>Бренд</span>\n" +
            `                    <select name='COMPOSITION[${lineIndex}][BRAND]' id="application-brand">\n` +
            `                        <option value=\"\">Выберите бренд</option>\n` +
            `                        <option value=\"Бренд №1\">Бренд №1</option>\n` +
            `                        <option value=\"Бренд №2\">Бренд №2</option>\n` +
            `                        <option value=\"Бренд №3\">Бренд №3</option>\n` +
            `                        <option value=\"Бренд №4\">Бренд №4</option>\n` +
            "                    </select>\n" +
            "                </label>\n" +
            "                <label for=\"application-name\">\n" +
            "                    <span>Наименование</span>\n" +
            "                    <input\n" +
            "                        id=\"application-name\"\n" +
            "                        type=\"text\"\n" +
            `                        name=\"COMPOSITION[${lineIndex}][NAME]\"\n` +
            "                    >\n" +
            "                </label>\n" +
            "                <label for=\"application-quantity\">\n" +
            "                    <span>Колличество</span>\n" +
            "                    <input\n" +
            "                        id=\"application-quantity\"\n" +
            "                        type=\"number\"\n" +
            `                        name=\"COMPOSITION[${lineIndex}][QUANTITY]\"\n` +
            "                    >\n" +
            "                </label>\n" +
            "                <label for=\"application-packaging\">\n" +
            "                    <span>Фасовка</span>\n" +
            "                    <input\n" +
            "                        id=\"application-packaging\"\n" +
            "                        type=\"text\"\n" +
            `                         name=\"COMPOSITION[${lineIndex}][PACKAGING]\"\n` +
            "                    >\n" +
            "                </label>\n" +
            "                <label for=\"application-client\">\n" +
            "                    <span>Клиент</span>\n" +
            "                    <input\n" +
            "                        id=\"application-client\"\n" +
            "                        type=\"text\"\n" +
            `                        name=\"COMPOSITION[${lineIndex}][CLIENT]\"\n` +
            "                    >\n" +
            "                </label>\n" +
            "            </div>\n" +
            "        </div>";
        $(".inputs-line_parent").append($inputLine);
    });

    $(".delete-line").on("click", function(){
        $(".inputs-line_parent").find(".inputs-line:last-child").remove();
    });
});