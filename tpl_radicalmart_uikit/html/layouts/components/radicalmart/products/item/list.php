<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     1.0.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Administrator\Helper\ParamsHelper;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $product Product object.
 * @var  string $mode    RadicalMart mode.
 *
 */
$hidePrice = (ParamsHelper::getComponentParams()->get('hide_prices', 0) || !empty($product->price['hide'])
	|| empty($product->in_stock));

if (!$hidePrice)
{
	/** @var Joomla\CMS\WebAsset\WebAssetManager $assets */
	$assets = Factory::getApplication()->getDocument()->getWebAssetManager();
	$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart');
	$assets->useScript('com_radicalmart.site.cart');
}
?>
<div class="product-block uk-transition-toggle uk-card-body uk-card-small" <?php if (empty($product->in_stock)) echo 'style="opacity:0.5"'; ?>>
	<div class="uk-child-width-expand@s uk-grid-divider" uk-grid="">
		<div>
			<div class="uk-child-width-expand@m" uk-grid="">
				<div class="uk-width-1-3@s uk-flex uk-flex-top">
					<div class="uk-position-relative">
						<a href="<?php echo $product->link; ?>"
						   class="uk-height-medium uk-width-1-1 uk-flex uk-flex-center uk-flex-middle uk-transition-scale-up uk-transition-opaque ">
							<?php echo MediaHelper::renderImage(
								'com_radicalmart.products.list',
								$product->image,
								[
									'alt'     => $product->title,
									'loading' => 'lazy',
									'class'   => 'uk-height-max-medium'
								],
								[
									'product_id' => $product->id,
									'no_image'   => true,
									'thumb'      => true,
								]); ?>
						</a>
						<?php if (!empty($product->badges)): ?>
							<ul class="uk-thumbnav uk-position-top-right uk-margin-small-top">
								<?php foreach ($product->badges as $badge): ?>
									<li>
										<a href="<?php echo $badge->link; ?>" uk-tooltip
										   title="<?php echo Text::sprintf('COM_RADICALMART_PRODUCT_BADGE_LINK', $badge->title); ?>">
											<?php if ($src = $badge->media->get('icon'))
											{
												echo MediaHelper::renderImage(
													'com_radicalmart.categories.badge',
													$src,
													[
														'alt'     => $badge->title,
														'loading' => 'lazy',
													],
													[
														'product_id' => $badge->id,
														'no_image'   => false,
														'thumb'      => true,
													]);
											}
											else
											{
												echo '<span class="uk-label">' . $badge->title . '</span>';
											} ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
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
						<div class="uk-text-small uk-visible@s">
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
					<?php if (!empty($product->manufacturers)): ?>
						<div class="uk-margin">
							<ul class="uk-thumbnav">
								<?php foreach ($product->manufacturers as $manufacturer): ?>
									<li>
										<a href="<?php echo $manufacturer->link; ?>" uk-tooltip
										   title="<?php echo Text::sprintf('COM_RADICALMART_PRODUCT_MANUFACTURER_LINK', $manufacturer->title); ?>">
											<?php if ($src = $manufacturer->media->get('icon'))
											{
												echo MediaHelper::renderImage(
													'com_radicalmart.categories.manufacturer',
													$src,
													[
														'alt'     => $manufacturer->title,
														'loading' => 'lazy',
													],
													[
														'category_id' => $manufacturer->id,
														'no_image'    => false,
														'thumb'       => true,
													]);
											}
											else
											{
												echo $manufacturer->title;
											} ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
				<div class="uk-flex uk-flex-middle uk-flex-between uk-margin-small uk-hidden@s">
					<div>
						<?php if (!$hidePrice): ?>
							<?php if ($product->price['discount_enable']): ?>
								<div class="uk-text-small uk-text-muted">
									<s><?php echo $product->price['base_string']; ?></s>
								</div>
							<?php endif; ?>
							<div>
								<strong><?php echo $product->price['final_string']; ?></strong>
							</div>
						<?php elseif (empty($product->in_stock)): ?>
							<span class="uk-text-danger">
								<?php echo Text::_('COM_RADICALMART_NOT_IN_STOCK'); ?>
							</span>
						<?php endif; ?>
					</div>
					<div class="uk-hidden@s">
						<div>
							<?php if (!$hidePrice && $mode === 'shop'): ?>
								<div radicalmart-cart="product" data-id="<?php echo $product->id; ?>">
									<input radicalmart-cart="quantity" type="hidden" name="quantity"
										   class="uk-input uk-form-width-xsmall uk-text-center"
										   step="<?php echo $product->quantity['step']; ?>"
										   min="<?php echo $product->quantity['min']; ?>"
										<?php if (!empty($product->quantity['max']))
										{
											echo 'max="' . $product->quantity['max'] . '"';
										}
										?>
										   value="<?php echo $product->quantity['min']; ?>"/>
									<span radicalmart-cart="add"
										  class="uk-icon-button uk-link uk-background-primary uk-light" uk-icon="cart"
										  uk-tooltip=""
										  title="<?php echo Text::_('COM_RADICALMART_CART_ADD'); ?>"></span>
								</div>
							<?php elseif ($hidePrice || $mode === 'catalog'): ?>
								<a href="<?php echo $product->link; ?>"
								   class="uk-icon-button uk-background-primary uk-light" uk-icon="chevron-right"
								   uk-tooltip="" title="<?php echo Text::_('COM_RADICALMART_READMORE'); ?>"></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-width-1-4@s uk-visible@s">
			<div>
				<?php if (!$hidePrice): ?>
					<?php if ($product->price['discount_enable']): ?>
						<div class="uk-text-small uk-text-muted">
							<s><?php echo $product->price['base_string']; ?></s>
						</div>
					<?php endif; ?>
					<div>
						<strong><?php echo $product->price['final_string']; ?></strong>
					</div>
				<?php elseif (empty($product->in_stock)): ?>
					<span class="uk-text-danger">
						<?php echo Text::_('COM_RADICALMART_NOT_IN_STOCK'); ?>
					</span>
				<?php endif; ?>
			</div>
			<div class="uk-margin">
				<?php if (!$hidePrice && $mode === 'shop' && (int) $product->state === 1): ?>
					<div radicalmart-cart="product" data-id="<?php echo $product->id; ?>">
						<input radicalmart-cart="quantity" type="hidden" name="quantity"
							   class="uk-input uk-form-width-xsmall uk-text-center"
							   step="<?php echo $product->quantity['step']; ?>"
							   min="<?php echo $product->quantity['min']; ?>"
							<?php if (!empty($product->quantity['max']))
							{
								echo 'max="' . $product->quantity['max'] . '"';
							}
							?>
							   value="<?php echo $product->quantity['min']; ?>"/>
						<span radicalmart-cart="add" class="uk-button uk-button-primary">
							<?php echo Text::_('COM_RADICALMART_CART_ADD'); ?>
						</span>
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