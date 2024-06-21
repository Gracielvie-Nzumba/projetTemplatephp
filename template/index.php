<?php
// Composer autoloader
require_once 'vendor/autoload.php'; 

use App\ContactForm;
use App\Session;


Session::start();


$contactForm = new ContactForm('index.php');
$contactForm->handleSubmission();


echo $contactForm->render();



$successMessage = Session::get('reusi!');
if ($successMessage) {
    echo '<p>' . htmlspecialchars($successMessage) . '</p>';
    Session::delete('reusi!'); 
}

?>
