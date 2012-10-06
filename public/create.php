<?php
require 'bootstrap.php';

use Ophportunidades\Presentation\PositionCreationPresentation;

$presentation = new PositionCreationPresentation();
$drew = $presentation->draw();

$xsl = new DOMDocument();
$xsl->load('theme/default/template.xsl');

$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);

echo $proc->transformToDoc($drew)->saveHTML();