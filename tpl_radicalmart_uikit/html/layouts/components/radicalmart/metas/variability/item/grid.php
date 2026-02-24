<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.4
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\RadicalMart\Administrator\Helper\ParamsHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $product Product object.
 * @var  string $mode    RadicalMart mode.
 *
 */

$hidePrice = (ParamsHelper::getComponentParams()->get('hide_prices', 0) || !empty($product->price['hide']));
?>
<div class="product-block uk-cart uk-card-default uk-card-small"
		<?php if (!$product->in_stock) echo 'style="opacity:0.5"'; ?>>
	<div class="uk-position-relative">
		<?php echo LayoutHelper::render('components.radicalmart.items.image', $displayData);
		echo LayoutHelper::render('components.radicalmart.items.badges', $displayData); ?>
	</div>
	<div class="uk-card-body middle">
		<?php if ($product->category): ?>
			<div>
				<a href="<?php echo $product->category->link; ?>"
				   class="uk-text-nowrap uk-text-small uk-link-muted">
					<?php echo $product->category->title; ?>
				</a>
			</div>
		<?php endif; ?>
		<div>
			<a href="<?php echo $product->link; ?>" class="uk-link-reset"><?php echo $product->title; ?></a>
		</div>
	</div>
	<div class="uk-card-footer uk-flex uk-flex-bottom uk-flex-between">
		<div>
			<?php if (!$product->in_stock): ?>
				<div>
					<span class="uk-text-danger">
						<?php echo Text::_('COM_RADICALMART_NOT_IN_STOCK'); ?>
					</span>
				</div>
			<?php elseif (!$hidePrice): ?>
				<div>
					<strong>
						<?php echo Text::sprintf('COM_RADICALMART_PRICE_FROM', $product->price['min_string']); ?>
					</strong>
				</div>
			<?php endif; ?>
		</div>
		<div>
			<a href="<?php echo $product->link; ?>" class="uk-button uk-button-primary">
				<?php echo Text::_('COM_RADICALMART_SHOW_VARIANTS'); ?>
			</a>
		</div>
	</div>
</div>
