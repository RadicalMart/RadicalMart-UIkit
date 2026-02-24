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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Cart\HtmlView $this */

// Load assets
$assets = $this->document->getWebAssetManager();
$assets->useScript('com_radicalmart.site.cart');

if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

if (!empty($this->productsErrors))
{
	foreach ($this->productsErrors as $error)
	{
		$message = $error['product_title'] . ': ' . $error['error_message'];
		if (!empty($error['error_description']))
		{
			$message .= ' ' . $error['error_description'];
		}
		Factory::getApplication()->enqueueMessage($message, 'error');
	}
}
?>

<div id="RadicalMart" class="cart">
	<?php if (empty($this->cart) || empty($this->cart->products)): ?>
		<h1 class="uk-h2 uk-margin uk-margin-remove-top">
			<?php echo Text::_('COM_RADICALMART_CART_EMPTY'); ?>
		</h1>
		<div class="uk-text-muted uk-text-center"><?php echo Text::_('COM_RADICALMART_CART_EMPTY_DESC'); ?></div>
	<?php else: ?>
		<h1 class="uk-h2 uk-margin uk-margin-remove-top">
			<?php echo $this->params->get('seo_cart_h1',
					($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_CART')); ?>
		</h1>
		<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
			<div>
				<?php if (!empty($this->modules['radicalmart-cart-before-products'])): ?>
					<div class="uk-margin">
						<?php foreach ($this->modules['radicalmart-cart-before-products'] as $module): ?>
							<div class="uk-margin">
								<?php if ($module->showtitle): ?>
									<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
								<?php endif; ?>
								<div><?php echo $module->render; ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div>
					<?php foreach ($this->cart->products as $product_key => $product):

						$in_stock = true;
						if (isset($this->productsErrors[$product_key]))
						{
							$error = $this->productsErrors[$product_key];
							if ($error['error_type'] === 'in_stock')
							{
								$style    = 'opacity:0.5';
								$in_stock = false;
							}
							elseif ($error['error_type'] === 'max_quantity')
							{
								$class = 'uk-alert uk-alert-danger';
							}

							$message = $error['error_message'];
							if (!empty($error['error_description'])) $message .= ' ' . $error['error_description'];
						}
						?>
						<div class="uk-card uk-card-small uk-card-default uk-card-body uk-margin"
							 radicalmart-cart="product"
							 data-id="<?php echo $product->id; ?>"
							 data-key="<?php echo $product_key; ?>"
							 data-cart-product="1">
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
								<div class="uk-width-small@s uk-text-center@s uk-text-right@m uk-text-left@l">
									<?php if ($in_stock): ?>
										<div class="uk-text-small uk-text-muted"
											 radicalmart-cart="product-discount-block"
											 data-key="<?php echo $product_key; ?>"
												<?php if (empty($product->order['discount_enable'])) echo 'style="display:none"'; ?>>
											<s radicalmart-cart-display="products.<?php echo $product_key; ?>.order.base_string">
												<?php echo $product->order['base_string']; ?>
											</s>
											( - <span
													radicalmart-cart-display="products.<?php echo $product_key; ?>.order.discount_string">
												<?php echo $product->order['discount_string']; ?>
											</span>)
										</div>
										<div radicalmart-cart-display="products.<?php echo $product_key; ?>.order.final_string">
											<?php echo $product->order['final_string']; ?></div>
									<?php endif; ?>
								</div>
								<div class="uk-width-1-1@s uk-visible@s uk-hidden@l"></div>
								<div class="uk-width-auto">
									<?php if ($in_stock): ?>
										<div class="uk-flex-center uk-flex-middle">
											<span class="uk-link uk-margin-small-right uk-text-danger"
												  uk-icon="icon: minus;"
												  style="width: 1rem"
												  radicalmart-cart="quantity_minus"></span>
											<input radicalmart-cart="quantity" type="text" name="quantity"
												   data-set="1"
												   class="uk-input uk-text-center uk-form-width-small"
												   step="<?php echo $product->quantity['step']; ?>"
												   min="<?php echo $product->quantity['min']; ?>"
													<?php if (!empty($product->quantity['max']))
													{
														echo 'max="' . $product->quantity['max'] . '"';
													} ?>
												   value="<?php echo $product->order['quantity']; ?>"/>
											<span class="uk-link uk-margin-small-left uk-text-success"
												  uk-icon="icon: plus;"
												  style="width: 1rem"
												  radicalmart-cart="quantity_plus"></span>
										</div>
									<?php endif; ?>
								</div>
								<div class="uk-width-expand@s uk-width-small@l uk-text-center@s uk-text-right@l">
									<?php if ($in_stock): ?>
										<div class="uk-text-small uk-text-muted uk-text-nowrap"
											 data-radicalmart-cart="product-discount-block"
											 data-key="<?php echo $product_key; ?>"
												<?php if (empty($product->order['discount_enable'])) echo 'style="display:none"'; ?>>
											<s radicalmart-cart-display="products.<?php echo $product_key; ?>.order.sum_base_string">
												<?php echo $product->order['sum_base_string']; ?>
											</s>
											( - <span
													radicalmart-cart-display="products.<?php echo $product_key; ?>.order.sum_discount_string">
												<?php echo $product->order['sum_discount_string']; ?>
											</span>)
										</div>
										<div class="uk-text-nowrap uk-text-bold"
											 radicalmart-cart-display="products.<?php echo $product_key; ?>.order.sum_final_string">
											<?php echo $product->order['sum_final_string']; ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="uk-width-auto@s uk-visible@s">
									<span class="uk-link uk-text-danger" radicalmart-cart="remove"
										  uk-icon="icon:close;" style="width: 1rem"></span>
								</div>
							</div>
							<div class="uk-hidden@s uk-position-absolute uk-position-top-right uk-position-small">
								<span class="uk-link uk-text-danger" radicalmart-cart="remove"
									  uk-icon="icon:close; ratio:1"></span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php if (!empty($this->modules['radicalmart-cart-after-products'])): ?>
					<div class="uk-margin">
						<?php foreach ($this->modules['radicalmart-cart-after-products'] as $module): ?>
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
			<div class="uk-width-medium@m">
				<?php echo $this->loadTemplate('sidebar'); ?>
			</div>
		</div>
	<?php endif; ?>
</div>