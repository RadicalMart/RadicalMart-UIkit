<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.1.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Administrator\Helper\ParamsHelper;

if (!is_array($displayData))
{
	$displayData = [];
}
extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  string $class Button class.
 *
 */

$app = Factory::getApplication();
if (!$app->getIdentity()->guest)
{
	return;
}

$app->getLanguage()->load('com_radicalmart', JPATH_ROOT);

/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $app->getDocument()->getWebAssetManager();
$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart');
$assets->useScript('com_radicalmart.site.login');

if (ParamsHelper::getComponentParams()->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}
?>
<button type="button" radicalmart-login="display_form"
		class="<?php echo (!empty($class)) ? $class : 'uk-button uk-button-secondary'; ?>">
	<?php echo Text::_('COM_RADICALMART_LOGIN_FORM_BUTTON'); ?>
</button>