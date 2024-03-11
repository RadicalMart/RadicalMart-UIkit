<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.0.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
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
		<div class="uk-width-1-4@m">
			<?php echo LayoutHelper::render('components.radicalmart.account.sidebar'); ?>
			<?php if (!empty($this->modules['radicalmart-account-sidebar'])): ?>
				<div class="mt-3">
					<?php foreach ($this->modules['radicalmart-account-sidebar'] as $module): ?>
						<div class="mb-3">
							<?php if ($module->showtitle): ?>
								<div class="h3"><?php echo Text::_($module->title); ?></div>
							<?php endif; ?>
							<div><?php echo $module->render; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<div>
			<div class="uk-card uk-card-default uk-card-small">
				<div class="uk-card-header">
					<h1 class="uk-h2">
						<?php echo $this->params->get('seo_orders_h1',
							($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_ORDERS')); ?>
					</h1>
				</div>
				<?php if (empty($this->items)): ?>
					<div class="uk-card-body">
						<div class="uk-alert uk-alert-warning">
							<?php echo Text::_('COM_RADICALMART_ERROR_ORDERS_NOT_FOUND'); ?>
						</div>
					</div>
				<?php else: ?>
					<?php foreach ($this->items as $i => $item):
						if ($i > 0) echo '<hr>' ?>
						<div class="uk-card-body">
							<h2 class="uk-h3">
								<a href="<?php echo $item->link; ?>">
									<span><?php echo $item->title; ?></span>
									<span class="uk-text-muted uk-text-small">
										<?php echo Text::sprintf('COM_RADICALMART_DATE_FROM',
											HTMLHelper::date($item->created, Text::_('DATE_FORMAT_LC2'))); ?>
									</span>
								</a>
							</h2>
							<table class="uk-table uk-table-small uk-table-justify uk-table-responsive uk-table-divider uk-margin-small-top uk-margin-remove-bottom">
								<tbody>
								<tr>
									<th class="uk-width-medium">
										<?php echo Text::_('COM_RADICALMART_PRODUCTS'); ?>
									</th>
									<td>
										<?php echo count($item->products); ?>
									</td>
								</tr>
								<?php if ($item->shipping): ?>
									<tr>
										<th class="uk-width-medium">
											<?php echo Text::_('COM_RADICALMART_SHIPPING'); ?>
										</th>
										<td><?php echo $item->shipping->get('title'); ?></td>
									</tr>
								<?php endif; ?>
								<?php if ($item->payment): ?>
									<tr>
										<th class="uk-width-medium">
											<?php echo Text::_('COM_RADICALMART_PAYMENT'); ?>
										</th>
										<td><?php echo $item->payment->get('title'); ?></td>
									</tr>
								<?php endif; ?>
								<tr>
									<th class="uk-width-medium">
										<?php echo Text::_('COM_RADICALMART_TOTAL'); ?>
									</th>
									<td>
										<?php echo $item->total['final_string']; ?>
									</td>
								</tr>
								<tr>
									<th class="uk-width-medium">
										<?php echo Text::_('COM_RADICALMART_ORDER_STATUS'); ?>
									</th>
									<td>
										<?php if ($item->status): ?>
											<span class="uk-label <?php echo $item->status->params->get('class_site'); ?>">
												<?php echo $item->status->title; ?>
											</span>
										<?php else: ?>
											<span class="uk-label uk-label-danger">
												<?php echo Text::_('COM_RADICALMART_ERROR_STATUS_NOT_FOUND'); ?>
											</span>
										<?php endif; ?>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
