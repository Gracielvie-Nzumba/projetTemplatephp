<?php
class HTMLElement {
    protected $tag;
    protected $attributs;
    protected $contenu;

    public function __construct($tag, $attributs = [], $content = '') {
        $this->tag = $tag;
        $this->attributs = $attributs;
        $this->content = $content;
    }

    public function render() {
        $output = '<' . $this->tag;
        foreach ($this->attributs as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= '>' . $this->content . '</' . $this->tag . '>';
        return $output;
    }
}

class Input extends HTMLElement {
    public function __construct($type, $name, $value = '', $attributs = []) {
        parent::__construct('input', array_merge(['type' => $type, 'name' => $name, 'value' => $value], $attributs));
    }
}

class Button extends HTMLElement {
    public function __construct($name, $text, $attributs = []) {
        parent::__construct('button', array_merge(['name' => $name], $attributs), $text);
    }
}

class Select extends HTMLElement {
    public function __construct($name, $options, $attributs = []) {
        $optionsHtml = '';
        foreach ($options as $value => $label) {
            $optionsHtml .= '<option value="' . $value . '">' . $label . '</option>';
        }
        parent::__construct('select', array_merge(['name' => $name], $attributs), $optionsHtml);
    }
}

class Checkbox extends HTMLElement {
    public function __construct($name, $value, $checked = false, $attributs = []) {
        parent::__construct('input', array_merge(['type' => 'checkbox', 'name' => $name, 'value' => $value, 'checked' => ($checked ? 'checked' : '')], $attributs));
    }
}

class Radio extends HTMLElement {
    public function __construct($name, $value, $checked = false, $attributs = []) {
        parent::__construct('input', array_merge(['type' => 'radio', 'name' => $name, 'value' => $value, 'checked' => ($checked ? 'checked' : '')], $attributs));
    }
}

class Textarea extends HTMLElement {
    public function __construct($name, $placeholder = '', $attributs = []) {
        parent::__construct('textarea', array_merge(['name' => $name, 'placeholder' => $placeholder], $attributs));
    }
}

class Form {
    private $attributs;
    private $elements;

    public function __construct($action, $method = 'post', $attributs = []) {
        $this->attributs = array_merge(['action' => $action, 'method' => $method], $attributs);
        $this->elements = [];
    }

    public function addElement($element) {
        $this->elements[] = $element;
    }

    public function render() {
        // ... (méthode render)
    }
}

class FileUpload {
    public static function upload($inputName, $uploadDir) {
        // ... (méthode upload)
    }
}

class Session {
    public static function start() {
        session_start();
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
}

class Cookie {
    public static function set($key, $value, $expiration) {
        setcookie($key, $value, time() + $expiration);
    }

    public static function get($key, $default = null) {
        return $_COOKIE[$key] ?? $default;
    }

    public static function delete($key) {
        setcookie($key, '', time() - 3600);
    }
}

class Request {
    public static function get($key, $default = null) {
        return $_GET[$key] ?? $default;
    }

    public static function post($key, $default = null) {
        return $_POST[$key] ?? $_FILES[$key] ?? null;
    }
}



class Form {
    private $attributs;
    private $elements;

    public function __construct($attributs) {
        $this->attributs = $attributs;
        $this->elements = [];
    }

    public function addElement($element) {
        $this->elements[] = $element;
    }

    public function render() {
        $output = '<form';
        foreach ($this->attributs as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= '>';
        foreach ($this->elements as $element) {
            $output .= $element->render();
        }
        $output .= '</form>';
        return $output;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $subject = $_POST["subject"];
  $message = $_POST["message"];
  $subscribe = isset($_POST["subscribe"]) ? "Oui" : "Non";
  $priority = $_POST["priority"];
  
  
  $targetDir = "uploads/";
  $targetFile = $targetDir . basename($_FILES["attachment"]["name"]);
  move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile);

  
  $to = "contact@example.com";
  $headers = "From: $email";
  $body = "Nom: $name\n";
  $body .= "Email: $email\n";
  $body .= "Sujet: $subject\n";
  $body .= "Message: $message\n";
  $body .= "S'abonner à nous: $subscribe\n";
  $body .= "Priorité: $priority\n";
  if (!empty($_FILES["attachment"]["name"])) {
    $body .= "Pièce jointe: $targetFile\n";
  }
  
  mail($to, $subject, $body, $headers);
  
  echo "Le formulaire a été soumis avec succès!";
}
?>
