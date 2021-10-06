


$("#typePage").on("change", function(){
    switch(this.value){
        case "ONE":
            $(".minRangeText").text("Número del folio")
            $("#maxRange").hide(200);
            break;
        case "CUSTOM":
            $(".minRangeText").text("Minimo");
            $("input[name='maxRange']").val(0);
            $("#maxRange").show(200);
            break;
    }
});
$("input[name='minRange']").keyup(function(){
    if($("#typePage").val() === "ONE"){
        $("input[name='maxRange']").val($(this).val());
    }
});

