<?php
/**
 * @sly name   default
 * @sly title  Standard
 * @sly active true
 * @sly mobile true
 */

# ...

<?php

function cond($name, $templates) {
	foreach ($templates as $filename => $conditionValue) {
		if ($conditionValue !== true) {
			unset($templates[$filename]);
		}
	}

	return array_filter($templates);
}

sly_Service_Factory::getTemplateService()->registerConditionEvaluator('mobile', 'cond');
