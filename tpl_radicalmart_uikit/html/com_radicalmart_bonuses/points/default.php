<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2025 RadicalMart. All rights reserved.
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
$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart');
if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}
?>
<div id="RadicalMartBonuses" class="bonuses-points">
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
						<?php echo $this->params->get('seo_bonuses_points_h1',
							($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_BONUSES_POINTS')); ?>
					</h1>
				</div>
				<?php if (empty($this->items)): ?>
					<div class="uk-card-body">
						<div class="uk-alert uk-alert-warning">
							<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_NO_ITEMS'); ?>
						</div>
					</div>
				<?php else: ?>
					<div class="uk-card-body">
						<table class="uk-table uk-table-divider uk-table-responsive uk-table-middle">
							<thead class="uk-visible@m">
							<tr>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS'); ?>
								</th>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_END'); ?>
								</th>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_REASON'); ?>
								</th>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_CREATED'); ?>
								</th>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_CREATED_BY'); ?>
								</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($this->items as $i => $item) : ?>
								<tr class="row<?php echo $i % 2; ?>">
									<td class="uk-text-nowrap">
										<div>
											<span class="uk-hidden@m">
												<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS'); ?>:
											</span>
											<strong class="uk-text-<?php echo ($item->points > 0) ? 'success' : 'danger'; ?>">
												<?php echo $item->points; ?>
											</strong>
										</div>
									</td>
									<td class="uk-text-nowrap">
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_END'); ?>:
										</span>
										<span class="uk-text-small">
											<?php echo (empty($item->end)) ? Text::_('JNEVER') :
												HTMLHelper::date($item->end, Text::_('DATE_FORMAT_LC5')); ?>
										</span>
									</td>
									<td>
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_REASON'); ?>:
										</span>
										<?php if (!empty($item->reason)): ?>
											<span class="uk-text-small">
												<?php echo $item->reason->text; ?>
											</span>
										<?php endif; ?>
									</td>
									<td>
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_CREATED'); ?>:
										</span>
										<span class="uk-text-small">
											<?php echo HTMLHelper::date($item->created, Text::_('DATE_FORMAT_LC5')); ?>
										</span>
									</td>
									<td class="uk-text-nowrap">
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_BONUSES_POINTS_CREATED_BY'); ?>:
										</span>
										<?php echo $item->created_by->name; ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php if ($this->pagination): ?>
						<div class="list-pagination uk-margin-medium">
							<?php echo $this->pagination->getPaginationLinks(); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
