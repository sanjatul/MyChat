<?php
require_once('./mailer.php');
require_once('./classes/autoload.php');

if (isset($_POST['submit'])) {
 $userid= $DB->generate_id(20);
 $date =date("Y-m-d H:i:s");
//Validate username
 $username = $_POST['username'];
 $gender=$_POST['gender'];
 $password = $_POST['password'];
 $password2 = $_POST['password2'];
 $email = $_POST['email'];


 if(strlen($username )<3){
    echo "<script>alert('Username must be at least 3 charachters long.')</script>";
 }
 if(!preg_match("/^[a-z A-Z]*$/",$username)){
    echo "<script>alert('Please enter a valid username.')</script>";
 }

 
 if(empty($gender)){
   $Error="Please select a gender";
 }

 if(empty($password)){
    echo "<script>alert('Please enter a valid password.')</script>";
 }
 else{
   if($password!= $password2){
    echo "<script>alert('Entered passwords must match.')</script>";
   }
   if(strlen($password)<8){
     $Error="Password must be atleast 8 charachters long.";
   }
 }
$sql = "select * from users where email= '$email' limit 1";
$res=$DB->read($sql,[]);
if(!is_array($res)){
$password=password_hash( $password, PASSWORD_DEFAULT);
$otp =rand(1000,2000);
  $query = "insert into users (userid,username,gender,email,password,date,OTP) values ('$userid','$username','$gender','$email','$password','$date','$otp')";
  $result = $DB->write($query,[]);
        $confirm = "http://localhost/MyChat/verify.php?otp=$otp";
    if ($result) {
      sendMail($email,$confirm ,"Registration in MyChat Application");
      echo "<script>alert('Registration completed')</script>";
      header("Location: http://localhost/MyChat/login.php");
    }
  else {
    $info->message = "Sorry, your profile was not created.";
    echo "<script>alert('Sorry, your profile was not created.')</script>";
  }
}
else{
    echo "<script>alert('Email id already exsits')</script>";
}
  }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Chat | Sign Up</title>
</head>
<style type="text/css">
    @font-face {
        font-family: headFont;
        src: url(ui/fonts/Summer-Vibes-OTF.otf);
    }
    
    @font-face {
        font-family: myFont;
        src: url(ui/fonts/OpenSans-Regular.ttf);
    }
    
    #wrapper {
        max-width: 900px;
        min-height: 500px;
        margin: auto;
        color: grey;
        font-family: myFont;
        font-size: 13px;
    }
    
    #header {
        background-color: #485b6c;
        font-size: 40px;
        text-align: center;
        font-family: headFont;
        width: 100%;
        color: white;
    }
    
    form {
        margin: auto;
        padding: 10px;
        width: 60%;
        max-height: 400px;
    }
    
    input[type=text],
    input[type=password],
    input[type=submit],
    input[type=email] {
        padding: 10px;
        margin: 10px;
        width: 98%;
        border: solid 1px grey;
        border-radius: 5px;
    }
    
    input[type=submit] {
        width: 103%;
        cursor: pointer;
        background-color: #2b5488;
        color: white;
    }
    
    input[type=radio] {
        transform: scale(1.2);
        cursor: pointer;
    }
    #error{
        text-align:center; 
        padding: 0.5em; 
        background-color: #ecaf91; color: white;  
        display:none;
    }
</style>

<body>
    <div id="wrapper">
        <div id="header">My Chat
            <div style="font-size: 20px; font-family:myFont; padding-bottom:10px;">Sign Up</div>
        </div>
        <div id="error" style=""></div>
        <form id="myForm" action="" method="post">
            <input type="text" name="username" placeholder="Enter Username" required><br>
            <input type="email" name="email" placeholder="Enter Email" required><br>

            <div style="padding:10px">
                <br>Gender: <br>
                <input type="radio" value="Male" name="gender" id="">Male <br>
                <input type="radio" value="Female" name="gender" id="">Female <br>
            </div>

            <input type="password" name="password" placeholder="Enter new password" required><br>
            <input type="password" name="password2" placeholder="Retype password" required><br>
            <input type="submit" name="submit" value="Sign up" id="signup_button" ><br>
            <a href="login.php" style="text-decoration:none;display:block;text-align:center;">Already have an account? 
             LogIn here</a>
        </form>
    </div>
</body>

</html>
<!-- <script type="text/javascript">
    function _(element) {
        return document.getElementById(element);
    }
    var signup_button=_("signup_button");
    signup_button.addEventListener("click",collect_data);
    function collect_data(){
        signup_button.disabled=true;
        signup_button.value="Loading... Please wait...";
        var myForm=_("myForm");
        var inputs=myForm.getElementsByTagName("input");
        var data={};
      for(var i=inputs.length-1;i>=0;i--){
            var key=inputs[i].name;
            switch(key){
                case "username":
                 data.username=inputs[i].value;
                 break;   
                case "email":
                    data.email=inputs[i].value;
                 break;  
                case "gender":
                    if(inputs[i].checked){
                        data.gender=inputs[i].value;
                    }
                    break;
                case "password":
                    data.password=inputs[i].value;
                 break;  
                case "password2":
                    data.password2=inputs[i].value;
                 break;  
            }
      }
      send_data(data,"signup");
      
    }

    function send_data(data,type){

        var xml=new XMLHttpRequest();
        xml.onload=function(){
            if(xml.readState==4 || xml.status==200){
                handle_result(xml.responseText);
                signup_button.disabled=false;
                signup_button.value="Sign Up";
            } 
        }
            data.data_type=type;
            var data_string=JSON.stringify(data);
            xml.open("POST","api.php",true);
            xml.send(data_string);
    }
    function handle_result(result){
        alert(result);
        var data=JSON.parse(result);
        if(data.data_type=="info"){
           // alert(data.message);
            window.location="index.php";
        }else{
            var error=_("error");
            error.innerHTML=data.message;
            error.style.display="block";
        }
    }
</script> -->