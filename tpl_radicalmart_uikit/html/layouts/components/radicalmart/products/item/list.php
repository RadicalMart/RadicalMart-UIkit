<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.12
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
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

$params    = ParamsHelper::getComponentParams();
$hidePrice = ($params->get('hide_prices', 0) || !empty($product->price['hide']));
if (!$hidePrice && $product->in_stock)
{
	/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
	$assets = Factory::getApplication()->getDocument()->getWebAssetManager();
	$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart');
	$assets->useScript('com_radicalmart.site.cart');

	if ($params->get('trigger_js', 1))
	{
		$assets->useScript('com_radicalmart.site.trigger');
	}
}
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
				<a href="<?php echo $product->link; ?>"
				   class="uk-link-reset"><?php echo $product->title; ?></a>
			</div>
			<?php if (!empty($product->introtext)): ?>
				<div class="uk-text-small">
					<?php echo $product->introtext; ?>
				</div>
			<?php endif; ?>
			<?php if (!empty($product->fields)): ?>
				<?php foreach ($product->fields as $field):
					if (empty($field->value)) continue; ?>
					<div class="uk-form-horizontal uk-margin-remove uk-clearfix">
						<div class="uk-form-label"><?php echo $field->title; ?></div>
						<div class="uk-form-controls uk-form-controls-text">
							<?php echo $field->value; ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php echo LayoutHelper::render('components.radicalmart.items.manufacturers', $displayData); ?>
		</div>
		<div class="uk-width-1-5">
			<div>
				<?php if (!$product->in_stock): ?>
					<div class="uk-text-danger">
						<?php echo Text::_('COM_RADICALMART_NOT_IN_STOCK'); ?>
					</div>
				<?php elseif (!$hidePrice): ?>
					<?php if ($product->price['discount_enable']): ?>
						<div class="uk-text-small uk-text-muted">
							<s><?php echo $product->price['base_string']; ?></s>
						</div>
					<?php endif; ?>
					<div>
						<strong><?php echo $product->price['final_string']; ?></strong>
					</div>
				<?php endif; ?>
			</div>
			<div class="uk-margin">
				<?php if (!$hidePrice && $mode === 'shop' && (int) $product->state === 1 && $product->in_stock): ?>
					<div radicalmart-cart="product" data-id="<?php echo $product->id; ?>">
						<input radicalmart-cart="quantity" type="hidden" name="quantity"
							   class="uk-input uk-form-width-small uk-text-center"
							   step="<?php echo $product->quantity['step']; ?>"
							   min="<?php echo $product->quantity['min']; ?>"
								<?php if (!empty($product->quantity['max']))
								{
									echo 'max="' . $product->quantity['max'] . '"';
								}
								?>
							   value="<?php echo $product->quantity['min']; ?>"/>
						<button radicalmart-cart="add" type="button" class="uk-button uk-button-primary">
							<?php echo Text::_('COM_RADICALMART_CART_ADD'); ?>
						</button>
					</div>
				<?php elseif ($hidePrice || $mode === 'catalog'): ?>
					<a href="<?php echo $product->link; ?>"
					   class="uk-button uk-button-primary">
						<?php echo Text::_('COM_RADICALMART_READMORE'); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>