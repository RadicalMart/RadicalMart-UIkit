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

use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string  $id             DOM id of the field.
 * @var   string  $label          Label of the field.
 * @var   string  $name           Name of the input field.
 * @var   string  $value          Value attribute of the field.
 * @var   array   $checkedOptions Options that will be set as checked.
 * @var   boolean $hasValue       Has this field a value assigned?
 * @var   array   $options        Options available for this field.
 * @var   string  $onchange       Onchange attribute for the field.
 */
?>
<div id="<?php echo $id; ?>" class="radicalmart-fields-standard-filter_checkboxes">
	<ul class="uk-list uk-list-collapse uk-margin-remove">
		<?php foreach ($options as $i => $option) : ?>
			<?php
			$checked = in_array((string) $option->value, $checkedOptions, true) ? 'checked' : '';
			$checked = (!$hasValue && $option->checked) ? 'checked' : $checked;

			$oid   = $id . $i;
			$value = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8');
			?>
			<li>
				<label for="<?php echo $oid; ?>">
					<input id="<?php echo $oid; ?>" name="<?php echo $name ?>" type="checkbox"
						   class="uk-checkbox" <?php echo $checked; ?>
						   value="<?php echo $value; ?>"
						<?php if (!empty($onchange)) echo 'onChange="' . $onchange . '"'; ?>> <?php echo $option->text; ?></label>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="uk-text-right">
		<span class="uk-link uk-text-small uk-text-danger uk-text-lowercase"
			  onclick="this.closest('.radicalmart-fields-standard-filter_checkboxes').querySelectorAll('input')
			  .forEach(function (input) {input.checked = false; input.dispatchEvent(new Event('change'));});">
			<?php echo Text::_('PLG_RADICALMART_FIELDS_STANDARD_CLEAN'); ?>
		</span>
	</div>
</div>