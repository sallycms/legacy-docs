<?php
/**
 * @sly  name   textfield
 * @sly  title  Textfeld
 */

$form
   ->addLinkList('mylist', 'Artikelliste', $values->get('mylist'), false, array('job'))
   ->setMin(5);

$form
   ->addInput('width', 'Breite', $values->get('width'))
   ->setAnnotation(' px')
   ->setHelpText('Dies ist die Breite des Bildes.');

$form
   ->addCheckbox('download', 'Download', $values->get('download'))
   ->setHelpText('Gibt an, ob die Datei heruntergeladen werden darf.');

// ...
