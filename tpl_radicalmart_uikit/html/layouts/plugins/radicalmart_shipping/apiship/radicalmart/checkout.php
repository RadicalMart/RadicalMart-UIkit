<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2025 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Plugin\RadicalMartShipping\ApiShip\Extension\ApiShip;

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
	return;
}

$delivery_type = (int) $shipping->params->get('delivery_type', 2);

// Load assets
/** @var \Joomla\CMS\Document\Document $document */
$document = Factory::getApplication()->getDocument();

/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $document->getWebAssetManager();
$assets->getRegistry()
	->addExtensionRegistryFile('plg_radicalmart_shipping_apiship');

$assets->useScript('plg_radicalmart_shipping_apiship.site.checkout');
?>
<div class="uk-position-relative">
	<div radicalmart-checkout-display="shipping.error" class="uk-alert uk-alert-danger" style="display: none"></div>
	<div radicalmart-checkout-display="shipping.message" class="uk-alert uk-alert-primary" style="display: none"></div>
	<div radicalmart-shipping-apiship-checkout="loading"
		 class="uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-overlay-default uk-position-z-index">
		<div uk-spinner="ratio: 3"></div>
	</div>
	<?php if ($delivery_type === 2): ?>
		<div class="uk-margin">
			<div class="uk-margin-small-bottom uk-h4">
				<?php echo Text::_($form->getFieldAttribute('point', 'label', '', 'shipping')); ?>
			</div>
			<div>
				<?php echo $form->getInput('point', 'shipping'); ?>
			</div>
		</div>
	<?php else: ?>
		<div class="uk-margin">
			<div class="uk-margin-small-bottom uk-h4">
				<?php echo Text::_($form->getFieldAttribute('address', 'label', '', 'shipping')); ?>
			</div>
			<div>
				<?php echo $form->getInput('address', 'shipping'); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="uk-margin" radicalmart-shipping-apiship-checkout="tariff">
		<div class="uk-margin-small-bottom uk-h4">
			<?php echo Text::_($form->getFieldAttribute('tariff', 'label', '', 'shipping')); ?>
		</div>
		<div>
			<?php echo $form->getInput('tariff', 'shipping'); ?>
		</div>
	</div>

	<?php if ($shipping->params->get('field_comment', 'hidden') !== 'hidden'): ?>
		<div class="uk-margin"><?php echo $form->getInput('comment', 'shipping'); ?></div>
	<?php endif; ?>

	<div class="uk-flex uk-flex-middle uk-margin-small">
		<div class="uk-margin-small-right uk-text-bold">
			<?php echo Text::_('PLG_RADICALMART_SHIPPING_APISHIP_COST') . ': '; ?>
		</div>
		<div radicalmart-checkout-display="shipping.order.price.final_string">
			<?php echo Text::_('PLG_RADICALMART_SHIPPING_APISHIP_COST_CALCULATE'); ?>
		</div>
	</div>
</div>