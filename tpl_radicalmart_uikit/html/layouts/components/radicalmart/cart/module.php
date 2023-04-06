<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2023 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

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
	<div id="radicalmartCartModule" uk-offcanvas="flip: true; overlay: true">
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
						<div class="uk-padding-small">
							<ul class="uk-list uk-list-divider">
								<?php foreach ($cart->products as $product): ?>
									<li radicalmart-cart="product" class="uk-text-small"
										data-id="<?php echo $product->id; ?>"
										data-cart-product="1">
										<div class="uk-grid-small uk-child-width-expand" uk-grid>
											<div class="uk-width-1-4">
												<a href="<?php echo $product->link; ?>"
												   class="uk-height-max-small uk-width-1-1 uk-flex uk-flex-center uk-flex-middle">
													<?php echo MediaHelper::renderImage(
														'com_radicalmart.products.cart.module',
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
											<div class="uk-position-relative">
												<span class="uk-link uk-text-danger uk-position-top-right"
													  radicalmart-cart="remove" uk-close=""></span>
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
												<div class="uk-flex uk-flex-wrap uk-flex-between">
													<div class="uk-text-muted uk-margin-right">
														<?php echo $product->order['quantity'] . ' x '
															. $product->order['final_string']; ?>
													</div>
													<div class="uk-text-bold">
														<?php echo $product->order['sum_final_string']; ?>
													</div>
												</div>
											</div>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
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