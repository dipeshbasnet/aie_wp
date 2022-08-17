(function ($) {

    $(window).on('elementor/frontend/init', function () {

        //Time range condition cookie.
        var localTimeZone = new Date().toString().match(/([A-Z]+[\+-][0-9]+.*)/)[1],
            isSecured = (document.location.protocol === 'https:') ? 'secure' : '';

        document.cookie = "localTimeZone=" + localTimeZone + ";SameSite=Strict;" + isSecured;

        //Returning User condition cookie.
        if (elementorFrontend.config.post.id)
            document.cookie = "isReturningVisitor" + elementorFrontend.config.post.id + "=true;SameSite=Strict;" + isSecured;

    });

})(jQuery);
