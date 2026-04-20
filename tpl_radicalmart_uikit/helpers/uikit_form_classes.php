<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.16
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormFactoryInterface;

function setUikitFormClasses(Form $form): void
{
	/** @var Joomla\CMS\Form\FormFactory $formFactory */
	$formFactory = Factory::getContainer()->get(FormFactoryInterface::class);
	foreach ($form->getGroup('') as $field)
	{
		$name     = $field->__get('fieldname');
		$group    = $field->__get('group');
		$setClass = null;
		if ($field instanceof Joomla\CMS\Form\Field\TextareaField)
		{
			$setClass .= ' uk-textarea';
		}
		elseif ($field instanceof Joomla\CMS\Form\Field\CheckboxesField)
		{
			continue;
		}
		elseif ($field instanceof Joomla\CMS\Form\Field\CheckboxField)
		{
			$setClass .= ' uk-checkbox';
		}
		elseif ($field instanceof Joomla\CMS\Form\Field\RadioField)
		{
			continue;
		}
		elseif ($field instanceof Joomla\CMS\Form\Field\RangeField)
		{
			$setClass .= ' uk-range';
		}
		elseif ($field instanceof Joomla\CMS\Form\Field\ListField)
		{
			$setClass .= ' uk-select';
		}
		elseif ($field instanceof Joomla\CMS\Form\Field\TextField)
		{
			$setClass .= ' uk-input';
		}
		elseif ($field instanceof Joomla\CMS\Form\Field\SubformField)
		{
			$source  = $field->__get('formsource');
			$subform = $formFactory->createForm($form->getName() . '.subform.' . '.' . $group . '.' . $name);
			$subform->load($source);

			setUikitFormClasses($subform);

			$form->setFieldAttribute($name, 'formsource', $subform->getXml()->asXML(), $group);
		}
		
		$class = $field->getAttribute('class', '');
		if ($setClass && !str_contains($class, $setClass))
		{
			$class .= ' ' . $setClass;
			$form->setFieldAttribute($name, 'class', $class, $group);
		}
	}
}