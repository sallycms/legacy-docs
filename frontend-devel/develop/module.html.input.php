<?php
/**
 * @sly  name   textfield
 * @sly  title  Textfeld
 */
$text = $values->get('mytext');

?>
<label>Text</label>
<textarea name="slicevalue[mytext]" rows="5" cols="10"><?php echo $text ?></textarea>
