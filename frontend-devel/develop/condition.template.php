<?php
/**
 * @sly name   default
 * @sly title  Standard
 * @sly mobile true
 */
?>
<div class="page mobile">...</div>

<?php
/**
 * @sly name   default
 * @sly title  Standard
 * @sly mobile false
 */
?>
<div class="page desktop">...</div>

<?php

/**
 * Condition evaluator
 *
 * This method will handle the given condition named $name and remove all
 * candidate templates whose value for $name is not true.
 *
 * @param  string $name       the condition name (actually ignored here)
 * @param  array  $templates  list of templates ({tpl: condition_value, tpl2: cond_value})
 * @return array              list of filtered templates
 */
function myTrueEvaluator($name, array $templates) {
	foreach ($templates as $filename => $conditionValue) {
		if ($conditionValue !== true) {
			unset($templates[$filename]);
		}
	}

	return array_filter($templates);
}

<?php

$service = sly_Service_Factory::getTemplateService();
$service->registerConditionEvaluator('mobile', 'myTrueEvaluator');
