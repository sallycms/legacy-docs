<?php
/**
 * @sly  name   textfield
 * @sly  title  Textfeld
 */

$text     = $values->get('mytext');
$textarea = new sly_Form_Textarea('mytext', 'Text', $text);

$form->add($textarea);
