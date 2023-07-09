$(function(){
    if($('.performance-title').length > 0){
        $("#year").on("change",function(){
            $('.performance-wrapper').load(`${$('#year').val()}.html`);
        })
    }
});
