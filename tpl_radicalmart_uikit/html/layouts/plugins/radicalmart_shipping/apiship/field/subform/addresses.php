<?php

/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2025 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   Form   $tmpl            The Empty form for template
 * @var   array  $forms           Array of JForm instances for render the rows
 * @var   bool   $multiple        The multiple state for the form field
 * @var   int    $min             Count of minimum repeating in multiple mode
 * @var   int    $max             Count of maximum repeating in multiple mode
 * @var   string $name            Name of the input field.
 * @var   string $fieldname       The field name
 * @var   string $fieldId         The field ID
 * @var   string $control         The forms control
 * @var   string $label           The field label
 * @var   string $description     The field description
 * @var   string $class           Classes for the container
 * @var   array  $buttons         Array of the buttons that will be rendered
 * @var   bool   $groupByFieldset Whether group the subform fields by it`s fieldset
 */

// Load assets
Factory::getApplication()
	->getDocument()
	->getWebAssetManager()
	->useScript('webcomponent.field-subform');

$class = (!empty($class)) ? ' ' . $class : '';
?>
<div class="subform-repeatable-wrapper subform-layout">
	<joomla-field-subform class="subform-repeatable<?php echo $class; ?>"
						  name="<?php echo $name; ?>"
						  button-add=".group-add"
						  button-remove=".group-remove"
						  repeatable-element=".subform-repeatable-group"
						  minimum="<?php echo $min; ?>"
						  maximum="<?php echo $max; ?>">
		<?php if (!empty($buttons['add'])) : ?>
			<button type="button" class="uk-button uk-button-primary group-add"
					aria-label="<?php echo Text::_('JGLOBAL_FIELD_ADD'); ?>">
				<span aria-hidden="true" uk-icon="plus"></span>
			</button>
		<?php endif; ?>
		<?php foreach ($forms as $k => $form)
		{
			echo $this->sublayout('section',
				['form' => $form, 'basegroup' => $fieldname, 'group' => $fieldname . $k, 'buttons' => $buttons]);
		} ?>
		<?php if ($multiple) : ?>
			<template class="subform-repeatable-template-section uk-hidden">
				<?php echo trim($this->sublayout('section',
					['form' => $tmpl, 'basegroup' => $fieldname, 'group' => $fieldname . 'X', 'buttons' => $buttons]));
				?>
			</template>
		<?php endif; ?>
	</joomla-field-subform>
</div>