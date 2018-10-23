<?php
date_default_timezone_set('Africa/Johannesburg');
function send_mail($email, $type) {
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
$date = date('d/m/Y H:i:s', time());
echo "date";
echo $date;
?>
