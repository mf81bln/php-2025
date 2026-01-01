<?php

declare(strict_types=1);

namespace Contact\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class ContactForm extends Form
{
    public function __construct(?string $name = null)
    {
        parent::__construct('contact');

        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class,
        ]);

        $this->add([
            'name' => 'name',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'required' => true,
                'class' => 'form-control',
                'placeholder' => 'Vollständiger Name',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => Element\Email::class,
            'options' => [
                'label' => 'E-Mail',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'email@beispiel.de',
            ],
        ]);

        $this->add([
            'name' => 'phone',
            'type' => Element\Tel::class,
            'options' => [
                'label' => 'Telefon',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => '+49 123 456789',
            ],
        ]);

        $this->add([
            'name' => 'notes',
            'type' => Element\Textarea::class,
            'options' => [
                'label' => 'Notizen',
            ],
            'attributes' => [
                'class' => 'form-control',
                'rows' => 4,
                'placeholder' => 'Zusätzliche Informationen...',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Speichern',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}
