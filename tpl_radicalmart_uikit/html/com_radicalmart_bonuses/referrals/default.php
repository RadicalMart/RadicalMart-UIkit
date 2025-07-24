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
use Joomla\Component\RadicalMart\Administrator\Helper\ParamsHelper;

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart');
$assets->useScript('com_radicalmart_bonuses.site.referral-code');
if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}
if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

$linkEnabled = ((int) ParamsHelper::getComponentParams()->get('bonuses_codes_cookies_enabled', 1) === 1);
?>
<div id="RadicalMartBonuses" class="bonuses-referrals">
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
			<h1 class="uk-h2 uk-hidden">
				<?php echo $this->params->get('seo_bonuses_referrals_h1',
					($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_BONUSES_REFERRALS')); ?>
			</h1>
			<div class="uk-card uk-card-default uk-card-small uk-margin-medium-bottom">
				<div class="uk-card-header">
					<h2><?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_INFO'); ?></h2>
				</div>
				<div class="uk-card-body">
					<div class="uk-grid-small" uk-grid>
						<div class="uk-width-1-3 uk-text-bold">
							<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_INFO_CHAIN'); ?>
						</div>
						<div class="uk-width-2-3">
							<?php echo Text::_(($this->info['in_chain']) ? 'JYES' : 'JNO'); ?>
						</div>
						<?php if ($this->info['parent']): ?>
							<div class="uk-width-1-3 uk-text-bold">
								<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_INFO_PARENT'); ?>
							</div>
							<div class="uk-width-2-3@m">
								<?php echo $this->info['parent']->name; ?>
							</div>
						<?php endif; ?>
						<?php if ($this->info['in_chain']): ?>
							<div class="uk-width-1-3 uk-text-bold">
								<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_INFO_REFERRALS_COUNT'); ?>
							</div>
							<div class="uk-width-2-3">
								<?php echo $this->info['referrals_count']; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="uk-card uk-card-default uk-card-small uk-margin-medium-bottom">
				<div class="uk-card-header">
					<h2><?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_CODES'); ?></h2>
				</div>
				<div class="uk-card-body">
					<?php if (empty($this->codes)): ?>
						<div class="uk-alert uk-alert-primary">
							<?php echo Text::_('COM_RADICALMART_BONUSES_CODES_NO_ITEMS'); ?>
						</div>
					<?php else: ?>
						<table class="uk-table uk-table-divider uk-table-responsive uk-table-middle">
							<thead class="uk-visible@m">
							<tr>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_CODE'); ?>
								</th>
								<?php if ($linkEnabled): ?>
									<th class="uk-text-nowrap">
										<?php echo Text::_('COM_RADICALMART_BONUSES_CODE_LINK'); ?>
									</th>
								<?php endif; ?>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_PRICE_DISCOUNT'); ?>
								</th>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_CUSTOMERS'); ?>
								</th>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_CODE_EXPIRES'); ?>
								</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($this->codes as $i => $item): ?>
								<tr class="<?php if (!$item->enabled) echo 'uk-alert-danger'; ?>">
									<td class="uk-text-nowrap">
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_BONUSES_CODE'); ?>:
										</span>
										<code><?php echo $item->code; ?></code>
									</td>
									<?php if ($linkEnabled): ?>
										<td class="uk-text-small uk-text-nowrap">
											<?php if ($item->enabled): ?>
												<span class="uk-hidden@m">
													<?php echo Text::_('COM_RADICALMART_BONUSES_CODE_LINK'); ?>:
												</span>
												<a href="<?php echo $item->link; ?>" target="_blank"
												   class="uk-visible@m">
													<?php echo $item->link; ?>
												</a>
												<button type="button"
														radicalmart_bonuses-referral_code-share="<?php echo $item->link; ?>"
														class="uk-button uk-button-default uk-hidden@m">
													<?php echo Text::_('COM_RADICALMART_BONUSES_CODE_SHARE'); ?>
												</button>
											<?php endif; ?>
										</td>
									<?php endif; ?>
									<td class="uk-text-small uk-text-nowrap">
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_PRICE_DISCOUNT'); ?>:
										</span>
										<?php echo $item->discount_string; ?>
									</td>
									<td class="uk-text-small uk-text-nowrap">
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_CUSTOMERS'); ?>:
										</span>
										<?php
										$customers_text = count($item->customers);
										if (($item->customers_limit > 0))
										{
											$customers_text .= ' / ' . $item->customers_limit;
										}
										echo $customers_text; ?>
									</td>
									<td class="uk-text-small uk-text-nowrap">
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_BONUSES_CODE_EXPIRES'); ?>:
										</span>
										<?php echo ($item->expires)
											? HTMLHelper::date($item->expires, Text::_('DATE_FORMAT_LC5'))
											: Text::_('COM_RADICALMART_BONUSES_CODE_EXPIRES_NEVER'); ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
					<?php if ($this->createCodeForm): ?>
						<div class="uk-margin-top">
							<div radicalmart_bonuses-referral_code="container" data-reload="0">
								<div radicalmart_bonuses-referral_code="error" class="uk-alert uk-alert-danger"
									 style="display: none"></div>
								<div radicalmart_bonuses-referral_code="success" class="uk-alert uk-alert-success"
									 style="display: none"></div>
								<div class="uk-position-relative">
									<div radicalmart_bonuses-referral_code="loading"
										 class="uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-overlay-default"
										 style="display: none">
										<div uk-spinner="ratio: 3"></div>
									</div>
									<div class="uk-margin-bottom" uk-grid="">
										<?php foreach ($this->createCodeForm->getFieldsets() as $fieldset)
										{
											foreach ($this->createCodeForm->getFieldset($fieldset->name) as $field)
											{
												$class = (strtolower($field->type) === 'hidden') ? 'uk-hidden' : 'col';
												echo '<div class="' . $class . '">'
													. $this->createCodeForm->getInput($field->fieldname, $field->group)
													. '</div>';
											}
										}
										?>
									</div>
									<button type="button" radicalmart_bonuses-referral_code="button"
											class="uk-button uk-button-primary">
										<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_CODES_CREATE_BUTTON'); ?>
									</button>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="uk-card uk-card-default uk-card-small">
				<div class="uk-card-header">
					<h2><?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_LOGS'); ?></h2>
				</div>
				<div class="uk-card-body">
					<?php if (empty($this->items)) : ?>
						<div class="uk-alert uk-alert-primary">
							<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_NO_ITEMS'); ?>
						</div>
					<?php else : ?>
						<table class="uk-table uk-table-divider uk-table-responsive uk-table-middle">
							<thead class="uk-visible@m">
							<tr>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_LOGS_REFERRAL'); ?>
								</th>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_LOGS_ACTION'); ?>
								</th>
								<th class="uk-text-nowrap">
									<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_LOGS_DATE'); ?>
								</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($this->items as $i => $item) : ?>
								<tr class="row<?php echo $i % 2; ?>">
									<td>
										<?php if ($item->referral): ?>
											<span class="uk-hidden@m">
												<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_LOGS_REFERRAL'); ?>:
											</span>
											<strong class="uk-text-nowrap">
												<?php echo $item->referral->name; ?>
											</strong>
										<?php endif; ?>
									</td>
									<td>
										<div><?php echo $item->action['title']; ?></div>
										<?php if (!empty($item->action['description'])) : ?>
											<div class="uk-text-small">
												<?php if (!empty($item->action['link'])) : ?>
													<a href="<?php echo $item->action['link']; ?>">
														<?php echo $item->action['description']; ?>
													</a>
												<?php else: ?>
													<?php echo $item->action['description']; ?>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</td>
									<td>
										<span class="uk-hidden@m">
											<?php echo Text::_('COM_RADICALMART_BONUSES_REFERRALS_LOGS_DATE'); ?>:
										</span>
										<span class="uk-text-nowrap">
											<?php echo HTMLHelper::date($item->date, Text::_('DATE_FORMAT_LC5')); ?>
										</span>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>