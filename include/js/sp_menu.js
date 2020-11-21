jQuery(function($){
    $('.sp_menu').on('click',function(){
        $('.menu__line').toggleClass('active');
        $('.header_nav').fadeToggle();
    });
});