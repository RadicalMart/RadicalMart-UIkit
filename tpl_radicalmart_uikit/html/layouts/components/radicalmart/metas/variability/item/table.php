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
			<div>
				<strong>
					<?php echo Text::sprintf('COM_RADICALMART_PRICE_FROM', $product->price['min_string']); ?>
				</strong>
			</div>
		<?php endif; ?>
	</td>
	<?php if ($product->in_stock): ?>
		<td style="width: 1%" class="uk-text-nowrap uk-text-right">

			<a href="<?php echo $product->link; ?>" class="uk-button uk-button-primary">
				<?php echo Text::_('COM_RADICALMART_SHOW_VARIANTS'); ?>
			</a>
		</td>
	<?php endif; ?>
</tr>
