/**************************************************************
* This script is brought to you by Vasplus Programming Blog
* Website: www.vasplus.info
* Email: info@vasplus.info
****************************************************************/


//Automatic Uploader
$(document).ready(function() 
{
	
	
                $('#photo').live('change', function() {
                    $("#view").html('');
                    $("#view").html('<img style="margin-top: 119px; margin-left: 39px;" src="'+base_url+'assets/img/loadings.gif" />');
				
                    $(".ajaxform").ajaxForm({
                        //target: '#view',
						success: function(response) 
						{
							
							var duce = jQuery.parseJSON(response);
							//alert(duce.status)
						if(duce.status != "error"){
							var html = '<img style="width:161px; height:213px;" src="'+base_url+'uploads/avatar/'+duce.url+'" />';
							var html_sidebar = '<img style="width:45px; height:45px;" src="'+base_url+'uploads/avatar/'+duce.url+'" />';
							$("#view").hide().fadeIn('slow').html(html);
							$("#sidebar_profilepic").fadeIn('slow').html(html_sidebar);
						}else{
							alert("error in uplaoding file!");
							 
							var html = '<img style="width:161px; height:213px;" src="'+base_url+'uploads/avatar/'+duce.url+'" />';
							$("#view").hide().fadeIn('slow').html(html);
							
							}
						},
                    }).submit();
					//alert(target);
                });
			
			
	
   /* $('#upload_file').submit(function(e) {
		  e.preventDefault();
		//alert("hii");
		$("#vasPhoto_uploads_Status").show();
				$("#vasPhoto_uploads_Status").html('');
				$("#vasPhoto_uploads_Status").html('<div style="font-family: Verdana, Geneva, sans-serif; font-size:12px; color:black;" align="center">Upload <img src="'+base_url+'assets/img/loadings.gif" align="absmiddle" alt="Upload...." title="Upload...."/></div><br clear="all">');
		
		
        $.ajaxFileUpload({
            url             :base_url+'myknewdog/upload_avtar',
            secureuri       :false,
            fileElementId   :'vasPhoto_uploads',
            dataType        : 'JSON',
            data            : {
              
            },
            success : function (data, status)
            {
                if(data.status != 'error')
                {
                   
                }
                alert(data);
            }
        });
        return false;
	}); */         
}); 