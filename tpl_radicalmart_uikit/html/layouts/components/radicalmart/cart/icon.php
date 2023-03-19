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

use Joomla\CMS\Factory;
use Joomla\Component\RadicalMart\Administrator\Helper\ParamsHelper;

$app       = Factory::getApplication();
$hideTotal = (($app->input->get('option') === 'com_radicalmart')
	&& in_array($app->input->get('view'), ['checkout', 'cart']));

if (!$hideTotal)
{
	// Load assets
	/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
	$assets = Factory::getApplication()->getDocument()->getWebAssetManager();
	$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart');
	$assets->useScript('com_radicalmart.site.cart');

	$params = ParamsHelper::getComponentParams();
	if ($params->get('radicalmart_js', 1))
	{
		$assets->useScript('com_radicalmart.site');
	}

	if ($params->get('trigger_js', 1))
	{
		$assets->useScript('com_radicalmart.site.trigger');
	}
}
?>
<div class="radicalmart-container">
	<a radicalmart-cart="display_module" class="uk-link-reset radicalmart-icon" uk-tooltip>
		<span uk-icon="cart" class="uk-icon"></span>
		<?php if (!$hideTotal): ?>
			<span class="uk-badge quantity" radicalmart-cart-display="total.products" style="display:none">0</span>
		<?php endif; ?>
	</a>
</div>