
jQuery(document).ready(function() {
    jQuery('.GTTabs_divs').hide();
    jQuery('.GTTabs_curr_div').show();
    jQuery('.GTTabsLinks').each(function() {
        jQuery(this).click(function() {
            //alert(jQuery(this).attr('id'));
            var info = jQuery(this).attr('id').split('_');
            GTTabs_show(info[1], info[0]);
        });
    });
});

function GTTabs_show(tab,post){
		
		jQuery('.GTTabs_divs').each(function() {
            jQuery(this).hide();
        });
        jQuery('#GTTabs_ul_'+post + ' li').each(function() {
            jQuery(this).removeClass('GTTabs_curr');
        });
        jQuery('#GTTabs_li_'+tab+'_'+post).addClass('GTTabs_curr');
		jQuery("#GTTabs_"+tab+"_"+post).show();
		self.focus();

		//Cookies
		var expire = new Date();
		var today = new Date();
		expire.setTime(today.getTime() + 3600000*24);
		document.cookie = "GTTabs_"+post+"="+tab+";expires="+expire.toGMTString();

}

function GTTabsShowLinks(tab){
	if (tab) window.status=tab;
	else window.status="";
}

function GTTabs_getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
