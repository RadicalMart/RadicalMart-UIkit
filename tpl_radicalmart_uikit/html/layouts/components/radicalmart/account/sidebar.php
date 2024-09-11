<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.2.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Administrator\Helper\UserHelper;

$user   = Factory::getApplication()->getIdentity();
$avatar = UserHelper::getAvatar($user->id);
$menus  = UserHelper::getMenu();

/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = Factory::getApplication()->getDocument()->getWebAssetManager();
$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart');
$assets->useScript('com_radicalmart.site.settings');
?>
<div class="uk-card uk-card-default">
	<div class="uk-card-header uk-padding-small">
		<div class="uk-width-small uk-margin-auto uk-visible-toggle uk-position-relative uk-border-circle uk-overflow-hidden uk-light"
			 radicalmart-settings="avatar">
			<div class="uk-height-small uk-cover-container">
				<?php echo HTMLHelper::image(($avatar) ? $avatar : 'com_radicalmart/no-avatar.svg',
					htmlspecialchars($user->name), ['class' => 'uk-width-1-1', 'uk-cover' => ''], (!$avatar));
				HTMLHelper::image('com_radicalmart/no-avatar.svg', htmlspecialchars($user->name),
					['class' => 'uk-width-1-1', 'uk-cover' => ''], true); ?>
			</div>
			<label class="uk-link-reset uk-overlay-primary uk-position-cover uk-hidden-hover">
				<span class="uk-position-center" uk-icon="icon: camera; ratio: 1.25;"></span>
				<input type="file" accept="image/*" class="uk-hidden">
			</label>
		</div>
		<div class="uk-margin-top uk-text-center">
			<div class="uk-h4 uk-margin-remove" radicalmart-settings-display="name">
				<?php echo $user->name; ?>
			</div>
			<div class="uk-margin-small">
				<?php echo Text::_('COM_RADICALMART_JOINED') . ' '
					. HTMLHelper::date($user->registerDate, Text::_('DATE_FORMAT_LC4')); ?>
			</div>
			<div>
				<a href="<?php echo $menus['com_radicalmart.settings']['link']; ?>"
				   class="uk-button uk-button-default uk-button-small">
					<span class="" uk-icon="icon: cog; ratio: .75;"></span>
					<?php echo '  ' . Text::_($menus['com_radicalmart.settings']['text']); ?>
				</a>
				<a href="<?php echo $menus['com_users.logout']['link']; ?>"
				   class="uk-button uk-button-default uk-button-small"
				   title="<?php echo Text::_($menus['com_users.logout']['text']); ?>" uk-tooltip="">
					<span uk-icon="icon: sign-out; ratio: .75;"></span>
				</a>
			</div>
		</div>
	</div>
	<div class="uk-card-body">
		<ul class="uk-nav uk-nav-default">
			<?php foreach ($menus as $key => $item):
				if ($key === 'com_radicalmart.settings' || $key === 'com_users.logout')
				{
					continue;
				} ?>
				<li class="<?php if ($item['current']) echo 'uk-active'; ?>">
					<a href="<?php echo $item['link']; ?>"><?php echo Text::_($item['text']); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>