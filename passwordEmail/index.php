<?php
include '../connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
function sendPasswordEmail($name, $email, $token, $id, $usage, $header)
{
  global $con;
  $mail = new PHPMailer(true);
  $sql = "SELECT * FROM `body_templates` WHERE templateUsage='$usage'";
  $result = mysqli_query($con, $sql);
  if ($result) {
    $template = mysqli_fetch_array($result);
    $body = $template['body'];
    $body = str_replace('{{name}}', $name, $body);
    $body = str_replace('{{token}}', $token, $body);
    $body = str_replace('{{user_id}}', $id, $body);
    try {
      // Server settings
      $mail->SMTPSecure = "ssl";
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = '465';
      $mail->Username = 'anushi.arcs@gmail.com'; // SMTP account username
      $mail->Password = 'kwem jfbi lqsc jucl';
      $mail->SMTPKeepAlive = true;
      $mail->Mailer = "smtp";
      $mail->IsSMTP(); // telling the class to use SMTP
      $mail->SMTPAuth = true; // enable SMTP authentication
      $mail->CharSet = 'utf-8';
      $mail->SMTPDebug = 0;

      // Recipients
      $mail->setFrom('anushi.arcs@gmail.com', 'Anushi Jindal');
      $mail->addAddress($email, $name);
      // Content
      $mail->isHTML(true);
      $mail->Subject = $header;
      // if ($usage == 'forget') {
      //   $mail->Body = "
      //   <div style='text-align: center;margin:auto;border: 2px solid black;width: 50%;padding: 10px;background-color: #EEF7FF;border-radius: 20px;' class='template'>
      //       <h1>Welcome {{name}}</h1>
      //       <h4>We send you this email because you are requesting for password change.</h4>
      //       <p>For security purposes we need to verify youself.</p>
      //       <p>Please click below for verification</p>
      //       <button style='background-color: #3FA2F6;padding: 3px 5px;color: white;margin-right: 10px;' class='right'><a style='text-decoration:none;color:white;' 
      //       href = 'http://localhost/crud_design/pass-reset/?token={{token}}&user_id={{user_id}}'>Reset Password</a></button>
      //       <p><a style='text-decoration:none;' href = 'http://localhost/crud_design/signin'>That wasn't me!</a></p>
      //       <p>Facing difficuly in button? Copy the link: <a style='color-blue;'>http://localhost/crud_design/pass-reset/?token={{token}}&user_id={{user_id}}</a></p>
      //       <p>Thanks for connecting with us!</p>
      //   </div>
      //   ";
      $mail->Body = $body;


      // $template = 'dfsdf';
      // str_replace('{{user_id}}', $user_id , $template);
      //   } elseif ($usage == 'signup') {
      //     $mail->Body = "
      // <h2>Hello {{name}}</h2>
      // <h3>Yor are successfully signed up.</h3>
      // <h3>Welcome to our community.</h3>
      // <h4>Thanks for signing in with us.</h4>
      // ";
      //   } elseif ($usage == "change") {
      //     $mail->Body = "
      // <h2>Hello {{name}}</h2>
      // <h3>Your password is successfuly Changed.</h3>
      // <h4>Thanks for signing in with us.</h4>
      // ";
      //   }
      // Send email
      $mail->send();
      echo 'Message has been sent';
      header("Location: " . $_SERVER['HTTP_REFERER'] . "");
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
?>