<?php
/**
 * @sly  name   textfield
 * @sly  title  Textfeld
 */

// beide Varianten sind identisch

// A
$list = new sly_Form_Widget_LinkList('mylist', 'Artikelliste', $values->get('mylist'));
$list->setMin(5);
$list->filterByArticleTypes(array('job'));
$form->add($list);

// B
$form->addLinkList('mylist', 'Artikelliste', $values->get('mylist'), false, array('job'))->setMin(5);
