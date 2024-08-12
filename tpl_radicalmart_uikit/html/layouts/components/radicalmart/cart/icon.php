<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.2.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\Component\RadicalMart\Administrator\Helper\ParamsHelper;
use Joomla\Component\RadicalMart\Site\Helper\RouteHelper;

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
<div>
	<?php if ($hideTotal): ?>
		<a href="<?php echo Route::_(RouteHelper::getCartRoute(), false); ?>"
		   class="uk-link-reset uk-button uk-button-link radicalmart-icon">
			<span uk-icon="cart" class="uk-icon"></span>
		</a>
	<?php else: ?>
		<button radicalmart-cart="display_module" class="uk-link-reset uk-button uk-button-link radicalmart-icon"
				uk-tooltip>
			<span uk-icon="cart" class="uk-icon"></span>
			<span class="uk-badge quantity" radicalmart-cart-display="total.products" style="display:none">0</span>
		</button>
	<?php endif; ?>
</div>