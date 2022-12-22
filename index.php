<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Chat</title>
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
        display: flex;
        margin: auto;
        color: white;
        font-family: myFont;
        font-size: 13px;
    }
    
    #left_pannel {
        min-height: 500px;
        background-color: #27344b;
        flex: 1;
        text-align: center;
    }
    
    #profile_image {
        width: 50%;
        border: solid thin white;
        border-radius: 50%;
        margin: 10px;
    }
    
    #left_pannel label {
        width: 100%;
        height: 20px;
        display: block;
        background-color: #404b56;
        border-bottom: solid thin #ffffff55;
        cursor: pointer;
        padding: 5px;
        transition: all 1s ease 0.3s;
    }
    
    #left_pannel label:hover {
        background-color: #778593;
    }
    
    #left_pannel label img {
        float: right;
        width: 25px;
    }
    
    #right_pannel {
        min-height: 500px;
        flex: 4;
        text-align: center;
    }
    
    #header {
        background-color: #485b6c;
        height: 70px;
        font-size: 40px;
        text-align: center;
        font-family: headFont;
    }
    
    #inner_left_pannel {
        background-color: #383e48;
        flex: 1;
        min-height: 430px;
    }
    
    #inner_right_pannel {
        background-color: #f2f7f8;
        flex: 2;
        min-height: 430px;
        transition: all 2s ease;
    }
    
    #radio_contacts:checked~#inner_right_pannel {
        flex: 0;
    }
    
    #radio_settings:checked~#inner_right_pannel {
        flex: 0;
    }
    
    #radio_blocked:checked~#inner_right_pannel {
        flex: 0;
    }
</style>

<body>
    <div id="wrapper">
        <div id="left_pannel">
            <div id="user_info" style="padding: 10px;">
                <img id="profile_image" src="ui/images/user_male.jpg" alt=""><br>
                 <span id="username"> Username</span> <br>
                <span id="email" style="font-size: 12 px; opacity:0.5;"> user@email.com</span>
                <br><br><br>
                <div>
                    <label id="label_chat" for="radio_chat">Chat <img src="ui/icons/chat.png" alt=""></label>
                    <label id="label_contacts" for="radio_contacts">Contact<img src="ui/icons/contacts.png" alt=""></label>
                    <label id="label_settings" for="radio_settings">Settings<img src="ui/icons/settings.png" alt=""></label>
                    <label id="label_settings" for="radio_blocked">Blocked Users<img src="ui/icons/settings.png" alt=""></label>
                </div>

            </div>
        </div>
        <div id="right_pannel">
            <div id="header">My Chat</div>
            <div id="container" style="display:flex">
                <div id="inner_left_pannel"></div>

                <input type="radio" id="radio_chat" name="myradio" style="display:none">
                <input type="radio" id="radio_contacts" name="myradio" style="display:none">
                <input type="radio" id="radio_settings" name="myradio" style="display:none">
                <input type="radio" id="radio_blocked" name="myradio" style="display:none">
                <div id="inner_right_pannel"></div>
            </div>
        </div>
    </div>
</body>

</html>
<script type="text/javascript">
    function _(element) {
        return document.getElementById(element);
    }
    function get_data(find,type){
            var xml=new XMLHttpRequest();
            xml.onload=function(){
                if(xml.readyState==4 || xml.status==200){
                   handle_result(xml.responseText,type); 
                }
            }
            var data={};
            data.find=find;
            data.data_type=type;
            data=JSON.stringify(data);
            xml.open("POST","api.php",true);
            xml.send(data);
    }
   function handle_result(result,type){
   
    if(result.trim()!=""){
    var obj=JSON.parse(result);
    if(!obj.logged_in ){
        window.location="login.php";
    }else{
        alert(result);
    }
    }
   }
   get_data({},"user_info");
</script>