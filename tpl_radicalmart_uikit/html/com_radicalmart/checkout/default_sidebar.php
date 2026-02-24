<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\RadicalMart\Site\View\Checkout\HtmlView $this */

?>
<div class="uk-card uk-card-default uk-card-small">
	<div class="uk-card-header">
		<div class="uk-h4 uk-margin-remove">
			<?php echo Text::_('COM_RADICALMART_CHECKOUT_ITEMS'); ?>
		</div>
	</div>
	<div class="uk-card-body">
		<?php foreach ($this->item->products as $p => $product): ?>
			<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
				<div class="uk-margin-small-right">
					<div class="uk-text-small">
						<a href="<?php echo $product->link; ?>" class="uk-link-reset">
							<?php echo $product->title; ?>
						</a>
					</div>
					<div class="uk-text-meta uk-margin-small-right">
						<span radicalmart-checkout-display="products.<?php echo $p; ?>.order.quantity">
							<?php echo $product->order['quantity']; ?>
						</span>
						<span> x </span>
						<span radicalmart-checkout-display="products.<?php echo $p; ?>.order.final_string">
							<?php echo $product->order['final_string']; ?>
						</span>
					</div>
				</div>
				<div>
					<div class="uk-text-right"
						 radicalmart-checkout-display="products.<?php echo $p; ?>.order.sum_final_string">
						<?php echo $product->order['sum_final_string']; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if ($this->item->shipping || $this->item->payment): ?>
		<hr class="uk-margin-remove">
		<div class="uk-card-body">
			<?php if ($this->item->shipping):
				$shipping_title = (!empty($this->item->shipping->order->title)) ?
						$this->item->shipping->order->title : $this->item->shipping->title;
				$shipping_price = (!empty($this->item->shipping->order->price['final_string']))
						? $this->item->shipping->order->price['final_string'] : '';
				?>
				<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
					<div class="uk-margin-small-right uk-text-small">
						<?php echo Text::_('COM_RADICALMART_SHIPPING'); ?>
					</div>
					<div class="uk-text-right">
						<div class="uk-text-meta">
							<?php echo $shipping_title; ?>
						</div>
						<div radicalmart-checkout-display="shipping.order.price.final_string">
							<?php echo $shipping_price; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($this->item->payment):
				$payment_title = (!empty($this->item->payment->order->title)) ?
						$this->item->payment->order->title : $this->item->payment->title;
				?>
				<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
					<div class="uk-margin-small-right uk-text-small">
						<?php echo Text::_('COM_RADICALMART_PAYMENT'); ?>
					</div>
					<div class="uk-text-right uk-text-meta">
						<?php echo $payment_title; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<hr class="uk-margin-remove">
	<div class="uk-card-body">
		<div class="uk-margin-small uk-flex uk-flex-middle uk-flex-between">
			<div class="uk-text-muted uk-margin-small-right">
				<?php echo Text::_('COM_RADICALMART_SUBTOTAL'); ?>
			</div>
			<div radicalmart-checkout-display="total.base_string" class="uk-text-nowrap">
				<?php echo $this->item->total['base_string']; ?>
			</div>
		</div>
		<div class="uk-margin-small uk-flex uk-flex-middle uk-flex-between"
				<?php if (empty($this->item->total['discount'])) echo 'style="display:none"'; ?>>
			<div class="uk-text-muted uk-margin-small-right">
				<?php echo Text::_('COM_RADICALMART_PRICE_DISCOUNT'); ?>
			</div>
			<div>
				−<span radicalmart-checkout-display="total.discount_string">
					<?php echo $this->item->total['discount_string']; ?>
				</span>
			</div>
		</div>
		<?php if ($this->item->payment && !empty($this->item->payment->order->price['fee_string'])): ?>
			<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
				<div class="uk-text-muted uk-margin-small-right">
					<?php echo Text::_('COM_RADICALMART_PRICE_FEE'); ?>
				</div>
				<div>
					+<span radicalmart-checkout-display="payment.order.price.fee_string">
						<?php echo $this->item->payment->order->price['fee_string']; ?>
					</span>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<hr class="uk-margin-remove">
	<div class="uk-card-body">
		<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
			<div class="uk-text-muted">
				<?php echo Text::_('COM_RADICALMART_TOTAL'); ?>
			</div>
			<div class="uk-text-lead uk-text-bolder" radicalmart-checkout-display="total.final_string">
				<?php echo $this->item->total['final_string']; ?>
			</div>
		</div>
		<div radicalmart-checkout="check-error" class="uk-alert uk-alert-danger uk-text-center uk-margin-small-top"
			 style="display: none">
			<div><?php echo Text::_('COM_RADICALMART_ERROR_CHECKOUT_CHANGE'); ?></div>
			<div radicalmart-checkout="check-error-products" class="uk-margin-small-top uk-text-left uk-text-small"
				 style="display: none"></div>
			<div class="uk-margin-small-top">
				<button type="button" onclick="RadicalMartCheckout().reloadForm(this)"
						class="uk-button uk-button-small uk-button-secondary">
					<?php echo Text::_('COM_RADICALMART_REFRESH_PAGE'); ?>
				</button>
			</div>
		</div>
		<div class="uk-margin-small-top">
			<button type="button" radicalmart-checkout="submit-button" onclick="RadicalMartCheckout().createOrder()"
					class="uk-button uk-button-primary uk-margin-small uk-width-1-1" disabled>
				<?php echo Text::_('COM_RADICALMART_CHECKOUT'); ?></button>
		</div>
	</div>
</div>