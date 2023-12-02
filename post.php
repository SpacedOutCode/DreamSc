<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    if(str_starts_with($text, "https://")){
        $text_message = "<div class='msgln'><span class='chat-time'>".date("j/n/0 g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b><a href='".$text."'>".stripslashes(htmlspecialchars($text))."</a><br></div>";
        file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
    } else {
        $text_message = "<div class='msgln'><span class='chat-time'>".date("j/n/0 g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
        file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
    }
}
?>