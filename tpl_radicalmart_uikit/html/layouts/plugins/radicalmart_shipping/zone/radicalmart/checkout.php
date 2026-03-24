<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Plugin\RadicalMartShipping\Zone\Extension\Zone;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  Form   $form     Form object.
 * @var  object $item     Checkout object.
 * @var  object $shipping Checkout shipping method object.
 *
 */

foreach ($form->getFieldset('shipping') as $field)
{
	$fieldname = $field->__get('fieldname');
	$group     = $field->__get('group');
	$hint      = $field->__get('hint');
	if (empty($hint))
	{
		$hint = $form->getFieldAttribute($fieldname, 'label', '', $group);
	}
	if (!empty($field->__get('required')))
	{
		$hint = Text::_($hint) . ' *';
	}

	$form->setFieldAttribute($fieldname, 'hint', $hint, $group);
}

/** @var \Joomla\CMS\Document\Document $document */
// Load assets
$app      = Factory::getApplication();
$document = $app->getDocument();
$assets   = $document->getWebAssetManager();
$assets->getRegistry()->addExtensionRegistryFile('plg_radicalmart_shipping_zone');
$assets->useScript('plg_radicalmart_shipping_zone.site.checkout');

$defaultFieldsParams = Zone::$defaultFieldsParams;

$hasPrices = true;
if (empty($shipping->prices))
{
	$hasPrices = false;
}
elseif (empty($shipping->prices[$item->currency['group']]))
{
	$hasPrices = false;
}
elseif (empty($shipping->prices[$item->currency['group']]['in_zone'])
		&& empty($shipping->prices[$item->currency['group']]['out_zone']))
{
	$hasPrices = false;
}
?>
<div radicalmart-shipping-zone="checkout">
	<div radicalmart-checkout-display="shipping.error" class="uk-alert uk-alert-danger" style="display: none"></div>
	<div radicalmart-checkout-display="shipping.message" class="uk-alert uk-alert-primary" style="display: none"></div>
	<div class="uk-grid-small" uk-grid="">
		<?php if ($shipping->params->get('field_country', $defaultFieldsParams['country']) !== 'hidden'): ?>
			<div class="uk-width-1-1"><?php echo $form->getInput('country', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_region', $defaultFieldsParams['region']) !== 'hidden'): ?>
			<div class="uk-width-1-3@s"><?php echo $form->getInput('region', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_city', $defaultFieldsParams['city']) !== 'hidden'): ?>
			<div class="uk-width-2-3@s"><?php echo $form->getInput('city', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_zip', $defaultFieldsParams['zip']) !== 'hidden'): ?>
			<div class="uk-width-1-3@s"><?php echo $form->getInput('zip', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_street', $defaultFieldsParams['street']) !== 'hidden'): ?>
			<div class="uk-width-2-3@s"><?php echo $form->getInput('street', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_house', $defaultFieldsParams['house']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('house', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_building', $defaultFieldsParams['building']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('building', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_entrance', $defaultFieldsParams['entrance']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('entrance', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_floor', $defaultFieldsParams['floor']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('floor', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_apartment', $defaultFieldsParams['apartment']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->getInput('apartment', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_comment', $defaultFieldsParams['comment']) !== 'hidden'): ?>
			<div class="uk-width-1-1"><?php echo $form->getInput('comment', 'shipping'); ?></div>
		<?php endif; ?>
	</div>
	<?php foreach ($defaultFieldsParams as $field_name => $default)
	{
		if ($shipping->params->get('field_' . $field_name, $default) === 'hidden')
		{
			echo $form->getInput($field_name, 'shipping');
		}
	}
	echo $form->getInput('in_zone', 'shipping');
	?>
	<?php if ($hasPrices): ?>
		<div class="uk-flex uk-flex-middle uk-margin-small">
			<div class="uk-margin-small-right uk-text-bold">
				<?php echo Text::_('PLG_RADICALMART_SHIPPING_ZONE_COST') . ': '; ?>
			</div>
			<div radicalmart-checkout-display="shipping.order.price.final_string"></div>
			<div class="uk-margin-small-left">
				<button type="button" radicalmart-shipping-zone="calculate_checkout"
						class="uk-button uk-button-small uk-button-secondary">
					<?php echo Text::_('PLG_RADICALMART_SHIPPING_ZONE_COST_CALCULATE'); ?>
				</button>
			</div>
		</div>
	<?php endif; ?>
</div>