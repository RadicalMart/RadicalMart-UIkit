<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.17
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\Plugin\RadicalMartShipping\Zone\Extension\Zone;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  \Joomla\CMS\Form\Form $form      Form object.
 * @var  object                $item      Customer object.
 * @var  object                $shipping  Checkout shipping method object.
 * @var  array                 $fieldsets Checkout shipping method object.
 * @var  string                $group     Fields group target.
 *
 */

foreach ($form->getFieldset('shipping_method_' . $shipping->id) as $field)
{
	$fieldname = $field->__get('fieldname');
	$group     = $field->__get('group');
	$hint      = $field->__get('hint');
	if (empty($hint))
	{
		$hint = $form->getFieldAttribute($fieldname, 'label', '', $group);
	}

	$form->setFieldAttribute($fieldname, 'hint', $hint, $group);
}

$defaultFieldsParams = Zone::$defaultFieldsParams;
?>

<div id="personal_shipping_method_<?php echo $shipping->id; ?>" class="">
	<div class="uk-grid-small" uk-grid="">
		<?php if ($shipping->params->get('field_country', $defaultFieldsParams['country']) !== 'hidden'): ?>
			<div class="uk-width-1-1"><?php echo $form->getInput('country', $group); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_region', $defaultFieldsParams['region']) !== 'hidden'): ?>
			<div class="uk-width-1-3@s"><?php echo $form->getInput('region', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_city', $defaultFieldsParams['city']) !== 'hidden'): ?>
			<div class="uk-width-2-3@s"><?php echo $form->getInput('city', $group); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_zip', $defaultFieldsParams['zip']) !== 'hidden'): ?>
			<div class="uk-width-1-3@s"><?php echo $form->getInput('zip', $group); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_street', $defaultFieldsParams['street']) !== 'hidden'): ?>
			<div class="uk-width-2-3@s"><?php echo $form->getInput('street', $group); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_house', $defaultFieldsParams['house']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('house', $group); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_building', $defaultFieldsParams['building']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('building', $group); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_entrance', $defaultFieldsParams['entrance']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('entrance', $group); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_floor', $defaultFieldsParams['floor']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('floor', $group); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_apartment', $defaultFieldsParams['apartment']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('apartment', $group); ?></div>
		<?php endif; ?>
	</div>
</div>