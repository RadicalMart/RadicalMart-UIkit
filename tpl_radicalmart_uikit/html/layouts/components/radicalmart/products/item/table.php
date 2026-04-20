<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.16
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
<tr <?php if (!$product->in_stock) echo 'style="opacity:0.5"'; ?>>
	<td>
		<div class="uk-child-width-expand" uk-grid>
			<div class="uk-width-auto uk-flex uk-flex-top">
				<?php echo LayoutHelper::render('components.radicalmart.items.image', $displayData + [
								'width_px'  => 96,
								'height_px' => 96,
						]); ?>
			</div>
			<div class="middle uk-flex uk-flex-middle">
				<div>
					<?php if (!empty($product->badges)): ?>
						<div class="uk-margin-small-bottom">
							<?php foreach ($product->badges as $badge): ?>
								<a href="<?php echo $badge->link; ?>" class="uk-label">
									<?php echo $badge->title; ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<div class="uk-h5 uk-margin-remove">
						<a href="<?php echo $product->link; ?>"
						   class="uk-link-reset"><?php echo $product->title; ?></a>
					</div>
					<?php if (!empty($product->manufacturers)): ?>
						<div>
							<span class="uk-text-meta"><?php echo Text::_('COM_RADICALMART_MANUFACTURER') . ': '; ?></span>
							<?php foreach ($product->manufacturers as $badge): ?>
								<a href="<?php echo $badge->link; ?>" class="uk-link-muted">
									<?php echo $badge->title; ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</td>
	<td>
		<?php if ($product->category): ?>
			<a href="<?php echo $product->category->link; ?>" class="uk-text-nowrap uk-link-reset">
				<?php echo $product->category->title; ?>
			</a>
		<?php endif; ?>
	</td>
	<td style="width: 10%" class="uk-text-nowrap" <?php if (!$product->in_stock) echo 'colspan="2"'; ?>>
		<?php if (!$product->in_stock): ?>
			<div class="uk-text-danger uk-text-right">
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
	</td>
	<?php if ($product->in_stock): ?>
		<td style="width: 1%" class="uk-text-nowrap uk-text-right">
			<?php if (!$hidePrice && $mode === 'shop' && (int) $product->state === 1): ?>
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
			<?php else: ?>
				<a href="<?php echo $product->link; ?>" class="uk-button uk-button-primary">
					<?php echo Text::_('COM_RADICALMART_READMORE'); ?>
				</a>
			<?php endif; ?>
		</td>
	<?php endif; ?>
</tr>
