<?php
require_once('./mailer.php');
$info=(object)[];

 $data=false;
 $data['userid'] = $DB->generate_id(20);
 $data['date'] =date("Y-m-d H:i:s");
//Validate username
 $data['username'] = $DATA_OBJ->username;
if(empty($DATA_OBJ->username)){
 $Error="Please enter a valid username.";
}
else{
 if(strlen($DATA_OBJ->username)<3){
   $Error="Username must be at least 3 charachters long.";
 }
 if(!preg_match("/^[a-z A-Z]*$/",$DATA_OBJ->username)){
   $Error="Please enter a valid username.";
 }
}
 $data['email'] = $DATA_OBJ->email;
 if(empty($DATA_OBJ->email)){
   $Error="Please enter a valid email.";
 }
 else{
   if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$DATA_OBJ->email)){
     $Error="Please enter a valid email.";
   }
 }
 $data['gender'] = isset($DATA_OBJ->gender)?$DATA_OBJ->gender:null;
 if(empty($DATA_OBJ->gender)){
   $Error="Please select a gender";
 }
 else{
   if($DATA_OBJ->gender !="Male" && $DATA_OBJ->gender !="Female"){
     $Error="Please select a valid gender";
   }
 }
 $data['password'] = $DATA_OBJ->password;
 $password=$DATA_OBJ->password2;
 if(empty($DATA_OBJ->password)){
   $Error="Please enter a valid password.";
 }
 else{
   if($DATA_OBJ->password!= $DATA_OBJ->password2){
     $Error="Entered passwords must match.";
   }
   if(strlen($DATA_OBJ->password)<8){
     $Error="Password must be atleast 8 charachters long.";
   }
 }

 if ($Error == "") {
  $arr['email'] = $DATA_OBJ->email;
  $sql = "select * from users where email= :email limit 1";
  $res=$DB->read($sql,$arr);
  if(!is_array($res)){
    $data['password']=password_hash( $DATA_OBJ->password, PASSWORD_DEFAULT);
    $data['otp'] =rand(1000,2000);
  $query = "insert into users (userid,username,gender,email,password,date,OTP) values (:userid,:username,:gender,:email,:password,:date,:otp)";
  $result = $DB->write($query,$data);
  
    if ($result) {
      sendMail($data['email'],$data['otp'] ,"Registration in MyChat Application");
      echo "<script>alert('Registration completed')</script>";
      header("Location: http://localhost/MyChat/login.php");
      // $info->message = "Your profile was created.";
      // $info->data_type = "info";
      // echo json_encode($info);
      
      
    }
  else {
    
    $info->message = "Sorry, your profile was not created.";
    $info->data_type = "error";
    echo json_encode($info);
  }
}
else {
  $info->message = "Email already exsits";
  $info->data_type = "error";
  echo json_encode($info);
}

  }else{
   
  $info->message = $Error;
  $info->data_type = "error";
  echo json_encode($info);
 }
 ?>