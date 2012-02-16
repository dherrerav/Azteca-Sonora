
/* convienence method to restore the text area from the preview div */
function jacRestoreTextArea(id, isAdmin)
{             
	if(id) id = 'edit';    
    if (JACommentConfig.isEnableAutoexpanding != undefined && JACommentConfig.isEnableAutoexpanding != 0){			
        FieldsExpand = ' style="overflow-y: hidden;"';		
    }else{
        FieldsExpand = '';
    }
    /* clear the error HTML out of the preview div */
    AtD.remove('newcomment'+id); 
	
    /* swap the preview div for the textarea, notice how I have to restore the appropriate class/id/style attributes */
	//check if allow expand form
	addClass = "";
	if(jQuery(" .jac-act-button").length >0){
		addClass = " jac-expand-field";	
	}
    	jQuery('#newcomment'+id).replaceWith('<textarea class="field textarea jac-new-comment jac-expand-field'+addClass +'" id="newcomment'+id+'" name="newcomment" rows="12" cols="80" '+FieldsExpand+'>' + jQuery('#newcomment'+id).html() + '</textarea>');        
	
	jac_auto_expand_textarea(id);
    /* change the link text back to its original label */
    //jQuery('#checkLink'+id).title('Check Spelling');
};

/* where the magic happens, checks the spelling or restores the form */
function jac_check_atd(id, isAdmin)
{	
    if(id) id = 'edit';
	if($('newcomment'+id) != undefined && $('newcomment'+id).value == undefined){
		jacRestoreTextArea(id, isAdmin);
		$("err_newcomment" +id).style.display = "none";
		return;
	}
	
 jQuery(function()
 {
     /* If the text of the link says edit comment, then restore the textarea so the user can edit the text */
     if (jQuery('#checkLink'+id).text() == 'Edit Text'){                               
    	 jac_check_atd('', isAdmin); 
     } 
     else 
     {  
         /* set the spell check link to a link that lets the user edit the text */
         //jQuery('#checkLink'+id).text('Edit Text');

         /* disable the spell check link while an asynchronous call is in progress. if a user tries to make a request while one is in progress
            they will lose their text. Not cool! */
         var disableClick = function() { return false; };
         jQuery('#checkLink'+id).click(disableClick);

         /* replace the textarea with a preview div, notice how the div has to have the same id/class/style attributes as the textarea */
         jQuery('#newcomment'+id).replaceWith('<div style="height:186px;" class="field textarea jac-new-comment" id="newcomment'+id+'">' + jQuery('#newcomment'+id).val() + '</div>');

         /* check the writing in the textarea */
         AtD.checkCrossAJAX('newcomment'+id,  
         {
             ready: function(errorCount)
             {
                /* this function is called when the AtD async service request has finished. 
                   this is a good time to allow the user to click the spell check/edit text link again. */
                jQuery('#checkLink'+id).unbind('click', disableClick);
             },

             success: function(errorCount) 
             {
                if (errorCount == 0)
                {
                   alert(JACommentConfig.textCheckSpelling);
				   if($("err_newcomment").innerHTML != ""){
						$("err_newcomment").innerHTML = "";
						$("err_newcomment").style.display = "none";
					}
                }

                /* once all errors are resolved, this function is called, it's an opportune time
                   to restore the textarea */
                jacRestoreTextArea(id, isAdmin);
             },

             error: function(reason)
             {
                jQuery('#checkLink'+id).unbind('click', disableClick);

                alert("There was an error communicating with the spell checking service.\n\n" + reason);

                /* restore the text area since there won't be any highlighted spelling errors */
                jacRestoreTextArea(id, isAdmin);
             },

             editSelection : function(element)
             {
                var text = prompt( "Replace selection with:", element.text() );
                if (text != null)
                   element.replaceWith( text );                   
             }
         });
     }
 });
}