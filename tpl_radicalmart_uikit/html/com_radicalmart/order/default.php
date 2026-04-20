<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.16
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\RadicalMart\Administrator\Helper\QuantityHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Order\HtmlView $this */

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
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

?>
<div id="RadicalMart" class="order">
	<h1 class="uk-h2 uk-margin uk-margin-remove-top">
		<?php echo $this->params->get('seo_order_h1', $this->order->title); ?>
	</h1>

	<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
		<div>
			<div class="order_products">
				<?php foreach ($this->order->products as $product_key => $product): ?>
					<div class="uk-card uk-card-small uk-card-default uk-card-body uk-margin">
						<div class="uk-flex uk-flex-middle uk-grid-small" uk-grid>
							<div class="uk-width-auto uk-visible@s">
								<div class="uk-position-relative uk-width-1-1">
									<?php echo LayoutHelper::render('components.radicalmart.items.image',
											[
													'product'   => $product,
													'width_px'  => 64,
													'height_px' => 64,
											]); ?>
								</div>
							</div>
							<div class="uk-width-expand">
								<?php if ($product->category): ?>
									<div>
										<a href="<?php echo $product->category->link; ?>"
										   class="uk-text-nowrap uk-text-small uk-link-muted">
											<?php echo $product->category->title; ?>
										</a>
									</div>
								<?php endif; ?>
								<div>
									<a href="<?php echo $product->link; ?>" class="uk-link-reset">
										<?php echo $product->title; ?>
									</a>
								</div>
							</div>
							<div class="uk-width-1-1 uk-hidden@l"></div>
							<div class="uk-width-1-2 uk-width-small@s uk-text-left">
								<?php if ($product->order['discount_enable']): ?>
									<div class="uk-text-small uk-text-muted">
										<s><?php echo $product->order['base_string']; ?></s>
										<?php echo ' ( - ' . $product->order['discount_string'] . ')'; ?>
									</div>
								<?php endif; ?>
								<div><?php echo $product->order['final_string']; ?></div>
							</div>
							<div class="uk-width-1-2 uk-width-expand@s uk-width-small@l uk-text-right uk-text-center@s">
								<div>
									<?php echo $product->order['quantity']; ?>
								</div>
								<div class="uk-text-meta">
									<?php echo QuantityHelper::getUnitsString($product->params->get('quantity_units'), true); ?>
								</div>
							</div>
							<div class="uk-width-small@s uk-text-right@s">
								<?php if ($product->order['discount_enable']): ?>
									<div class="uk-text-small uk-text-muted uk-text-nowrap">
										<s><?php echo $product->order['sum_base_string']; ?></s>
										<?php echo ' ( - ' . $product->order['sum_discount_string'] . ')'; ?>
									</div>
								<?php endif; ?>
								<div class="uk-text-nowrap uk-text-bold">
									<?php echo $product->order['sum_final_string']; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php foreach ($this->form->getFieldsets() as $key => $fieldset):
				$fields = $this->form->getFieldset($key);
				if (empty($fields))
				{
					continue;
				}
				?>
				<div id="order_<?php echo $key; ?>" class="uk-margin uk-card uk-card-small uk-card-default">
					<?php if (!empty($fieldset->label)): ?>
						<div class="uk-card-header">
							<h2 class="uk-h4 uk-margin-remove">
								<?php echo Text::_($fieldset->label); ?>
							</h2>
						</div>
					<?php endif; ?>
					<div class="uk-card-body uk-form-horizontal">
						<?php foreach ($fields as $field):
							$name = $field->__get('fieldname');
							$group = $field->__get('group');
							$label = $this->form->getFieldAttribute($name, 'label', '', $group);
							$input = $this->form->getInput($name, $group);
							if (empty($label) && empty($input))
							{
								continue;
							}
							?>
							<div class="uk-margin-small">
								<?php if (!empty($label)): ?>
									<div class="uk-form-label">
										<?php echo Text::_($label); ?>
									</div>
								<?php endif; ?>
								<?php if (!empty($input)): ?>
									<div class="uk-form-controls uk-form-controls-text">
										<?php echo $input; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="uk-width-medium@m">
			<?php echo $this->loadTemplate('sidebar'); ?>
		</div>
	</div>
</div>