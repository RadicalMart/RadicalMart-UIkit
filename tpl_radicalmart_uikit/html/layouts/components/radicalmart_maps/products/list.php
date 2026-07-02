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
 * @var  array $items List items array.
 *
 */

if (empty($items))
{
	return;
}
$mode = ParamsHelper::getComponentParams()->get('mode', 'shop');

$displayData['context'] = 'com_radicalmart_maps.products.list';
?>
<div>
	<ul class="uk-list uk-list-divider">
		<?php foreach ($items as $product) :
			$hidePrice = (ParamsHelper::getComponentParams()->get('hide_prices', 0) || !empty($product->price['hide'])
					|| empty($product->in_stock));
			?>
			<li>
				<div class="<?php if (empty($product->in_stock)) echo 'opacity-50'; ?>">
					<div class="uk-child-width-expand" uk-grid="">
						<div class="uk-width-1-4 uk-flex uk-flex-top">
							<div class="uk-position-relative uk-width-1-1">
								<?php echo LayoutHelper::render('components.radicalmart.items.image', [
										'product'   => $product,
										'height_px' => 100,
								]); ?>
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
						</div>
					</div>
					<div class="uk-flex uk-flex-middle uk-flex-between">
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
						<div>
							<a href="<?php echo $product->link; ?>"
							   class="uk-button uk-button-primary">
								<?php echo Text::_('COM_RADICALMART_READMORE'); ?>
							</a>
						</div>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>