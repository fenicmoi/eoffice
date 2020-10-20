<?php
//if "email" variable is filled out, send email
if (isset($_REQUEST['email']))  {
	
	
	//E	mail information
	$admin_email = "fenicmoi@hotmail.com";
	
	$email = $_REQUEST['email'];
	
	$subject = $_REQUEST['subject'];
	
	$comment = $_REQUEST['comment'];
	
	
	//s	end email
	mail($admin_email, "$subject", $comment, "From:" . $email);
	
	
	//E	mail response
	echo "Thank you for contacting us!";
	
}


//if "email" variable is not filled out, display the form
else  {
	
	?>

 <form method="post">

  Email: <input name="email" type="text" />

  Subject: <input name="subject" type="text" />

  Message:

  <textarea name="comment" rows="15" cols="40"></textarea>

  <input type="submit" value="Submit" />
  </form>
  
<?php
}

?>