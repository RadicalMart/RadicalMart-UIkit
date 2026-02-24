<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
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
<div class="product-block uk-card-body uk-card-small uk-card-default uk-margin"
		<?php if (!$product->in_stock) echo 'style="opacity:0.5"'; ?>>
	<div class="uk-child-width-expand" uk-grid="">
		<div class="uk-width-1-3 uk-flex uk-flex-top">
			<div class="uk-position-relative uk-width-1-1">
				<?php echo LayoutHelper::render('components.radicalmart.items.image', $displayData);
				echo LayoutHelper::render('components.radicalmart.items.badges', $displayData); ?>
			</div>
		</div>
		<div class="middle uk-margin-small">
			<?php if ($product->category): ?>
				<div>
					<a href="<?php echo $product->category->link; ?>"
					   class="uk-text-nowrap uk-text-small uk-link-muted">
						<?php echo $product->category->title; ?>
					</a>
				</div>
			<?php endif; ?>
			<div>
				<a href="<?php echo $product->link; ?>" class="uk-link-reset uk-h4">
					<?php echo $product->title; ?>
				</a>
			</div>
			<?php if (!empty($product->introtext)): ?>
				<div class="uk-text-small">
					<?php echo $product->introtext; ?>
				</div>
			<?php endif; ?>
			<?php echo LayoutHelper::render('components.radicalmart.items.manufacturers', $displayData); ?>
		</div>
		<div class="uk-width-1-5">
			<?php if (!$product->in_stock): ?>
				<div class="uk-text-danger">
					<?php echo Text::_('COM_RADICALMART_NOT_IN_STOCK'); ?>
				</div>
			<?php elseif (!$hidePrice): ?>
				<div>
					<strong>
						<?php echo Text::sprintf('COM_RADICALMART_PRICE_FROM', $product->price['min_string']); ?>
					</strong>
				</div>
			<?php endif; ?>
			<?php if ($product->in_stock): ?>
				<div class="uk-margin">
					<a href="<?php echo $product->link; ?>" class="uk-button uk-button-primary">
						<?php echo Text::_('COM_RADICALMART_SHOW_VARIANTS'); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>