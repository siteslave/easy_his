/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 13/3/2556 15:44 น.
 */
$(function() {
    $('#mainTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
});