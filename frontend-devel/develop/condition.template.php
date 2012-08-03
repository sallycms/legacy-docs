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
 * The handle is given the name of the current condition. Evaluators should
 * only do something when the $name is of an expected value. In this case, we
 * do only our work if $name is 'mobile'.
 *
 * The list of templates is associtative and has the template's filename as the
 * key and the condition value as the element's value. It looks like this:
 *
 *   array(
 *     'desktop.php' => false,
 *     'mobile.php' => true
 *   )
 *
 * The evaluator should remove all elements from the list, that don't match the
 * expected value.
 *
 * @param  string $name       the condition name
 * @param  array  $templates  list of templates
 * @return array              list of filtered templates
 */
function myMobileEvaluator($name, array $templates) {
	// do nothing if unknown condition
	if ($name !== 'mobile') return $templates;

	$isMobile = magicFunctionToDetectIfMobile();

	foreach ($templates as $filename => $conditionValue) {
		if ($conditionValue !== $isMobile) {
			unset($templates[$filename]);
		}
	}

	return $templates;
}

<?php

$service = sly_Service_Factory::getTemplateService();
$service->registerConditionEvaluator('mobile', 'myMobileEvaluator');
