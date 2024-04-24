<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.0.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
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
		<h1 class="uk-h2 uk-margin uk-margin-remove-top uk-text-center">
			<?php echo Text::_('COM_RADICALMART_CART_EMPTY'); ?>
		</h1>
		<div class="uk-text-muted uk-text-center"><?php echo Text::_('COM_RADICALMART_CART_EMPTY_DESC'); ?></div>
	<?php else: ?>
		<h1 class="uk-h2 uk-margin uk-margin-remove-top uk-text-center">
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
				<div class="uk-card uk-card-default">
					<table class="uk-table uk-table-divider uk-table-responsive uk-table-middle">
						<thead class="uk-visible@m">
						<tr>
							<th class="uk-text-center">
								<?php echo Text::_('COM_RADICALMART_PRODUCT'); ?>
							</th>
							<th class="uk-text-center">
								<?php echo Text::_('COM_RADICALMART_PRICE'); ?>
							</th>
							<th class="uk-text-center">
								<?php echo Text::_('COM_RADICALMART_QUANTITY'); ?>
							</th>
							<th class="uk-text-center">
								<?php echo Text::_('COM_RADICALMART_SUM'); ?>
							</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($this->cart->products as $p => $product):
							$style = '';
							$class = '';
							$message = '';
							$error = false;
							$in_stock = true;
							if (isset($this->productsErrors[$p]))
							{
								$error = $this->productsErrors[$p];
								if ($error['error_type'] === 'in_stock')
								{
									$style    = ' style="opacity:0.5"';
									$in_stock = false;
								}
								elseif ($error['error_type'] === 'max_quantity')
								{
									$class = ' class="uk-alert uk-alert-danger"';
								}

								$message = $error['error_message'];
								if (!empty($error['error_description'])) $message .= ' ' . $error['error_description'];
							}
							?>
							<tr radicalmart-cart="product" data-id="<?php echo $product->id; ?>"
								data-key="<?php echo $p; ?>" data-cart-product="1" <?php echo $class; ?>>
								<td>
									<div class="uk-grid-small uk-child-width-expand uk-flex-middle"
										 uk-grid <?php echo $style; ?>>
										<div class="uk-width-1-4">
											<a href="<?php echo $product->link; ?>"
											   class="uk-height-max-small uk-width-1-1 uk-flex uk-flex-center uk-flex-middle">
												<?php echo MediaHelper::renderImage(
													'com_radicalmart.products.cart',
													$product->image,
													[
														'alt'     => $product->title,
														'loading' => 'lazy',
														'class'   => 'uk-height-max-medium'
													],
													[
														'product_id' => $product->id,
														'no_image'   => true,
														'thumb'      => true,
													]); ?>
											</a>
										</div>
										<div>
											<?php if ($product->category): ?>
												<div>
													<a href="<?php echo $product->category->link; ?>"
													   class="uk-text-nowrap uk-link-muted">
														<?php echo $product->category->title; ?>
													</a>
												</div>
											<?php endif; ?>
											<div>
												<a href="<?php echo $product->link; ?>"
												   class="uk-link-reset"><?php echo $product->title; ?></a>
											</div>
											<?php if (!empty($product->extra_display)): ?>
												<div class="uk-flex uk-flex-wrap">
													<?php foreach ($product->extra_display as $extra):
														if (empty($extra) || empty($extra['html']))
														{
															continue;
														}
														?>
														<div class="uk-margin-small-right uk-margin-small-bottom">
															<?php echo $extra['html']; ?>
														</div>
													<?php endforeach; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<?php if (!empty($message)): ?>
										<div class="uk-text-danger error-message">
											<?php echo $message; ?>
										</div>
									<?php endif; ?>
								</td>
								<td class="uk-text-center uk-text-nowrap">
									<?php if ($in_stock): ?>
										<div class="uk-text-small uk-text-muted"
											 radicalmart-cart="product-discount-block"
											 data-key="<?php echo $p; ?>"
											<?php if (empty($product->order['discount_enable'])) echo 'style="display:none"'; ?>>
											<s radicalmart-cart-display="products.<?php echo $p; ?>.order.base_string">
												<?php echo $product->order['base_string']; ?>
											</s>
											( - <span
													radicalmart-cart-display="products.<?php echo $p; ?>.order.discount_string">
												<?php echo $product->order['discount_string']; ?>
											</span>)
										</div>
										<div radicalmart-cart-display="products.<?php echo $p; ?>.order.final_string">
											<?php echo $product->order['final_string']; ?></div>
									<?php endif; ?>
								</td>
								<td class="uk-text-center">
									<?php if ($in_stock): ?>
										<div class="uk-flex uk-flex-center uk-flex-middle">
											<span class="uk-link uk-margin-small-right uk-text-danger"
												  uk-icon="icon: minus; ratio:2"
												  radicalmart-cart="quantity_minus"></span>
											<input radicalmart-cart="quantity" type="text" name="quantity" data-set="1"
												   class="uk-input uk-form-width-small uk-text-center"
												   step="<?php echo $product->quantity['step']; ?>"
												   min="<?php echo $product->quantity['min']; ?>"
												<?php if (!empty($product->quantity['max']))
												{
													echo 'max="' . $product->quantity['max'] . '"';
												} ?>
												   value="<?php echo $product->order['quantity']; ?>"/>
											<span class="uk-link uk-margin-small-left uk-text-success"
												  uk-icon="icon: plus; ratio:2"
												  radicalmart-cart="quantity_plus"></span>
										</div>
									<?php endif; ?>
								</td>
								<td class="uk-text-center">
									<?php if ($in_stock): ?>
										<div class="uk-text-small uk-text-muted uk-text-nowrap"
											 data-radicalmart-cart="product-discount-block"
											 data-key="<?php echo $p; ?>"
											<?php if (empty($product->order['discount_enable'])) echo 'style="display:none"'; ?>>
											<s radicalmart-cart-display="products.<?php echo $p; ?>.order.sum_base_string">
												<?php echo $product->order['sum_base_string']; ?>
											</s>
											( - <span
													radicalmart-cart-display="products.<?php echo $p; ?>.order.sum_discount_string">
												<?php echo $product->order['sum_discount_string']; ?>
											</span>)
										</div>
										<div class="uk-text-nowrap uk-text-bold"
											 radicalmart-cart-display="products.<?php echo $p; ?>.order.sum_final_string">
											<?php echo $product->order['sum_final_string']; ?>
										</div>
									<?php endif; ?>
								</td>
								<td class="uk-text-center">
									<span class="uk-link uk-text-danger" radicalmart-cart="remove"
										  uk-icon="icon:close; ratio:1" style="width: 20px"></span>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
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
			<div class="uk-width-1-4@m">
				<div class="uk-card uk-card-default uk-card-small">
					<div class="uk-card-body">
						<div class="uk-grid-small" uk-grid>
							<div class="uk-width-expand uk-text-muted">
								<?php echo Text::_('COM_RADICALMART_SUBTOTAL'); ?>
							</div>
							<div radicalmart-cart-display="total.base_string" data-display="base_string">
								<?php echo $this->cart->total['base_string']; ?>
							</div>
						</div>
						<div class="uk-grid-small" radicalmart-cart="discount-block" uk-grid
							<?php if (empty($this->cart->total['discount'])) echo 'style="display:none"'; ?>>
							<div class="uk-width-expand uk-text-muted">
								<?php echo Text::_('COM_RADICALMART_PRICE_DISCOUNT'); ?>
							</div>
							<div>
								−<span radicalmart-cart-display="total.discount_string">
									<?php echo $this->cart->total['discount_string']; ?>
								</span>
							</div>
						</div>
					</div>
					<hr class="uk-margin-remove">
					<div class="uk-card-body">
						<div class="uk-grid-small uk-flex-middle" uk-grid>
							<div class="uk-width-expand uk-text-muted">
								<?php echo Text::_('COM_RADICALMART_TOTAL'); ?>
							</div>
							<div class="uk-text-lead uk-text-bolder" radicalmart-cart-display="total.final_string">
								<?php echo $this->cart->total['final_string']; ?>
							</div>
						</div>
						<div class="uk-margin-small-top">
							<a href="<?php echo $this->checkout; ?>"
							   class="uk-button uk-button-primary uk-margin-small uk-width-1-1">
								<?php echo Text::_('COM_RADICALMART_CHECKOUT'); ?></a>
						</div>
						<div class="uk-text-small uk-text-left uk-text-muted uk-margin-small-top">
							<?php echo Text::_('JGRID_HEADING_ID') . ': ' . $this->cart->id; ?>
						</div>
					</div>
				</div>
				<?php if (!empty($this->modules['radicalmart-cart-sidebar'])): ?>
					<div class="uk-margin">
						<?php foreach ($this->modules['radicalmart-cart-sidebar'] as $module): ?>
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
	<?php endif; ?>
</div>