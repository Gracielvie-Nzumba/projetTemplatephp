<?php
namespace App;


class ContactForm extends Form {
    public function __construct($action, $method = 'post', $attributes = []) {
        parent::__construct(array_merge(['action' => $action, 'method' => $method], $attributes));

        
        $this->addElement(new Input('text', 'name', '', ['required' => 'required', 'placeholder' => 'Votre nom']));
        $this->addElement(new Input('email', 'email', '', ['required' => 'required', 'placeholder' => 'Votre email']));
        $this->addElement(new Input('text', 'subject', '', ['required' => 'required', 'placeholder' => 'Sujet']));
        $this->addElement(new Textarea('message', 'Message', ['required' => 'required', 'rows' => '5']));
        $this->addElement(new Checkbox('subscribe', 'oui', false, [], 'S\'abonner à notre newsletter'));
        $this->addElement(new Select('priority', [
            'low' => 'Faible',
            'medium' => 'Moyenne',
            'high' => 'Haute'
        ], ['required' => 'required']));
        $this->addElement(new Input('file', 'attachment', '', ['accept' => '.pdf,.doc,.docx,.jpg,.png']));

        $this->addElement(new Input('submit', 'submit', 'Envoyer'));
    }

    public function handleSubmission() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $name = Request::post('name');
            $email = Request::post('email');
            $subject = Request::post('subject');
            $message = Request::post('message');
            $subscribe = Request::post('subscribe') ? "Oui" : "Non";
            $priority = Request::post('priority');

            
            $uploadDir = 'uploads/';
            $targetFile = $uploadDir . basename($_FILES["attachment"]["name"]);
            move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile);

            
            $body = "Nom: $name\n";
            $body .= "Email: $email\n";
            $body .= "Sujet: $subject\n";
            $body .= "Message: $message\n";
            $body .= "S'abonner à nous: $subscribe\n";
            $body .= "Priorité: $priority\n";
            if (!empty($_FILES["attachment"]["name"])) {
                $body .= "Pièce jointe: $targetFile\n";
            }

            
            $to = "form@gmail.com";
            $headers = "From: $email";
            mail($to, $subject, $body, $headers);

            
            Session::set('succès!', 'message confirmé!');
        }
    }
}
?>
