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

use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string $autocomplete   Autocomplete attribute for the field.
 * @var   bool   $autofocus      Is autofocus enabled?
 * @var   string $class          Classes for the input.
 * @var   string $description    Description of the field.
 * @var   bool   $disabled       Is this field disabled?
 * @var   string $group          Group the field belongs to. <fields> section in form XML.
 * @var   bool   $hidden         Is this field hidden in the form?
 * @var   string $hint           Placeholder for the field.
 * @var   string $id             DOM id of the field.
 * @var   string $label          Label of the field.
 * @var   string $labelclass     Classes to apply to the label.
 * @var   bool   $multiple       Does this field support multiple values?
 * @var   string $name           Name of the input field.
 * @var   string $onchange       Onchange attribute for the field.
 * @var   string $onclick        Onclick attribute for the field.
 * @var   string $pattern        Pattern (Reg Ex) of value of the form field.
 * @var   bool   $readonly       Is this field read only?
 * @var   bool   $repeat         Allows extensions to duplicate elements.
 * @var   bool   $required       Is this field required?
 * @var   int    $size           Size attribute of the input.
 * @var   bool   $spellcheck     Spellcheck state for the form field.
 * @var   string $validate       Validation rules to apply.
 * @var   array  $value          Value attribute of the field.
 * @var   array  $checkedOptions Options that will be set as checked.
 * @var   bool   $hasValue       Has this field a value assigned?
 * @var   array  $options        Options available for this field.
 */
?>
<div id="<?php echo $id; ?>" class="radicalmart-filter_categories">
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
						<?php if (!empty($onchange)) echo 'onChange="' . $onchange . '"'; ?>> <?php echo $option->text; ?>
				</label>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="uk-text-right">
		<span class="uk-link uk-text-small uk-text-danger uk-text-lowercase"
			  onclick="this.closest('.radicalmart-filter_categories').querySelectorAll('input')
			  .forEach(function (input) {input.checked = false; input.dispatchEvent(new Event('change'));});">
			<?php echo Text::_('COM_RADICALMART_CLEAN'); ?>
		</span>
	</div>
</div>