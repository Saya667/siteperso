 <div class="contact_us">
 <h1>Nous <br> contacter</h1>
 <h2>Nous serions<br> ravis de vous <br> entendre !</h2>
</div>

<div class="champs">
 <form action="submit-contact.php" method="post">
     <h3>Prénom*:</h3>
     <input type="text" name="prenom" placeholder="Entrez votre prénom">
     <h3>Nom*:</h3>
     <input type="text" name="nom" placeholder="Entrez votre nom de famille">
     <h3>E-mail*:</h3>
     <input type="email" name="email" placeholder="Entrez l'email">
     <h3>Commentaire*:</h3>
     <textarea class="comment" name="comment" placeholder="Entrez votre commentaire"></textarea><br>
     <input class="bouton" type="submit" value="Soumettre">

 </div>
  
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (isset ($_POST['g-recaptcha-response']) &&! empty ($_POST ['g-recaptcha-response'])) {
    $secret = '6LfvfqEdAAAAAIBOm4H53eadcCFfQzWjCxKveaH4'; 
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']); 
    $responseData = json_decode ($verifyResponse); 
    if ($responseData-> success) {$succMsg = 'Votre demande de contact a été envoyée avec succès.'; } 
        else {$errMsg = 'La vérification du robot a échoué, veuillez réessayer.';}

    if( !empty($_POST)){

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';


        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'kilianlevasseur5@gmail.com';             // SMTP username
            $mail->Password = 'tonmdp';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable SSL encryption, TLS also accepted with port 465
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($_POST['mail']);          //This is the email your form sends From
            $mail->addAddress('kilianlevasseur5@gmail.com'); // Add a recipient address
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $_POST['objet'];
            $mail->Body    = $_POST['form']."<br>"." mail de l'expéditeur : ".$_POST['mail'];
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo '<div><h2>Votre message à bien était envoyé</h2></div>';
        } catch (Exception $e) {
            echo 'Votre message à pas pu être envoyé.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
?>
