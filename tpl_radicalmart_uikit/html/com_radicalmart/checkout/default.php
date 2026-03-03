<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.5
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\RadicalMart\Site\Helper\RouteHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Checkout\HtmlView $this */

// Check products errors
$app = Factory::getApplication();
if (empty($this->cart) || !empty($this->productsErrors))
{
	foreach ($this->productsErrors as $error)
	{
		$message = $error['product_title'] . ': ' . $error['error_message'];
		if (!empty($error['error_description']))
		{
			$message .= ' ' . $error['error_description'];
		}
		$app->enqueueMessage($message, 'error');
	}
	$app->redirect(Route::_(RouteHelper::getCartRoute(), false));
}

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
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

// Set uikit classes to form
require_once(JPATH_THEMES . '/system/radicalmart_uikit/helpers/uikit_form_classes.php');
setUikitFormClasses($this->form);

$hasConsents = false;
$others      = [];
foreach ($this->form->getFieldsets() as $key => $fieldset)
{
	if ($key === 'consents')
	{
		$hasConsents = true;
	}

	if (!in_array($key, ['contacts', 'shipping', 'payment', 'billing', 'consents', 'standalone']))
	{
		$others[$key] = $fieldset;
	}
}
?>
<div id="RadicalMart" class="checkout">
	<?php if (empty($this->item) || empty($this->item->products)): ?>
		<h1 class="uk-h2 uk-margin uk-margin-remove-top uk-text-center">
			<?php echo Text::_('COM_RADICALMART_CART_EMPTY'); ?>
		</h1>
		<div class="uk-text-muted uk-text-center"><?php echo Text::_('COM_RADICALMART_CART_EMPTY_DESC'); ?></div>
	<?php else: ?>
		<h1 class="uk-h2 uk-margin uk-margin-remove-top">
			<?php echo $this->params->get('seo_checkout_h1',
					($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_CHECKOUT')); ?>
		</h1>
		<div radicalmart-checkout="loading"
			 class="uk-position-fixed uk-position-cover uk-overlay-default uk-flex uk-position-z-index uk-flex-center uk-flex-middle"
			 style="display: none">
			<div class="uk-text-center">
				<div uk-spinner="ratio: 3"></div>
				<div class="uk-text-center" radicalmart-checkout="create-order-progress"></div>
			</div>
		</div>
		<form action="<?php echo $this->action; ?>" name="checkoutForm" id="checkoutForm" method="post"
			  enctype="multipart/form-data" radicalmart-checkout="form" class="uk-form form-validate">
			<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
				<div>
					<?php if (!empty($this->modules['radicalmart-checkout-before-form'])): ?>
						<div class="uk-margin">
							<?php foreach ($this->modules['radicalmart-checkout-before-form'] as $module): ?>
								<div class="uk-margin">
									<?php if ($module->showtitle): ?>
										<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
									<?php endif; ?>
									<div><?php echo $module->render; ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<?php if ($contactsFields = $this->form->renderFieldset('contacts')): ?>
						<div id="checkout_contacts"
							 class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
							<div class="uk-card-header">
								<h2 class="uk-margin-remove uk-h4">
									<?php echo Text::_('COM_RADICALMART_ORDER_RECIPIENT_CONTACTS'); ?>
								</h2>
							</div>
							<div id="checkout_contacts_loading"
								 class="uk-position-cover uk-position-z-index
									 uk-flex uk-flex-center uk-flex-middle
									 uk-overlay-default"
								 style="display: none">
								<div uk-spinner="ratio: 3"></div>
							</div>
							<div class="uk-card-body">
								<div class="uk-child-width-1-2@s" uk-grid>
									<?php echo $contactsFields; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($this->item->shippingMethods): ?>
						<div id="checkout_shipping"
							 class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
							<div class="uk-card-header">
								<h2 class="uk-margin-remove uk-h4">
									<?php echo Text::_('COM_RADICALMART_SHIPPING'); ?>
								</h2>
							</div>
							<div id="checkout_shipping_loading"
								 class="uk-position-cover uk-position-z-index
									 uk-flex uk-flex-center uk-flex-middle
									 uk-overlay-default"
								 style="display: none">
								<div uk-spinner="ratio: 3"></div>
							</div>
							<div class="uk-card-body">
								<div><?php echo $this->form->getInput('id', 'shipping'); ?></div>
								<?php $content = null;
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
						<div id="checkout_payment"
							 class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
							<div class="uk-card-header">
								<h2 class="uk-margin-remove uk-h4">
									<?php echo Text::_('COM_RADICALMART_PAYMENT'); ?>
								</h2>
							</div>
							<div id="checkout_payment_loading"
								 class="uk-position-cover uk-position-z-index
									 uk-flex uk-flex-center uk-flex-middle
									 uk-overlay-default"
								 style="display: none">
								<div uk-spinner="ratio: 3"></div>
							</div>
							<div class="uk-card-body">
								<div><?php echo $this->form->getInput('id', 'payment'); ?></div>
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
										<div class="uk-h5">
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
						<?php foreach ($others as $key => $fieldset):
							if (!empty($fieldset->layout))
							{
								$content = LayoutHelper::render($fieldset->layout, [
										'item'     => $this->item,
										'form'     => $this->form,
										'fieldset' => $fieldset,
								]);
							}
							else
							{
								$fieldset_content = $this->form->renderFieldset($fieldset->name);
								if (!empty($fieldset->full_width))
								{
									$fieldset_class = 'uk-child-width-1-1';
								}
								else
								{
									$fieldset_class = 'uk-child-width-1-2@s';
								}

								if (!empty($fieldset->class))
								{
									$fieldset_class .= ' ' . $fieldset->class;
								}

								if (!empty($fieldset))
								{
									$content = '<div class="' . $fieldset_class . '" uk-grid>'
											. $fieldset_content . '</div>';
								}
							}

							if (empty($content))
							{
								continue;
							}

							?>
							<div id="checkout_<?php echo $key; ?>"
								 class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
								<div class="uk-card-header">
									<h2 class="uk-margin-remove uk-h4">
										<?php echo Text::_($fieldset->label); ?>
									</h2>
								</div>
								<div id="checkout_<?php echo $key; ?>_loading"
									 class="uk-position-cover uk-position-z-index
									 uk-flex uk-flex-center uk-flex-middle
									 uk-overlay-default"
									 style="display: none">
									<div uk-spinner="ratio: 3"></div>
								</div>
								<div class="uk-card-body">
									<?php echo $content; ?>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if ($hasConsents): ?>
						<div id="checkout_consents"
							 class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
							<div class="uk-card-body uk-card-small">
								<?php foreach ($this->form->getFieldset('consents') as $field): ?>
									<div class="uk-margin">
										<?php echo $field->__get('input'); ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if (!empty($this->modules['radicalmart-checkout-after-form'])): ?>
						<div class="uk-margin">
							<?php foreach ($this->modules['radicalmart-checkout-after-form'] as $module): ?>
								<div class="uk-margin">
									<?php if ($module->showtitle): ?>
										<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
									<?php endif; ?>
									<div><?php echo $module->render; ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

				</div>
				<div class="uk-width-medium@m uk-width-large@l">
					<?php echo $this->loadTemplate('sidebar'); ?>
					<?php if (!empty($this->modules['radicalmart-checkout-sidebar'])): ?>
						<div class="uk-margin">
							<?php foreach ($this->modules['radicalmart-checkout-sidebar'] as $module): ?>
								<div class="uk-margin">
									<?php if ($module->showtitle): ?>
										<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
									<?php endif; ?>
									<div><?php echo $module->render; ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
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