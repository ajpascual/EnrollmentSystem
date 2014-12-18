<?php
	//Start session
	session_start();
	 include('connect.php');
	//Unset the variables stored in session
	unset($_SESSION['SESS_MEMBER_ID']);
	unset($_SESSION['SESS_FIRST_NAME']);
	unset($_SESSION['SESS_LAST_NAME']);
    unset($_SESSION['SESS_ERROR']);
    $msg="";
    if(isset($_POST['Send'])){

  	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
           $userid = clean($_POST['id']);
           $email = clean($_POST['email']);
           $confirmemail = clean($_POST['confirmemail']);

           if($userid=="" || $email==""){
               $msg = "Please enter required fields!";

           }
           else{
             //check if email address is in correct format
             if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)){
               $msg="Email address is in incorrect format!";
             }
             else{
               if($email == $confirmemail){
                 $_SESSION['SESS_EMAIL'] = $email;
                 $_SESSION['SESS_UID'] = $userid;
               //check if user id exists
               $result = mysql_query("SELECT * FROM user WHERE idnumber='$userid'");
                 if (mysql_num_rows($result)>0){
                     $row = mysql_fetch_array($result, MYSQL_BOTH);
                     $position = $row['position'];
                     	if ($position=='admin')
                            	{
                            		//Create query
                            		$qry="SELECT * FROM admin WHERE idnum='$userid'";
                            		$result=mysql_query($qry);

                            		//Check whether the query was successful or not
                            		if($result) {
                            			if(mysql_num_rows($result) > 0) {

                            				header("location: sent.php");
                            				exit();
                            			}else {
                            				//Login failed
                                            $msg="Admin user does not exist!";
                            			}
                            		}else {
                            			die("Query failed");
                            		}
                            	}
                            	if ($position=='student')
                            	{
                            		//Create query
                            		$qry="SELECT * FROM student WHERE idnumber='$userid' AND email='$email'";
                            		$result=mysql_query($qry);

                            		//Check whether the query was successful or not
                            		if($result) {
                            			if(mysql_num_rows($result) > 0) {
                            				//Login Successful
                            			   header("location: sent.php");
                            				exit();
                            			}else {
                            				//Login failed
                            			   $msg="The entered email address is not the registered email address of this student!";
                            			}
                            		}else {
                            			die("Query failed");
                            		}
                            	}
                            	if ($position=='teacher')
                            	{
                            		//Create query
                            		$qry="SELECT * FROM teacher WHERE idnumber='$userid' AND email='$email'";
                            		$result=mysql_query($qry);

                            		if($result) {
                            			if(mysql_num_rows($result) > 0) {
                            				//Login Successful
                            				header("location: sent.php");
                            				exit();
                            			}else {
                            				//Login failed
                            				 $msg="The entered email address is not the registered email address of this student!";
                            			}
                            		}else {
                            			die("Query failed");
                            		}
                            	}
                }
                else{
                  //ID number not found
                  $msg = "ID number is not registered!";
                }
             }
             else{
               $msg = "Email mismatched!";
             }
             session_write_close();
             }

           }
    }
?>
<html>
<head>
<title>STI Online Grade Inquiry | STI College - General Santos City</title>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
</head>
<body>
<div id="main">
	<div id="header"></div>
<div>

<br>
<br>
<br>
<br>
<br>

        <center><strong><font color="red" size="2"><?php echo $msg; ?></font><strong>
        <table width="800" border="0">
          <tr>
            <td>&nbsp;</td>
            <td width="300" valign="middle"><div class="loginbox">
            <div align="center"><strong><font size="3">Request for New Password            </font></strong></div>

            <br>
            <form action="" method="post">
		  <div align="center">ID Number&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    <input type="text" name="id" class="textfield"><font color="red">*</font>
		    <br>
		Email Address:
		<input type="text" name="email" class="textfield"><font color="red">*</font>
        Confirm Email&nbsp;:&nbsp;
		<input type="text" name="confirmemail" class="textfield"><font color="red">*</font>
		<br>
        &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
		<input type="submit" name="Send" value="Send request" class="button">
        <br>

		  </div>
	  </form>

            </div></td>
            <td>&nbsp;</td>
          </tr>

        </table>  </center>
        <br style="clear: left">
  </div>
<div id="content">

	</div>
	<div class="footer">Copyright © 2014. STI College - General Santos City. All Rights Reserved.</div>
</div>
</body>
</html>
