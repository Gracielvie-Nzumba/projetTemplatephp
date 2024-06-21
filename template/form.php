<?php
namespace App;

class Form {
    private $attributs;
    private $elements;

    public function __construct($attribut) {
        $this->attribut = $attribut;
        $this->elements = [];
    }

    public function addElement($element) {
        $this->elements[] = $element;
    }

    public function render() {
        $output = '<form';
        foreach ($this->attribut as $key => $value) {
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
?>
