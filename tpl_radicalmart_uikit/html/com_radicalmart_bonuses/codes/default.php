<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.11
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\RadicalMart\Administrator\Helper\PriceHelper;

/** @var \Joomla\Component\RadicalMartBonuses\Site\View\Codes\HtmlView $this */

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart');
if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

$currenciesCount = count(PriceHelper::getCurrencies());
?>
<div id="RadicalMartBonuses" class="bonuses-codes">
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
				<?php echo $this->params->get('seo_bonuses_codes_h1',
						($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_BONUSES_CODES')); ?>
			</h1>
			<?php if (empty($this->items)): ?>
				<div class="uk-alert uk-alert-warning">
					<?php echo Text::_('COM_RADICALMART_BONUSES_CODES_NO_ITEMS'); ?>
				</div>
			<?php else: ?>
				<?php foreach ($this->items as $i => $item): ?>
					<div class="uk-card uk-card-small uk-card uk-card-default uk-card-body uk-margin
					<?php if (!$item->enabled) echo 'uk-alert-danger'; ?>">
						<div class="uk-flex uk-flex-middle uk-grid-small" uk-grid>
							<div class="uk-width-1-2 uk-width-expand@m">
								<div class="uk-text-meta">
									<?php echo Text::_('COM_RADICALMART_BONUSES_CODE'); ?>
								</div>
								<div>
									<code><?php echo $item->code; ?></code>
								</div>
							</div>
							<div class="uk-width-1-2 uk-width-small@m">
								<div class="uk-text-meta">
									<?php echo Text::_('COM_RADICALMART_PRICE_DISCOUNT'); ?>
								</div>
								<div><?php echo $item->discount_string; ?></div>
							</div>
							<div class="uk-width-1-2 uk-width-1-4@m">
								<?php if (!empty($item->expires) && $item->expires !== '0000-00-00 00:00:00'): ?>
									<div class="uk-text-meta">
										<?php echo Text::_('COM_RADICALMART_BONUSES_CODE_CREATED'); ?>
									</div>
									<div>
										<?php echo HTMLHelper::date($item->created, Text::_('DATE_FORMAT_LC5')); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="uk-width-1-2 uk-width-1-4@m">
								<?php if (!empty($item->expires) && $item->expires !== '0000-00-00 00:00:00'): ?>
									<div class="uk-text-meta">
										<?php echo Text::_('COM_RADICALMART_BONUSES_CODE_EXPIRES'); ?>
									</div>
									<div>
										<?php echo HTMLHelper::date($item->expires, Text::_('DATE_FORMAT_LC5')); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="uk-width-1-1 uk-flex uk-flex-middle">
								<div class="uk-text-meta uk-margin-small-right">
									<?php echo Text::_('COM_RADICALMART_ORDERS') . ': '; ?>
								</div>
								<div>
									<?php foreach ($item->orders as $order): ?>
										<a href="<?php echo $order->link ?>" class="uk-margin-small-right">
											<?php echo $order->number; ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<?php if ($this->pagination): ?>
					<div class="list-pagination uk-margin-medium">
						<?php echo $this->pagination->getPaginationLinks(); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>