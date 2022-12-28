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

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

/**
 * Template variables
 * -----------------
 *
 * @var  Form      $form   Filter form object.
 * @var  string    $action Form action href.
 * @var   object   $module Module object.
 * @var   Registry $params Module params.
 */

if (!$form)
{
	return;
}

$onSubmit = '';
if ($params->get('ajax', 0))
{
	// Load asses
	/** @var Joomla\CMS\WebAsset\WebAssetManager $assets */
	$assets = Factory::getApplication()->getDocument()->getWebAssetManager();
	$assets->useScript('mod_radicalmart_filter.ajax');

	$onSubmit = 'window.RadicalmartFilter.ajaxSubmit(event);';
}
?>
<form action="<?php echo $action; ?>" method="get" onsubmit="<?php echo $onSubmit; ?>"
	  radicalmart-ajax="mod_radicalmart_filter_<?php echo $module->id; ?>">
	<ul class="uk-list uk-list-divider" uk-accordion="collapsible: false; multiple: true">
		<?php $i = 0;
		foreach ($form->getFieldsets() as $key => $fieldset):
			foreach ($form->getFieldset($key) as $field):
				$i++;
				$name  = $field->fieldname;
				$group = $field->group;
				$open  = ($i < 6 || $form->getValue($name, $group)) ? 'uk-open' : '';
				$id    = 'mod_radicalmart_filter_' . $module->id . '_' . $field->id;
				$form->setFieldAttribute($name, 'id', $id, $group);
				?>
				<li class="<?php echo $open; ?>">
					<div class="uk-accordion-title uk-text-small uk-link">
						<?php echo Text::_($form->getFieldAttribute($name, 'label', $name, $group)); ?>
					</div>
					<div class="uk-accordion-content">
						<?php echo $form->getInput($name, $group); ?>
					</div>
				</li>
				<?php
				$form->setFieldAttribute($name, 'id', '', $group);
			endforeach;
		endforeach; ?>
	</ul>
	<button type="submit" class="uk-button uk-button-primary uk-width-1-1">
		<?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?>
	</button>
</form>