<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.2.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

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

$hidePrice = (ParamsHelper::getComponentParams()->get('hide_prices', 0) || !empty($product->price['hide']));
?>
<div class="product-block uk-transition-toggle uk-card-body uk-card-small">
	<div class="uk-child-width-expand@s uk-grid-divider" uk-grid="">
		<div>
			<div class="uk-child-width-expand@m" uk-grid="">
				<div class="uk-width-1-3@s uk-flex uk-flex-top">
					<div class="uk-position-relative">
						<a href="<?php echo $product->link; ?>"
						   class="uk-height-medium uk-width-1-1 uk-flex uk-flex-center uk-flex-middle uk-transition-scale-up uk-transition-opaque ">
							<?php echo MediaHelper::renderImage(
								'com_radicalmart.metas.variability.list',
								$product->image,
								[
									'alt'     => $product->title,
									'loading' => 'lazy',
									'class'   => 'uk-height-max-medium'
								],
								[
									'meta_id'  => $product->id,
									'no_image' => true,
									'thumb'    => true,
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
														'category_id' => $badge->id,
														'no_image'    => false,
														'thumb'       => true,
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
														'loading' => '$manufacturer',
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
							<strong>
								<?php echo Text::sprintf('COM_RADICALMART_PRICE_FROM', $product->price['min_string']); ?>
							</strong>
						<?php endif; ?>
					</div>
					<div class="uk-hidden@s">
						<div>
							<a href="<?php echo $product->link; ?>"
							   class="uk-button uk-button-primary">
								<?php echo Text::_('COM_RADICALMART_SHOW_VARIANTS'); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-width-1-4@s uk-visible@s">
			<?php if (!$hidePrice): ?>
				<div>
					<strong>
						<?php echo Text::sprintf('COM_RADICALMART_PRICE_FROM', $product->price['min_string']); ?>
					</strong>
				</div>
			<?php endif; ?>
			<div class="uk-margin">
				<a href="<?php echo $product->link; ?>"
				   class="uk-button uk-button-primary">
					<?php echo Text::_('COM_RADICALMART_SHOW_VARIANTS'); ?>
				</a>
			</div>
		</div>
	</div>
</div>