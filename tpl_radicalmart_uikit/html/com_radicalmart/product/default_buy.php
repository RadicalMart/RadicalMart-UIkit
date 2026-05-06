<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.17
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\RadicalMart\Site\View\Product\HtmlView $this */

if ($this->params->get('hide_prices', 0) || !empty($this->product->price['hide']))
{
	return;
}
?>
<div class="uk-tile uk-tile-muted uk-padding-small uk-margin">
	<?php if (!empty($this->modules['radicalmart-product-before-price'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-product-before-price'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div radicalmart-cart="product" data-id="<?php echo $this->product->id; ?>"
		 class="uk-margin uk-child-width-auto uk-flex-middle" uk-grid>
		<?php if (!empty($this->product->in_stock)): ?>
			<div class="price uk-width-expand">
				<?php if ($this->product->price['discount_enable']): ?>
					<div class="uk-text-small uk-text-muted">
						<s><?php echo $this->product->price['base_string']; ?></s>
					</div>
				<?php endif; ?>
				<div class="uk-text-large">
					<strong>
						<?php echo $this->product->price['final_string']; ?>
					</strong>
				</div>
				<?php if ($this->product->price['discount_enable']): ?>
					<div class="uk-text-small">
						<?php
						echo Text::_('COM_RADICALMART_PRICE_DISCOUNT') . ' ' . $this->product->price['discount_string'];
						if ($this->product->price['discount_end'])
						{
							echo ' ' . Text::_('COM_RADICALMART_PRICE_DISCOUNT_END') . ' '
									. HTMLHelper::date($this->product->price['discount_end'], Text::_('DATE_FORMAT_LC6'));
						}
						?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ((int) $this->product->state === 1 && $this->mode === 'shop'): ?>
				<div class="uk-flex uk-flex-middle">
					<span class="uk-link uk-margin-small-right"
						  uk-icon="icon: minus"
						  radicalmart-cart="quantity_minus"></span>
					<input radicalmart-cart="quantity" type="text" name="quantity"
						   class="uk-input uk-form-width-small uk-text-center"
						   step="<?php echo $this->product->quantity['step']; ?>"
						   min="<?php echo $this->product->quantity['min']; ?>"
							<?php if (!empty($this->product->quantity['max']))
							{
								echo 'max="' . $this->product->quantity['max'] . '"';
							}
							?>
						   value="<?php echo $this->product->quantity['min']; ?>"/>
					<span class="uk-link uk-margin-small-left"
						  uk-icon="icon: plus"
						  radicalmart-cart="quantity_plus"></span>
				</div>
				<div>
					<button radicalmart-cart="add" type="button" class="uk-button uk-button-primary">
						<?php echo Text::_('COM_RADICALMART_CART_ADD'); ?>
					</button>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="uk-text-danger">
				<?php echo Text::_('COM_RADICALMART_NOT_IN_STOCK'); ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if (!empty($this->modules['radicalmart-product-after-price'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-product-after-price'] as $module): ?>
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
