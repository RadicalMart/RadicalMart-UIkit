<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\RadicalMart\Site\Helper\RouteHelper;

// Check products errors
$app = Factory::getApplication();
if (empty($this->cart) || !empty($this->cart->productsErrors))
{
	foreach ($this->productsErrors as $error)
	{
		$message = $error['product_title'] . ': ' . $error['error_message'];
		if (!empty($error['error_description'])) $message .= ' ' . $error['error_description'];
		$app->enqueueMessage($message, 'error');
	}
	$app->redirect(Route::_(RouteHelper::getCartRoute(), false));
}

// Load assets
/** @var Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
$assets->useScript('com_radicalmart.site.checkout')
	->useScript('keepalive');

if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

$hasConsents = false;
$others      = [];
foreach ($this->form->getFieldsets() as $key => $fieldset)
{
	foreach ($this->form->getFieldset($key) as $field)
	{
		$name  = $field->fieldname;
		$group = $field->group;
		$type  = strtolower($field->type);
		$class = $this->form->getFieldAttribute($name, 'class', '', $group);
		$input = $field->input;
		if ($type === 'text' || $type === 'email')
		{
			$class .= ' uk-input';
		}
		elseif ($type === 'list' || preg_match('#<select#', $input))
		{
			$class .= ' uk-select';
		}
		elseif ($type === 'textarea' || preg_match('#<textarea#', $input))
		{
			$class .= ' uk-textarea';
		}
		elseif ($type === 'range')
		{
			$class .= ' uk-range';
		}

		$this->form->setFieldAttribute($name, 'class', $class, $group);
	}

	if ($key === 'consents')
	{
		$hasConsents = true;
	}

	if (!in_array($key, ['contacts', 'shipping', 'payment', 'billing', 'consents', 'standalone']))
	{
		$others[$key] = $fieldset;
	}
}
$i = 1;
?>
<div id="RadicalMart" class="checkout radicalmart-container">
	<?php if (empty($this->item) || empty($this->item->products)): ?>
		<h1 class="uk-h2 uk-margin uk-margin-remove-top uk-text-center">
			<?php echo Text::_('COM_RADICALMART_CART_EMPTY'); ?>
		</h1>
		<div class="uk-text-muted uk-text-center"><?php echo Text::_('COM_RADICALMART_CART_EMPTY_DESC'); ?></div>
	<?php else: ?>
		<h1 class="uk-h2 uk-margin uk-margin-remove-top uk-text-center">
			<?php echo $this->params->get('seo_checkout_h1', $this->menu->title); ?>
		</h1>
		<div radicalmart-checkout="loading"
			 class="uk-position-fixed uk-position-cover uk-overlay-default uk-flex uk-position-z-index uk-flex-center uk-flex-middle"
			 style="display: none">
			<div uk-spinner="ratio: 3"></div>
		</div>
		<form action="<?php echo $this->link; ?>" name="checkoutForm" id="checkoutForm" method="post"
			  enctype="multipart/form-data" radicalmart-checkout="form" class="uk-form form-validate">
			<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
				<div>
					<?php if ($contactsFields = $this->form->renderFieldset('contacts')): ?>
						<div id="checkout_contacts" class="uk-margin">
							<h2>
								<span class="uk-text-muted"><?php echo $i;
									$i++; ?>. </span>
								<?php echo Text::_('COM_RADICALMART_CONTACTS'); ?>
							</h2>
							<div class="uk-card uk-card-default uk-card-body uk-card-small">
								<div class="uk-child-width-1-2@s" uk-grid>
									<?php echo $contactsFields; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($this->item->shippingMethods): ?>
						<div id="checkout_shipping" class="uk-margin">
							<h2>
								<span class="uk-text-muted"><?php echo $i;
									$i++; ?>.</span>
								<?php echo Text::_('COM_RADICALMART_SHIPPING'); ?>
							</h2>
							<div class="uk-position-relative uk-card uk-card-default uk-card-body uk-card-small">
								<div><?php echo $this->form->getInput('id', 'shipping'); ?></div>
								<div id="checkout_shipping_loading"
									 class="uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-overlay-default"
									 style="display: none">
									<div uk-spinner="ratio: 3"></div>
								</div>
								<?php
								$content = null;
								if (!empty($this->item->shipping->layout))
								{
									$content = LayoutHelper::render($this->item->shipping->layout, [
										'item'     => $this->item,
										'form'     => $this->form,
										'shipping' => $this->item->shipping,
									]);
								}
								else
								{
									$fieldset = $this->form->renderFieldset('shipping');
									if (!empty($fieldset))
									{
										$content = '<div class="uk-child-width-1-2@s" uk-grid>'
											. $fieldset . '</div>';
									}
								} ?>
								<?php if (!empty($content)): ?>
									<div id="checkout_shipping_content" class="uk-margin-top">
										<?php echo $content; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($this->item->paymentMethods): ?>
						<div id="checkout_payment" class="uk-margin">
							<h2>
								<span class="uk-text-muted"><?php echo $i;
									$i++; ?>.</span>
								<?php echo Text::_('COM_RADICALMART_PAYMENT'); ?>
							</h2>
							<div class="uk-position-relative uk-card uk-card-default uk-card-body uk-card-small">
								<div><?php echo $this->form->getInput('id', 'payment'); ?></div>
								<div id="checkout_payment_loading"
									 class="uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-overlay-default"
									 style="display: none">
									<div uk-spinner="ratio: 3"></div>
								</div>
								<?php
								$content = null;
								if (!empty($this->item->payment->layout))
								{
									$content = LayoutHelper::render($this->item->payment->layout, [
										'item'    => $this->item,
										'form'    => $this->form,
										'payment' => $this->item->payment,
									]);
								}
								else
								{
									$fieldset = $this->form->renderFieldset('payment');
									if (!empty($fieldset))
									{
										$content = '<div class="uk-child-width-1-2@s" uk-grid>'
											. $fieldset . '</div>';
									}
								} ?>
								<?php if (!empty($content)): ?>
									<div id="checkout_payment_content" class="uk-margin-top">
										<?php echo $content; ?>
									</div>
								<?php endif; ?>
								<?php if ($this->item->payment->params->get('billing', 0)): ?>
									<div id="checkout_payment_billing" class="uk-margin-top">
										<div class="uk-h4">
											<?php echo Text::_('COM_RADICALMART_BILLING'); ?>
										</div>
										<div class="uk-child-width-1-2@s" uk-grid>
											<?php echo $this->form->renderFieldset('billing'); ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if (!empty($others)): ?>
						<?php foreach ($others as $key => $fieldset): ?>
							<div id="checkout_<?php echo $key; ?>" class="uk-margin">
								<h2>
									<span class="uk-text-muted"><?php echo $i;
										$i++; ?>.</span>
									<?php echo Text::_($fieldset->label); ?>
								</h2>
								<div class="uk-card uk-card-default uk-card-body uk-card-small">
									<div class="uk-child-width-1-2@s" uk-grid>
										<?php echo $this->form->renderFieldset($key); ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if ($hasConsents): ?>
						<div id="checkout_consents" class="uk-margin">
							<div class="uk-card uk-card-default uk-card-body uk-card-small">
								<?php foreach ($this->form->getFieldset('consents') as $field): ?>
									<div class="uk-margin">
										<?php echo $field->input; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="uk-width-1-4@m">
					<div class="uk-card uk-card-default uk-card-small" uk-sticky="offset: 30; bottom: true; media: @m;">
						<?php echo $this->loadTemplate('sidebar'); ?>
					</div>
				</div>
			</div>
			<input type="hidden" name="task" value="checkout.display"/>
			<?php echo $this->form->getInput('step'); ?>
			<?php echo $this->form->getInput('scroll'); ?>
			<?php echo HTMLHelper::_('form.token'); ?>
			<script>
				let scrollField = document.querySelector('input[name="jform[scroll]"]');
				if (scrollField && scrollField.value) window.scroll(0, scrollField.value);
			</script>
		</form>
	<?php endif; ?>
</div>