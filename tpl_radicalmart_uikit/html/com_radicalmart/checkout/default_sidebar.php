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

use Joomla\CMS\Language\Text;

?>
<div class="uk-card-body">
	<div class="uk-h4"><?php echo Text::_('COM_RADICALMART_CHECKOUT_ITEMS'); ?></div>
	<?php foreach ($this->item->products as $p => $product): ?>
		<div class="uk-grid-small" uk-grid>
			<div class="uk-width-expand uk-text-muted">
				<div class="uk-text-small"><?php echo $product->title; ?></div>
				<div class="uk-text-meta">
					<span radicalmart-checkout-display="products.<?php echo $p; ?>.order.quantity">
						<?php echo $product->order['quantity']; ?>
					</span>
					<span> x </span>
					<span radicalmart-checkout-display="products.<?php echo $p; ?>.order.final_string">
						<?php echo $product->order['final_string']; ?>
					</span>
				</div>
			</div>
			<div class="uk-text-right" radicalmart-checkout-display="products.<?php echo $p; ?>.order.sum_final_string">
				<?php echo $product->order['sum_final_string']; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<?php if ($this->item->shipping || $this->item->payment): ?>
	<hr class="uk-margin-remove">
	<div class="uk-card-body">
		<?php if ($this->item->shipping): ?>
			<div class="uk-grid-small uk-child-width-expand" uk-grid>
				<div class="uk-text-muted">
					<div class="uk-text-small">
						<?php echo Text::_('COM_RADICALMART_SHIPPING'); ?>
					</div>
				</div>
				<div class="uk-text-right">
					<div class="uk-text-meta">
						<?php echo (!empty($this->item->shipping->order->title)) ?
							$this->item->shipping->order->title : $this->item->shipping->title; ?>
					</div>
					<?php if (!empty($this->item->shipping->order->price['final_string'])): ?>
						<div radicalmart-checkout-display="shipping.order.price.final_string">
							<?php echo $this->item->shipping->order->price['final_string']; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($this->item->payment): ?>
			<div class="uk-grid-small uk-child-width-expand" uk-grid>
				<div class="uk-text-muted">
					<div class="uk-text-small">
						<?php echo Text::_('COM_RADICALMART_PAYMENT'); ?>
					</div>
				</div>
				<div class="uk-text-right">
					<div class="uk-text-meta">
						<?php echo (!empty($this->item->payment->order->title)) ?
							$this->item->payment->order->title : $this->item->payment->title; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
<hr class="uk-margin-remove">
<div class="uk-card-body">
	<div class="uk-grid-small uk-child-width-expand" uk-grid>
		<div class="uk-text-muted">
			<?php echo Text::_('COM_RADICALMART_SUBTOTAL'); ?>
		</div>
		<div radicalmart-checkout-display="total.base_string">
			<?php echo $this->item->total['base_string']; ?>
		</div>
	</div>
	<div class="uk-grid-small uk-child-width-expand" uk-grid>
		<div class="uk-text-muted">
			<?php echo Text::_('COM_RADICALMART_PRICE_DISCOUNT'); ?>
		</div>
		<div>
			−<span radicalmart-checkout-display="total.discount_string">
				<?php echo $this->item->total['discount_string']; ?>
			</span>
		</div>
	</div>
	<?php if ($this->item->payment && !empty($this->item->payment->order->price['fee_string'])): ?>
		<div class="uk-grid-small uk-child-width-expand" uk-grid>
			<div class="uk-width-expand uk-text-muted">
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
	<div class="uk-grid-small uk-flex-middle" uk-grid>
		<div class="uk-width-expand uk-text-muted">
			<?php echo Text::_('COM_RADICALMART_TOTAL'); ?>
		</div>
		<div class="uk-text-lead uk-text-bolder" radicalmart-checkout-display="total.final_string">
			<?php echo $this->item->total['final_string']; ?>
		</div>
	</div>
	<div class="uk-margin-small-top">
		<a id="submitButton" onclick="RadicalMartCheckout().createOrder()"
		   class="uk-button uk-button-primary uk-margin-small uk-width-1-1">
			<?php echo Text::_('COM_RADICALMART_CHECKOUT'); ?></a>
	</div>
</div>