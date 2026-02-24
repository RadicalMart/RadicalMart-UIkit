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

/** @var \Joomla\Component\RadicalMart\Site\View\Product\HtmlView $this */

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
if ($this->mode === 'shop')
{
	$assets->useScript('com_radicalmart.site.cart');
	if ($this->params->get('radicalmart_js', 1))
	{
		$assets->useScript('com_radicalmart.site');
	}
}
if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

?>
<div id="RadicalMart" class="product">
	<div class="uk-card uk-card-default uk-card-body uk-card-small">
		<div class="uk-grid-divider uk-grid-small uk-child-width-expand@m" uk-grid>
			<?php echo $this->loadTemplate('sidebar'); ?>
			<div>
				<?php echo $this->loadTemplate('info'); ?>
			</div>
		</div>
	</div>

	<?php if (!empty($this->modules['radicalmart-product-before-content'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-product-before-content'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php echo $this->product->event->beforeDisplayContent; ?>

	<?php echo $this->loadTemplate('description'); ?>

	<?php if (!empty($this->modules['radicalmart-product-after-content'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-product-after-content'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php echo $this->product->event->afterDisplayContent; ?>
</div>