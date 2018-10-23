<?php
date_default_timezone_set('Africa/Johannesburg');
$date = date('d/m/Y H:i:s', time());

function send_mail($email, $type) {
    if ($type == "user details") {
        $subject = "Your Camagaru user details have been changed";
        $msg = "Your account has successfully been created";
    }
    if ($type == "new user") {
        $subject = "Email confirmation on Camagaru";
        $msg = "Your account has successfully been created";
    }
    if ($type == "user login") {
        $subject = "Login confirmation";
        $msg = "You signed in at " . $date;
    }
    mail($email, $subject, $message);
}
?>
