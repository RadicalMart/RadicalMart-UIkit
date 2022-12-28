<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     1.0.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

// Load assets
/** @var Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
$assets->useScript('keepalive')
	->useScript('form.validate');

if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

foreach ($this->form->getFieldsets() as $key => $fieldset)
{
	foreach ($this->form->getFieldset($key) as $field)
	{
		$name  = $field->fieldname;
		$group = $field->group;
		$type  = strtolower($field->type);
		$class = $this->form->getFieldAttribute($name, 'class', '', $group);
		$input = $field->input;
		if ($type === 'text' || $type === 'email')
		{
			$class .= ' uk-input';
		}
		elseif ($type === 'list' || preg_match('#<select#', $input))
		{
			$class .= ' uk-select';
		}
		elseif ($type === 'textarea' || preg_match('#<textarea#', $input))
		{
			$class .= ' uk-textarea';
		}
		elseif ($type === 'range')
		{
			$class .= ' uk-range';
		}

		$this->form->setFieldAttribute($name, 'class', $class, $group);
	}
}
?>
<div id="RadicalMart" class="personal radicalmart-container">
	<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
		<div class="uk-width-1-4@m">
			<?php echo LayoutHelper::render('components.radicalmart.account.sidebar'); ?>
		</div>
		<div>
			<form action="<?php echo $this->link; ?>" name="checkoutForm" id="personalForm" method="post"
				  enctype="multipart/form-data" radicalmart-checkout="form"
				  class=" uk-card uk-card-default uk-card-small uk-form form-validate">
				<div class="uk-card-header">
					<h1 class="uk-h2">
						<?php echo $this->params->get('seo_personal_h1', Text::_('COM_RADICALMART_PERSONAL')); ?>
					</h1>
				</div>
				<div class="uk-card-body">
					<?php foreach ($this->form->getFieldsets() as $key => $fieldset):
						if ($key === 'hidden') continue; ?>
						<fieldset id="personal_<?php echo $key; ?>" class="uk-fieldset uk-margin-medium">
							<legend class="uk-h4"><?php echo Text::_($fieldset->label); ?></legend>
							<div class="uk-child-width-1-2@s" uk-grid>
								<?php echo $this->form->renderFieldset($key); ?>
							</div>
						</fieldset>
					<?php endforeach; ?>
				</div>
				<div class="uk-card-footer uk-text-center">
					<button class="uk-button uk-button-primary"><?php echo Text::_('JSAVE'); ?></button>
				</div>
				<div class="uk-hidden">
					<?php echo $this->form->renderFieldset('hidden'); ?>
				</div>
				<input type="hidden" name="option" value="com_radicalmart"/>
				<input type="hidden" name="task" value="personal.save"/>
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
