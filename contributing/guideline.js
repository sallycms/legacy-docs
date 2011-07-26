(function() {
    /* keep your code in your own anonymous function */

    var x = 5, y = 6; // try to use a single var statement per scope

    function bar(a, b) {
        return a + b;
    }

    jQuery('#myselector').click(function() {
        console.log('clicked!'); /* never in production code! */
        var $this = $(this);    /* <-- NEVER WRITE THIS. That is just fucking confusing... Use 'self' instead. */
    });
})();

/* if you use jQuery, use one of the following */

/* this one runs IMMEDIATELY after loading the JS file */

(function($) {
    $(...);
})(jQuery);

/* this one fires when DOM:LOADED is fired */

jQuery(function($) {
    $(...);
});
