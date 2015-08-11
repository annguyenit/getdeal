<?php
$action = $_GET['img']; 
?><head>
  
   <link href="style/style.css" rel="stylesheet" type="text/css" />
   
<script language="javascript" type="text/javascript">
<!--
function toggle(o){
var e = document.getElementById(o);
e.style.display = (e.style.display == 'none') ? 'block' : 'none';
}

function goform()
{  
	  if(document.forms.ajaxupload.myfile.value==""){
	  alert('Please choose an image');
	  return;
	  }else{

		  document.ajaxupload.submit();
		  }
}
function goUpload(){
 
	  if(document.forms.ajaxupload.myfile.value==""){
	  return;
	  }else{
	
	  	
      document.getElementById('f1_upload_process').style.visibility = 'visible';
	  document.getElementById('f1_upload_process').style.display = '';
	  document.getElementById('f1_upload_success').style.display = 'none';
      return true; }
}

function noUpload(success, path, imgNumb){
      var result = '';
		
      if (success == 1){ 
         document.getElementById('f1_upload_process').style.display = 'none';
		  var theImage = parent.document.getElementById(imgNumb);
		   theImage.value = path;
		   document.getElementById('myfile').value = '';
		   document.getElementById('f1_upload_success').style.display = '';

          }
      else {  
          document.getElementById('f1_upload_process').style.display = 'none';
		  document.getElementById('f1_upload_form').style.display = 'none'; 
          document.getElementById('no_upload_form').style.display = '';
      }
      return true;     
}
//-->
</script>   
</head>



<style>

#upload_target
{
	 width:				100%;
	 height:			80px;
	 text-align: 		center;
	 border:			none;
	 background-color: 	#642864;	
	 margin:			0px auto;
}

</style>

 


<body>
                <form name="ajaxupload" action="<?php echo "upload.php?img=".$action."&nonce=".$_GET['nonce']; ?>" method="post" enctype="multipart/form-data" target="upload_target" onSubmit="" >
                     <p id="f1_upload_process" style="margin-top: 20px;">Uploading Please wait ...<br/><img src="loader.gif" /><br/></p>
					 
                      <div id="f1_upload_form" align="left"><!--Select Image You want to upload:-->
                         <table border="0" cellpadding="0" cellspacing="0"><tr><td><label>
						 <input name="myfile" id="myfile" class="textboxStyled" type="file" size="50" onChange="goform();goUpload();" tabindex="2" /></label>
                         <p id="f1_upload_success" style="display:none; font-weight:bold;">Uploaded Successfully<br /></p>
                         </td><td></td></tr></table>
                     </div>
                     
                     <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0; border:0; background:#fff;" ></iframe>
                 </form>
                 <div id="yesupload" style="display: none;"><center><?php echo mkt_ADMIN_OPTIONS_UPLOAD_LOGO_SUCCESSFUL; ?></br><a href="#" onlcick="reload(<?php echo $_GET['img']; ?>)"><?php echo mkt_ADMIN_OPTIONS_UPLOAD_LOGO_DIFFERENT_IMG; ?></a></center></div>
             
</body>   