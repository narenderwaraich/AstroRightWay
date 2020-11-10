

$(window).scroll(function() {    
    var topHigh = $(window).scrollTop();  
    if (topHigh > 100) {
        $(".header-top").addClass("fix-head-menu");
    }else{
    	$(".header-top").removeClass("fix-head-menu");
    }
});
