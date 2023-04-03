<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

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

if ($this->paid)
{
	echo $this->loadTemplate('paid');

	return;
}
?>
<div id="RadicalMart" class="done radicalmart-container uk-text-center">
	<div class="uk-text-center uk-container uk-container-small">
		<div uk-icon="icon:check; ratio:5" class="uk-text-success"></div>
		<h1 class="uk-h2 uk-margin-small-top">
			<?php echo $this->params->get('seo_done_h1', Text::_('COM_RADICALMART_DONE_PAGE_H1')); ?>
		</h1>
		<div>
			<a href="<?php echo Uri::root(); ?>" class="uk-button uk-button-default">
				<?php echo Text::_('COM_RADICALMART_DONE_PAGE_TO_HOME'); ?>
			</a>
			<a href="<?php echo $this->order->link; ?>" class="uk-button uk-button-default">
				<?php echo Text::_('COM_RADICALMART_DONE_PAGE_TO_ODER'); ?>
			</a>
			<?php if ($this->order->pay): ?>
				<a href="<?php echo $this->order->pay; ?>" class="uk-button uk-button-primary">
					<?php echo Text::_('COM_RADICALMART_DONE_PAGE_TO_PAY'); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
