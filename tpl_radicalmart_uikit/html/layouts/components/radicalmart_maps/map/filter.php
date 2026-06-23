<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  string   $provider     Map provider.
 * @var  string   $jsOptionsKey JavaScript options key.
 * @var  object   $category     Category object.
 * @var  Registry $params       RadicalMart Current params.
 * @var  Form     $filter       Filter form.
 *
 */

if (empty($filter) || empty($filter->getGroup('')))
{
	return;
}
?>
<form radicalmart_maps-map="filter" style="display: none;" class="uk-padding-small uk-padding-remove-vertical">
	<ul class="uk-list uk-list-divider" uk-accordion="collapsible: false; multiple: true">
		<?php $i = 0;
		foreach ($filter->getGroup('') as $key => $field):
			$i++;
			$name  = $field->__get('fieldname');
			$group = $field->__get('group');

			$open = ($i < 6 || $filter->getValue($name, $group)) ? 'show' : '';
			$id   = $jsOptionsKey . '_' . $field->__get('id');

			$filter->setFieldAttribute($name, 'id', $id, $group);
			$filter->setFieldAttribute($name, 'onchange', 'this.form.requestSubmit()', $group);
			$labelId   = $id . '_label';
			$contentId = $id . '_content';
			?>
			<li class="<?php echo $open; ?>">
				<div class="uk-accordion-title uk-text-small uk-link uk-margin-small">
					<?php echo Text::_($filter->getFieldAttribute($name, 'label', $name, $group)); ?>
				</div>
				<div class="uk-accordion-content">
					<?php echo $filter->getInput($name, $group); ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<button type="submit" class="uk-button uk-button-primary uk-width-1-1">
		<?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?>
	</button>
</form>
