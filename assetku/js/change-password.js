
$(document).ready(function() { 
		
	var options = { 
			target:   '',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmitChangePassword,  // pre-submit callback 
			success:       afterSuccessChangePassword,  // post-submit callback 
			resetForm: true        // reset the form after successFileful submit 
		}; 
		
	 $('#changePassword').submit(function() { 
			$(this).ajaxSubmit(options);	
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
		
		
	$("#newPassword").on('keyup', function (event) {
			reset();
			event.preventDefault();
			
			check_strength($('#newPassword').val(),'#password_strengh_feedback');
			
			if($('#newPassword').val() != $('#verifyPassword').val())
			{
				$('#password_match').hide();
				$('#password_match').html('');
			}
			else
			{
				$('#password_match').removeClass().html('');
			}
			
			return false;	 
		});
				
	$("#verifyPassword").on('keyup', function (event) {
			reset();
			event.preventDefault();
			
			var verifyValue  = $('#verifyPassword').val();
			var passMatch 	= '#password_match';
			
			if($('#newPassword').val().length == 0){
				$('#newPassword').focus();
				$('#password_match').removeClass().html('');
				$('#verifyPassword').val('')
				}
			else
			{
				if( verifyValue.length != 0 ) 
				{
					if( $('#newPassword').val() === verifyValue)//check input valid
					{
						$('#password_match').show()
						$('#password_match').addClass('strong').html('Passwords matched');
						return true
					}
					else if( $('#newPassword').val() !== verifyValue)
					{
						//passMatch.removeClass();				
						$('#password_match').show()
						$('#password_match').removeClass().html('Passwords dont match');
						$('#verifyPassword').focus();
					}
				}
				else
					{
						$('#password_match').show();
						$('#password_match').html('');
					}
			}
			return false;	 
		});

}); 		

//function after succesful file upload (when server response)
function afterSuccessChangePassword()
{
	//alertify.success("Your password has been changed ! ");	
	$('#password_strengh_feedback').removeClass().html('');
	$('#password_match').removeClass().html('');

}

//function to check file size before uploading.
function beforeSubmitChangePassword(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( $('#newPassword').val()!=$('#verifyPassword').val()) //check empty input filed
		{
			$("#verifyPassword").focus();
			alertify.error("Passwords don't match");
			//$("#output-file").html("Are you kidding me?");
			return false
		}
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		alertify.error("Please upgrade your browser, because your current browser lacks some new features we need!");	
		//$("#output-file").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	var characters = 0;
	var capitalletters = 0;
	var loweletters = 0;
	var number = 0;
	var special = 0;
	
	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');
	var specialchars = new RegExp('([!,%,&,@,#,$,^,*,?,_,~])');
	
function GetPercentage(a, b) {
		return ((b / a) * 100);
	}

function check_strength(thisval,thisid){
	if (thisval.length > 8) { characters = 1; } else { characters = 0; };
	if (thisval.match(upperCase)) { capitalletters = 1} else { capitalletters = 0; };
	if (thisval.match(lowerCase)) { loweletters = 1}  else { loweletters = 0; };
	if (thisval.match(numbers)) { number = 1}  else { number = 0; };

	var total = characters + capitalletters + loweletters + number + special;
	var totalpercent = GetPercentage(7, total).toFixed(0);

  

	get_total(total,thisid);
}

function get_total(total,thisid){

	var thismeter = $(thisid);
	if(total == 0){
		  thismeter.removeClass().html('');
	}else if (total <= 1) {
	   thismeter.removeClass();
	   thismeter.addClass('veryweak').html('Strength: very weak');
	} else if (total == 2){
		thismeter.removeClass();
	   thismeter.addClass('weak').html('Strength: weak');
	} else if(total == 3){
		thismeter.removeClass();
	   thismeter.addClass('medium').html('Strength: medium');

	} else {
		 thismeter.removeClass();
	   thismeter.addClass('strong').html('Strength: strong');
	} 
	console.log(total);
}



