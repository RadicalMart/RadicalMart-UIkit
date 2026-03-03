<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.5
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Orders\HtmlView $this */

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}
?>
<div id="RadicalMart" class="orders">
	<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
		<div class="uk-width-medium@m uk-flex-last uk-flex-first@m">
			<?php echo LayoutHelper::render('components.radicalmart.account.sidebar'); ?>
			<?php if (!empty($this->modules['radicalmart-account-sidebar'])): ?>
				<div class="uk-margin">
					<?php foreach ($this->modules['radicalmart-account-sidebar'] as $module): ?>
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
		<div>
			<h1 class="uk-h2 uk-margin uk-margin-remove-top">
				<?php echo $this->params->get('seo_orders_h1', ($this->menuCurrent)
						? $this->menu->title : Text::_('COM_RADICALMART_ORDERS')); ?>
			</h1>
			<?php if (empty($this->items)): ?>
				<div class="uk-card-body">
					<div class="uk-alert uk-alert-warning">
						<?php echo Text::_('COM_RADICALMART_ERROR_ORDERS_NOT_FOUND'); ?>
					</div>
				</div>
			<?php else: ?>
				<?php foreach ($this->items as $i => $item): ?>
					<div class="uk-cart uk-card-default uk-card-small uk-margin">
						<div class="uk-card-header uk-position-relative">
							<h2 class="uk-h4 uk-margin-remove">
								<a href="<?php echo $item->link; ?>">
									<span><?php echo $item->title; ?></span>
									<span class="uk-text-muted uk-text-small">
										<?php echo Text::sprintf('COM_RADICALMART_DATE_FROM',
												HTMLHelper::date($item->created, Text::_('DATE_FORMAT_LC4'))); ?>
									</span>
								</a>
							</h2>
							<?php if ($item->status): ?>
								<div class=" uk-card-badge uk-label <?php echo $item->status->params->get('class_site'); ?>">
									<?php echo $item->status->title; ?>
								</div>
							<?php else: ?>
								<div class=" uk-card-badge uk-label uk-label-danger">
									<?php echo Text::_('COM_RADICALMART_ERROR_STATUS_NOT_FOUND'); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="uk-card-body">
							<div uk-slider>
								<div class="uk-slider-items uk-child-width-auto">
									<?php foreach ($item->products as $product): ?>
										<div>
											<div class="uk-margin-small-right">
												<?php echo LayoutHelper::render(
														'components.radicalmart.items.image', [
														'product'   => $product,
														'width_px'  => 64,
														'height_px' => 64,
												]); ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="uk-text-meta">
								<?php echo Text::plural('COM_RADICALMART_PRODUCTS_N_ITEMS',
										count($item->products)); ?>
							</div>
							<div class="uk-child-width-1-3@s uk-child-width-1-2@m uk-child-width-1-3@l uk-grid-small uk-margin"
								 uk-grid>
								<?php if ($item->payment): ?>
									<div>
										<span class="uk-text-meta">
											<?php echo Text::_('COM_RADICALMART_PAYMENT') . ': '; ?>
										</span>
										<span>
											<?php echo $item->payment->get('title'); ?>
										</span>
									</div>
								<?php endif; ?>

								<?php if ($item->shipping): ?>
									<div>
										<span class="uk-text-meta">
											<?php echo Text::_('COM_RADICALMART_SHIPPING') . ': '; ?>
										</span>
										<span>
											<?php echo $item->shipping->get('title'); ?>
										</span>
									</div>
								<?php endif; ?>

								<div class="uk-width-expand uk-text-right@s uk-text-left@m uk-text-right@l">
									<span class="uk-text-meta">
										<?php echo Text::_('COM_RADICALMART_TOTAL') . ': '; ?>
									</span>
									<strong>
										<?php echo $item->total['final_string']; ?>
									</strong>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if ($this->items && $this->pagination): ?>
				<div class="list-pagination uk-margin-medium">
					<?php echo $this->pagination->getPaginationLinks(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
