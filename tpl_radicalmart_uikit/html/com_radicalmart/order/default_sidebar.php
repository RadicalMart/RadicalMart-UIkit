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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

?>
<div class="uk-card-body">
	<div class="uk-grid-small" uk-grid>
		<div class="uk-width-expand uk-text-muted">
			<div class="uk-text-small">
				<?php echo Text::_('COM_RADICALMART_ORDER_NUMBER'); ?>
			</div>
		</div>
		<div class="uk-text-right">
			<div class="uk-text-meta"><?php echo $this->order->number; ?></div>
		</div>
	</div>
	<div class="uk-grid-small" uk-grid>
		<div class="uk-width-expand uk-text-muted">
			<div class="uk-text-small">
				<?php echo Text::_('COM_RADICALMART_ORDER_DATE'); ?>
			</div>
		</div>
		<div class="uk-text-right">
			<div class="uk-text-meta">
				<?php echo HTMLHelper::date($this->order->created, Text::_('DATE_FORMAT_LC2')); ?>
			</div>
		</div>
	</div>
	<div class="uk-grid-small" uk-grid>
		<div class="uk-width-expand uk-text-muted">
			<div class="uk-text-small">
				<?php echo Text::_('COM_RADICALMART_ORDER_STATUS'); ?>
			</div>
		</div>
		<div class="uk-text-right">
			<div class="uk-text-meta">
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
</div>
<?php if ($this->order->shipping || $this->order->payment): ?>
	<hr class="uk-margin-remove">
	<div class="uk-card-body">
		<?php if ($this->order->shipping): ?>
			<div class="uk-grid-small" uk-grid>
				<div class="uk-width-expand uk-text-muted">
					<div class="uk-text-small">
						<?php echo Text::_('COM_RADICALMART_SHIPPING'); ?>
					</div>
				</div>
				<div class="uk-text-right">
					<div class="uk-text-meta">
						<?php echo (!empty($this->order->shipping->order->title)) ?
							$this->order->shipping->order->title : $this->order->shipping->title; ?>
					</div>
					<?php if (!empty($this->order->shipping->order->price['final_string'])): ?>
						<div>
							<?php echo $this->order->shipping->order->price['final_string']; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($this->order->payment): ?>
			<div class="uk-grid-small" uk-grid>
				<div class="uk-width-expand uk-text-muted">
					<div class="uk-text-small">
						<?php echo Text::_('COM_RADICALMART_PAYMENT'); ?>
					</div>
				</div>
				<div class="uk-text-right">
					<div class="uk-text-meta">
						<?php echo (!empty($this->order->payment->order->title)) ?
							$this->order->payment->order->title : $this->order->payment->title; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
<hr class="uk-margin-remove">
<div class="uk-card-body">
	<div class="uk-grid-small" uk-grid>
		<div class="uk-width-expand uk-text-muted">
			<?php echo Text::_('COM_RADICALMART_SUBTOTAL'); ?>
		</div>
		<div><?php echo $this->order->total['base_string']; ?></div>
	</div>
	<?php if (!empty($this->order->total['discount'])): ?>
		<div class="uk-grid-small" uk-grid>
			<div class="uk-width-expand uk-text-muted">
				<?php echo Text::_('COM_RADICALMART_PRICE_DISCOUNT'); ?>
			</div>
			<div>
				−<span><?php echo $this->order->total['discount_string']; ?></span>
			</div>
		</div>
	<?php endif; ?>
	<?php if ($this->order->payment && !empty($this->order->payment->order->price['fee_string'])): ?>
		<div class="uk-grid-small" uk-grid>
			<div class="uk-width-expand uk-text-muted">
				<?php echo Text::_('COM_RADICALMART_PRICE_FEE'); ?>
			</div>
			<div>
				+<span><?php echo $this->order->payment->order->price['fee_string']; ?></span>
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
		<div class="uk-text-lead uk-text-bolder">
			<?php echo $this->order->total['final_string']; ?>
		</div>
	</div>
	<?php if ($this->order->pay): ?>
		<div class="uk-margin-small-top">
			<a href="<?php echo $this->order->pay; ?>" class="uk-button uk-button-primary uk-margin-small uk-width-1-1">
				<?php echo Text::_('COM_RADICALMART_PAY'); ?></a>
		</div>
	<?php endif; ?>
</div>
