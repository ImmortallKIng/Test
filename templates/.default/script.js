$(function(){
    let $html = $("html"),
        $successfulDarkBackground = $(".form--dark_background"),
        $popUpTitle = $(".dark_background--item--name"),
        $popUpDescription = $(".dark_background--item--description"),
        $responseButton = $(".form--response-button");
        $input = $("input");

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
                        let $errorInput = $form.find("[name='" + Object.keys(data.ERRORS[i])[0]+ "']");
                        $errorInput.before("<div class='field-error'>" + Object.values(data.ERRORS[i]) + "</div>");
                        $errorInput.addClass("error_input");
                    }
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
});