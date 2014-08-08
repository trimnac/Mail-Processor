<?php
$toMail = ''; // your email address
$CCMail = ''; // CC (Carbon copy) also send the email to this address (leave empty if you don't use it)
$thanksPage = ''; // the URL of the thank you page
$errorPage = ''; //
$mailSub = ''; // the subject of the email which you can change


//================= DON'T EDIT BELOW THIS CODE ==============================
if(isset($_POST['Email'])){
	$mailBody = '<font face="arial" size="2" color="#000000">';
	if(!filter_var(trim($_POST['Email']), FILTER_VALIDATE_EMAIL)){
		header('location:'.$errorPage);
		exit;
	}
	//Replace these with fields that must not be blank
	if($_POST['Name'] == "" || $_POST['Phone'] == "" || $_POST['Email'] == ""){
		header('location:'.$errorPage);
		exit;
	}
	//Preventing Email Injection
	foreach($_POST as $value){
		if(stripos($value, 'Content-Type:') !== FALSE){
			header('location:'.$errorPage);
			exit;
		}
	}
	//Anti-Spam Honey Pot(field must be a hidden field in the form)
	if(isset($_Posts["message"])){
		if($_POST["message"] != ""){
			header('location:'.$errorPage);
			exit;
		}
	}
	foreach ($_POST as $field => $input) {
		if((strtolower($field) != 'Submit' || strtolower($field) != 'reset') && $field != "message"){
			$mailBody .= '<b>'.ucfirst ($field) .': </b>'. trim(strip_tags($input)) . '<br>'; 
		}
	} 
	
	//===============================================================
	$mailBody .= '</font>';
	//===============================================================
	$usrMail = $_POST['Email'];
	$headers = "From:$usrMail\r\n";
	$headers .= "cc:$CCMail\r\n";
	$headers .= "Content-type: text/html\r\n";
	$sendRem = mail($toMail, $mailSub, $mailBody, $headers);
	if($sendRem){
		header('location:'.$thanksPage);
		exit;
	}else{
		print '<h2>Failed to send your query.</h2>';
		print '<h3>Please Try Later.</h3>';
	}
}
else{
	header('location:'.$errorPage);
	exit;
}

?>