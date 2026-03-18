<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.9
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Personal\HtmlView $this */

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
$assets->useScript('com_radicalmart.site.settings')
		->useScript('keepalive');

if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

// Set uikit classes to form
require_once(JPATH_THEMES . '/system/radicalmart_uikit/helpers/uikit_form_classes.php');
setUikitFormClasses($this->form);
?>
<div id="RadicalMart" class="settings">
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
				<?php echo $this->params->get('seo_personal_h1',
						($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_PERSONAL')); ?>
			</h1>
			<?php foreach ($this->form->getFieldsets() as $key => $fieldset):
				if (empty($this->form->getFieldset($key)))
				{
					continue;
				}
				?>
				<form id="settings_<?php echo $key; ?>" radicalmart-settings="container" onsubmit="return;"
					  class="uk-form uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
					<div class="uk-card-header">
						<h2 class="uk-margin-remove uk-h4">
							<?php echo Text::_($fieldset->label); ?>
						</h2>
					</div>
					<div radicalmart-settings="error" class="uk-alert uk-alert-danger uk-margin-small-top"
						 style="display: none"></div>
					<div radicalmart-settings="success" class="uk-alert uk-alert-success uk-margin-small-top"
						 style="display: none"></div>
					<div class="uk-card-body uk-form uk-form-horizontal">
						<?php echo str_replace('readonly', 'disabled readonly',
								$this->form->renderFieldset($key, ['class' => 'uk-margin'])); ?>
					</div>
					<div class="uk-card-footer">
						<a onclick="RadicalMartSettingsUpdate_<?php echo $key; ?>(this)"
						   class="uk-button uk-button-primary">
							<?php echo Text::_('COM_RADICALMART_UPDATE'); ?>
						</a>
					</div>
				</form>
			<?php endforeach; ?>
		</div>
	</div>
</div>
