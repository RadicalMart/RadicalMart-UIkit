<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.10
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\RadicalMart\Site\View\Order\HtmlView $this */

?>
<div class="uk-card uk-card-default uk-card-small">

	<div class="uk-card-body">
		<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
			<div class="uk-margin-small-right uk-text-small">
				<?php echo Text::_('COM_RADICALMART_ORDER_NUMBER'); ?>
			</div>
			<div class="uk-text-right uk-text-meta">
				<?php echo $this->order->number; ?>
			</div>
		</div>
		<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
			<div class="uk-margin-small-right uk-text-small">
				<?php echo Text::_('COM_RADICALMART_ORDER_DATE'); ?>
			</div>
			<div class="uk-text-right uk-text-meta">
				<?php echo HTMLHelper::date($this->order->created, Text::_('DATE_FORMAT_LC5')); ?>
			</div>
		</div>

		<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
			<div class="uk-margin-small-right uk-text-small">
				<?php echo Text::_('COM_RADICALMART_ORDER_STATUS'); ?>
			</div>
			<div class="uk-text-right">
				<?php if ($this->order->status): ?>
					<span class="uk-label <?php echo $this->order->status->params->get('class_site'); ?>">
						<?php echo $this->order->status->title; ?>
					</span>
				<?php else: ?>
					<span class="uk-label uk-label-danger">
						<?php echo Text::_('COM_RADICALMART_ERROR_STATUS_NOT_FOUND'); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php if ($this->order->shipping || $this->order->payment): ?>
		<hr class="uk-margin-remove">
		<div class="uk-card-body">
			<?php if ($this->order->shipping):
				$shipping_title = (!empty($this->order->shipping->order->title)) ?
						$this->order->shipping->order->title : $this->order->shipping->title;
				$shipping_price = (!empty($this->order->shipping->order->price['final_string']))
						? $this->order->shipping->order->price['final_string'] : '';
				?>
				<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
					<div class="uk-margin-small-right uk-text-small">
						<?php echo Text::_('COM_RADICALMART_SHIPPING'); ?>
					</div>
					<div class="uk-text-right">
						<div class="uk-text-meta">
							<?php echo $shipping_title; ?>
						</div>
						<?php if (!empty($shipping_price)): ?>
							<div>
								<?php echo $shipping_price; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($this->order->payment):
				$payment_title = (!empty($this->order->payment->order->title)) ?
						$this->order->payment->order->title : $this->order->payment->title;
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
			<div class="uk-text-nowrap">
				<?php echo $this->order->total['base_string']; ?>
			</div>
		</div>
		<?php if (!empty($this->order->total['discount'])): ?>
			<div class="uk-margin-small uk-flex uk-flex-middle uk-flex-between">
				<div class="uk-text-muted uk-margin-small-right">
					<?php echo Text::_('COM_RADICALMART_PRICE_DISCOUNT'); ?>
				</div>
				<div>
					−<span>
						<?php echo $this->order->total['discount_string']; ?>
					</span>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($this->order->payment && !empty($this->order->payment->order->price['fee_string'])): ?>
			<div class="uk-margin-small uk-flex uk-flex-top uk-flex-between">
				<div class="uk-text-muted uk-margin-small-right">
					<?php echo Text::_('COM_RADICALMART_PRICE_FEE'); ?>
				</div>
				<div>
					+<span>
						<?php echo $this->order->payment->order->price['fee_string']; ?>
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
			<div class="uk-text-lead uk-text-bolder">
				<?php echo $this->order->total['final_string']; ?>
			</div>
		</div>
		<?php if ($this->order->pay): ?>
			<div class="uk-margin-small-top">
				<a href="<?php echo $this->order->pay; ?>"
				   class="uk-button uk-button-primary uk-margin-small uk-width-1-1">
					<?php echo Text::_('COM_RADICALMART_PAY'); ?></a>
			</div>
		<?php endif; ?>
	</div>
</div>
