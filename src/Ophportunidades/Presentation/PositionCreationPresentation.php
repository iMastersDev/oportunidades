<?php
namespace Ophportunidades\Presentation;

class PositionCreationPresentation
{
    const XMLNS = 'urn:Ophportunidades/Presentation';
    private $prefix = 'p:';
    private $dom;

    public function __construct()
    {
        $this->dom = new \DOMDocument();
    }

    private function createElement($name, $value = null)
    {
        $argv = func_get_args();
        $argv[0] = $this->prefix . $name;

        array_unshift($argv, PositionCreationPresentation::XMLNS);

        return call_user_func_array(array(
                $this->dom,
                'createElementNS'
        ), $argv);
    }

    private function createFieldElement($label, $type = 'text')
    {
        $field = $this->createElement('field');
        $field->setAttribute('name', 'title');
        $field->setAttribute('type', $type);
        $field->setAttribute('label', $label);

        return $field;
    }

    /**
     *
     * @return \DOMDocument
     */
    public function draw()
    {
        $root = $this->createElement('presentation');
        $title = $this->createElement('title', 'Cadastre uma oportunidade');
        $form = $this->createElement('form');

        $form->setAttribute('action', 'create.php');
        $form->setAttribute('method', 'post');

        $form->appendChild($this->createFieldElement('Título da oferta'));
        $form->appendChild($this->createFieldElement('Descrição da oferta'));
        $form->appendChild($this->createFieldElement('Local da oferta'));
        $form->appendChild($this->createFieldElement('Formato da oferta'));
        $form->appendChild($this->createFieldElement('Tipo da oferta'));
        $form->appendChild($this->createFieldElement('Tipo do contrato'));
        $form->appendChild($this->createFieldElement('Skills requeridos'));
        $form->appendChild($this->createFieldElement('Faixa salarial'));
        $form->appendChild($this->createFieldElement('Salvar', 'submit'));

        $root->appendChild($title);
        $root->appendChild($form);
        $this->dom->appendChild($root);

        return $this->dom;
    }

    public function getPresentationSchema()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'presentation.xsd';
    }
}