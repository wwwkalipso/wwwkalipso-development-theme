
(function($){
    wp.customize('wwwkalipso_my_settings', function(value) {
        console.log(value)
        value.bind(function(newval) {
            $("#wwwkalipso_my_settings").html(newval);
        } );
    });
    wp.customize('wwwkalipso_my_test_settings', function(value) {
        console.log(value)
        value.bind(function(newval) {
            $("#wwwkalipso_my_test_settings").html(newval);
        } );
    });

})(jQuery);