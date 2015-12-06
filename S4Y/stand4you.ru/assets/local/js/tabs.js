var $j = jQuery.noConflict();

$j(document).ready(function() {
    $j('ul.tabs li').css('cursor', 'pointer');

    $j('ul.tabs.tabs1 li').click(function(){
        var thisClass = this.className.slice(0,2);
        $j('div.t1').hide();
        $j('div.t2').hide();
        $j('div.' + thisClass).show();
        $j('ul.tabs.tabs1 li').removeClass('tab-current');
        $j(this).addClass('tab-current');
    });
});