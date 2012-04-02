jQuery(document).ready(function(){	jQuery("input[id*=checkboxall]").click(function() {		var checked_status = this.checked;		jQuery("input[id*=checklist]").each(function() {			this.checked = checked_status;		});	});		jQuery("input[id*=checkinvert]").click(function() {		this.checked = false;			jQuery("input[id*=checklist]").each(function() {			var status = this.checked;						if (status == true) {				this.checked = false;			} else {				this.checked = true;			}		});	});});
jQuery(document).ready( function() {
        jQuery('.postbox h3').prepend('<a class="togbox">+</a> ');
        if(jQuery("textarea[@name=event_notes]").val()!="") {
                   jQuery("textarea[@name=event_notes]").parent().parent().removeClass('closed');
                }
                jQuery('.postbox h3').click( function() {
                 jQuery(jQuery(this).parent().get(0)).toggleClass('closed');
        });
});