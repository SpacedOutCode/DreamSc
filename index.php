<?php
 
session_start();
 
if(isset($_GET['logout'])){    
     
    //Simple exit message
    $logout_message = "<div class='msgln'><b class='user-name-left'>". $_SESSION['name'] ."</b> left the chat.<br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
    
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        $login_message = "<div class='msgln'><b class='user-name-joined'>". $_SESSION['name'] ."</b> joined the chat.<br></div>";
        file_put_contents("log.html", $login_message, FILE_APPEND | LOCK_EX);
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
 
function loginForm(){
    echo
    '<div id="loginform">
    <p>Enter a username to continue</p>
    <form action="index.php" method="post" style="gap: 0.5rem; align-items: center;">
      <input type="text" name="name" id="name" maxlength="13"/>
      <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
  </div>';
}
 
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
 
        <title>Classes</title>
        <link type="image/png" rel="icon" href="//ssl.gstatic.com/classroom/favicon.png">
        <meta name="description" content="Chat Application" />
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
    <?php
    if(!isset($_SESSION['name'])){
        loginForm();
    }
    else {
    ?>
        <div id="wrapper">
            <div id="menu">
                <p class="welcome">Logged In As <b><?php echo $_SESSION['name']; ?></b></p>
                <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
            </div>
 
            <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("/log.html") > 0){
                $contents = file_get_contents("/log.html");          
                echo $contents;
            }
            ?>
            </div>
 
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" maxlength="1000"/>
                <input name="submitmsg" type="submit" id="submitmsg" value=">" />
            </form>
        </div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                    });
            });

            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    });
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
            });
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
 
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div
 
                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }   
                        }
                    });
                }
 
                setInterval (loadLog, 2500);
 
                $("#exit").click(function () {
                    window.location = "index.php?logout=true";
                });
        </script>
          <script>
document.addEventListener('keydown', function(e) {
    if (e.altKey) {
          console.log("alted")
          window.location.replace('https://classroom.google.com/')
    
    }
});
</script>
    </body>
</html>
<?php
}
?>