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

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\Plugin\RadicalMartShipping\Addresses\Extension\Addresses;

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

if (empty($shipping))
{
	return false;
}

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = Factory::getApplication()->getDocument()->getWebAssetManager();
$assets->getRegistry()->addExtensionRegistryFile('plg_radicalmart_shipping_addresses');
$assets->useScript('plg_radicalmart_shipping_addresses.site.checkout');

$defaultFieldsParams = Addresses::$defaultFieldsParams;
?>
<div radicalmart-shipping-addresses="checkout">
	<div>
		<?php echo $form->getInput('shipping_address_uid', 'shipping'); ?>
	</div>
	<div class="uk-grid-small" radicalmart-shipping-addresses="form" uk-grid style="display: none">
		<?php if ($shipping->params->get('field_country', $defaultFieldsParams['country']) !== 'hidden'): ?>
			<div class="uk-width-2-3@s"><?php echo $form->renderField('country', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_region', $defaultFieldsParams['region']) !== 'hidden'): ?>
			<div class="uk-width-1-3@s"><?php echo $form->renderField('region', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_city', $defaultFieldsParams['city']) !== 'hidden'): ?>
			<div class="uk-width-2-3@s"><?php echo $form->renderField('city', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_zip', $defaultFieldsParams['zip']) !== 'hidden'): ?>
			<div class="uk-width-1-3@s"><?php echo $form->renderField('zip', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_street', $defaultFieldsParams['street']) !== 'hidden'): ?>
			<div class="uk-width-2-3@s"><?php echo $form->renderField('street', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_house', $defaultFieldsParams['house']) !== 'hidden'): ?>
			<div class="uk-width-1-3@s"><?php echo $form->renderField('house', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_building', $defaultFieldsParams['building']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->renderField('building', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_entrance', $defaultFieldsParams['entrance']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->renderField('entrance', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_floor', $defaultFieldsParams['floor']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->renderField('floor', 'shipping'); ?></div>
		<?php endif; ?>
		<?php if ($shipping->params->get('field_apartment', $defaultFieldsParams['apartment']) !== 'hidden'): ?>
			<div class="uk-width-1-4@s"><?php echo $form->renderField('apartment', 'shipping'); ?></div>
		<?php endif; ?>
	</div>
	<?php if ($shipping->params->get('field_comment', $defaultFieldsParams['comment']) !== 'hidden'): ?>
		<div class="uk-margin-top"><?php echo $form->renderField('comment', 'shipping'); ?></div>
	<?php endif; ?>
</div>