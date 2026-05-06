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

use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\RadicalMart\Site\View\Cart\HtmlView $this */

?>
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
