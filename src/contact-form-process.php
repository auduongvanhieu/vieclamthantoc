<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['Phone'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to_01 = "auduongvanhieu@gmail.com";
    $email_to_02 = "hoang.phuc170296@gmail.com";
    $email_subject = "Nội dung mới từ Việc làm thần tốc";
    $recipient_email = "vieclamthantoc@gmail.com";
    $recipient_name = "ViecLamThanToc";
    function problem($error)
    {
        echo "Chúng tôi rất xin lỗi, nhưng đã tìm thấy lỗi với biểu mẫu bạn đã gửi. ";
        echo "Những lỗi này xuất hiện bên dưới.<br><br>";
        echo $error . "<br><br>";
        echo "Xin vui lòng trở lại và sửa chữa các lỗi này.<br><br>";
        die();
    }

    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
    ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

    // validation expected data exists
    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Phone']) ||
        !isset($_POST['Message'])
    ) {
        problem('Chúng tôi rất tiếc, nhưng có vẻ như có vấn đề với biểu mẫu bạn đã gửi.');
    }

    $name = $_POST['Name']; // required
    $email = $_POST['Email']; // required
    $phone = $_POST['Phone']; // required
    $message = $_POST['Message']; // required

    console_log('$name: '.$name, true);
    console_log('$email: '.$email, true);
    console_log('$phone: '.$phone, true);
    console_log('$message: '.$email, true);

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'Địa chỉ email bạn đã nhập có vẻ không hợp lệ.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'Tin nhắn bạn đã nhập có vẻ không hợp lệ.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Nội dung được gửi từ Việc làm thần tốc.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    // Set mail message
    $email_message .= "Tên người gửi: " . clean_string($name) . ".\n";
    $email_message .= "Email: " . clean_string($email) . ".\n";
    $email_message .= "Số điện thoại: " . clean_string($phone) . ".\n";
    $email_message .= "Nội dung: " . clean_string($message) . ".\n";
    $email_message = nl2br($email_message);

    // Send mail by lib
    $mailer = new PHPMailer();
    $mailer->IsSMTP();
    $mailer->Mailer = "smtp";
    
    $mailer->SMTPDebug  = 1;  
    $mailer->SMTPAuth   = TRUE;
    $mailer->SMTPSecure = "tls";
    $mailer->Port       = 587;
    $mailer->Host       = "smtp.gmail.com";
    $mailer->Username   = "vieclamthantoc@gmail.com";
    $mailer->Password   = "uwosyeyifmyogiwt";

    $mailer->SMTPDebug = 0;    
    $mailer->CharSet = "UTF-8"; 
    $mailer->AddAddress($recipient_email, $recipient_name);
    $mailer->SetFrom($email, $recipient_name);
    $mailer->AddReplyTo($recipient_email, $recipient_name);
    $mailer->AddCC($email_to_01, $recipient_name);
    $mailer->AddCC($email_to_02, $recipient_name);
    $mailer->Subject = $email_subject;
    $mailer->MsgHTML($email_message); 
    if(!$mailer->Send()) {
        console_log("send email to ".$recipient_email." error", true);
    } else {
        console_log("send email to ".$recipient_email." success", true);
    }
?>
    Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ liên hệ lại với bạn trong thời gian sớm nhất có thể.
<?php
}
?>