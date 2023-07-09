$(function(){

    if($('.footer').hasClass('index')){
        $('.footer .container .text-white').load('./html/footer.html');
    }else{
        $('.footer .container .text-white').load('../html/footer.html');
    }
});
