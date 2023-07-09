const mainSwiper1 = new Swiper('.swiper1',{
    slidesPerView:"auto",
    autoplay: {
        delay: 4000,
    },
})

const mainSwiper2 = new Swiper('.swiper2',{
    slidesPerView:"auto",
    autoplay: {
        delay: 4000,
    },
})

// $(function(){
//     if($('.top').length > 0 ){
//         $(window).on('scroll',function(e){
//             if(window.scrollY > 100){
//                 $('.menu-wrap').addClass('bg_white');
//                 console.log('test1')
//             }else{
//                 $('.menu-wrap').hasClass('bg_white') && $('.menu-wrap').removeClass('bg_white');
//                 console.log('test2')
//             }
//         })
//     }
// });
