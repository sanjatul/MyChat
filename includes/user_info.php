<?php
$info=(object)[];

 $data=false;
//Validate info
 $data['userid'] = $_SESSION['userid'];
 
 if ($Error == "") {
   $query = "select * from users where userid=:userid limit 1";
   $result = $DB->read($query,$data);
   if (is_array($result)) {
    $result = $result[0];
    $result->data_type = "user_info";
     //Check if image exsits
     $image =($result->gender=="Male")? 'ui/images/user_male.jpg':'ui/images/user_female.jpg';
     if(file_exists($result->image)){
       $image = $result->image;
     }
    $result->image = $image;
    echo json_encode($result);
    
  } else {
     
     $info->message = "Wrong Email";
     $info->data_type = "error";
     echo json_encode($info);
   }
  }
  else{
   
  $info->message = $Error;
  $info->data_type = "error";
  echo json_encode($info);
 }