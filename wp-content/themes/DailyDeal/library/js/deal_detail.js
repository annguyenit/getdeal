function add_like(post_id)
{
	var $n = jQuery.noConflict();
	$n.ajax({
		url: root_path_js+'?ptype=postlike&pid=' + post_id,
		type: 'GET',
		dataType: 'html',
		timeout: 20000,
		error: function(){
			//alert('Error loading cart information');
		},
		success: function(html){
			
				document.getElementById('addlike'+ post_id).innerHTML=html;
				
		}
	});
	return false;
}

function viewdeal(cuid,did)
{
	location.href= "?author="+cuid+"&transid="+did;
}

function viewauthor(cuid,did)
{
	location.href= "?author="+cuid+"&ahuthordetailid="+cuid;
}
function buydeal(oid,did)
{
	location.href= "?ptype="+oid+"&did="+did;
}