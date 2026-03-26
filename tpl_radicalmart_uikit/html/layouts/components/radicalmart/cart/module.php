<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.15
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $cart Cart object.
 *
 */
?>
<div radicalmart-cart-layout="module">
	<div id="radicalmart_cart_module" uk-offcanvas="flip: true; overlay: true">
		<div class="uk-offcanvas-bar uk-padding-remove">
			<div class="uk-flex uk-flex-column uk-height-1-1">
				<div>
					<div class="uk-flex uk-flex-between uk-padding-small">
						<div>
							<div class="uk-h3 uk-margin-remove">
								<?php echo Text::_('COM_RADICALMART_CART'); ?>
							</div>
							<?php if ($cart): ?>
								<div class="uk-text-small uk-text-muted">
									<?php echo Text::_('JGRID_HEADING_ID') . ': ' . $cart->id; ?>
								</div>
							<?php endif; ?>
						</div>
						<div>
							<span class="uk-offcanvas-close" uk-close></span>
						</div>
					</div>
					<hr class="uk-margin-remove">
				</div>
				<?php if ($cart && !empty($cart->products)): ?>
					<div class="uk-flex uk-flex-column uk-overflow-auto" style="flex-grow: 1">
						<table class="uk-table uk-table-divider uk-table-middle uk-table-small uk-table-striped">
							<tbody>
							<?php foreach ($cart->products as $product_key => $product): ?>
								<tr radicalmart-cart="product"
									data-id="<?php echo $product->id; ?>"
									data-key="<?php echo $product_key; ?>"
									data-cart-product="1">
									<td>
										<div class="">
											<?php if ($product->category): ?>
												<div class="uk-text-small">
													<a href="<?php echo $product->category->link; ?>"
													   class="uk-text-nowrap uk-link-muted">
														<?php echo $product->category->title; ?>
													</a>
												</div>
											<?php endif; ?>
											<div class="">
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
									</td>
									<td class="uk-text-right">
										<div class="uk-text-muted uk-text-nowrap">
											<?php echo $product->order['quantity'] . ' x '
													. $product->order['final_string']; ?>
										</div>
										<div class="uk-text-bold uk-text-nowrap">
											<?php echo $product->order['sum_final_string']; ?>
										</div>
									</td>
									<td>
										<a href class="uk-link uk-text-danger"
										   style="width: 1rem"
										   radicalmart-cart="remove" uk-close></a>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div>
						<hr class="uk-margin-remove">
						<div class="uk-padding-small">
							<div class="uk-flex uk-flex-wrap uk-flex-between uk-margin-small-bottom uk-h4">
								<div class="uk-text-muted">
									<?php echo Text::_('COM_RADICALMART_TOTAL'); ?>
								</div>
								<div class="uk-text-bold uk-text-nowrap" radicalmart-cart="counter_total_sum_string">
									<?php echo $cart->total['final_string']; ?>
								</div>
							</div>
							<div class="uk-flex uk-flex-wrap uk-flex-between">
								<a href="<?php echo $cart->link; ?>" class="uk-modal-close uk-button uk-button-default">
									<?php echo Text::_('COM_RADICALMART_CART'); ?></a>
								<a href="<?php echo $cart->checkout; ?>"
								   class="uk-modal-close uk-button uk-button-primary">
									<?php echo Text::_('COM_RADICALMART_CHECKOUT'); ?></a>
							</div>
						</div>
					</div>
				<?php else: ?>
					<div class="uk-flex uk-flex-column uk-flex-middle uk-flex-center uk-overflow-auto"
						 style="flex-grow: 1">
						<div class="uk-padding-small uk-text-muted">
							<?php echo Text::_('COM_RADICALMART_CART_EMPTY'); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>