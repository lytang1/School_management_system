<?php

	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	$system_title       =	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
	$text_align         =	$this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;
	$account_type       =	$this->session->userdata('login_type');
	$skin_colour        =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
	$active_sms_service =   $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;
	?>

<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>
	
	<title><?php echo $page_title;?> | <?php echo $system_title;?></title>
    
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="TEXAS STATE INTERNATIONAL ACADEMY" />
	<meta name="author" content="Creativeitem" />
	<link rel="stylesheet" type="text/css" href="assets/css/jquery-ui.css">
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!--<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
	 -->
	<script >$(document).ready(function(){
			
        	
			$('#yes').hide();
			$('.hour').hide();
			$('.dhour').hide();
			$('#desire_hour').change(function(){
				$value =$('#desire_hour').val();
				if($value=='Hourly')
				{
					$('.dhour').show();
				}else{
					$('.dhour').hide();
				}
			});


			$('#select_hour').change(function(){
				$value =$('#select_hour').val();
				if($value=='Hourly')
				{
					$('.hour').show();
				}else{
					$('.hour').hide();
				}
			});

	})		
		 $(function() {
		 	
		 	  $( ".datepicker" ).datepicker();
  });

		
	function display_more(type){
		if(type=='yes')
		{$('#yes').show();}
		else if(type=='no'){
			$('#yes').hide();
		}
	}
 function verify(type,v){

	    	if(type=='visa' && v==1){
	    		 $("#visa_exp").removeClass('hide');
	    		
	    	}else if(type=='visa' && v==0){
	    		$('#visa_exp').addClass('hide');
	    		$('#visa_date').val('');
	    	}else if(type=='work' && v==1){
	    		$('#work_exp').removeClass('hide');
	    	}else if(type=='work' && v==0){
	    		$('#work_exp').addClass('hide');
	    		$('#work_date').val('');
	    	}
		 		}
	   
	
	</script>
	<?php include 'includes_top.php';?>
	
</head>
<body class="page-body <?php if ($skin_colour != '') echo 'skin-' . $skin_colour;?>" style='text-transform:none'>
	<div class="page-container <?php if ($text_align == 'right-to-left') echo 'right-sidebar';?>" >
		<?php include $account_type.'/navigation.php';?>	
		<div class="main-content">
		
			<?php include 'header.php';?>
			<?php if($page_title!=''):?>
           <h3 style="">
           	<i class="entypo-right-circled"></i> 
				<?php echo $page_title;?>
           </h3>
       <?php endif;?>
			<?php include $account_type.'/'.$page_name.'.php';?>

			<?php include 'footer.php';?>

		</div>
		<?php //include 'chat.php';?>
        	
	</div>
    <?php include 'modal.php';?>
    <?php include 'includes_bottom.php';?>
    
</body>
</html>