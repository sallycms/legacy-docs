<?php
/**
 * @sly  name   textfield
 * @sly  title  Textfeld
 * @sly  mobile true
 */

# ...

<?php

function cond($name, $modules) {
	foreach ($modules as $filename => $conditionValue) {
		if ($conditionValue !== true) {
			unset($modules[$filename]);
		}
	}

	return array_filter($templates);
}

sly_Service_Factory::getModuleService()->registerConditionEvaluator('mobile', 'cond');
