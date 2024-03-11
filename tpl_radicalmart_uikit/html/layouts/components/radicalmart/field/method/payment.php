<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

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
 *
 * Field specific variables
 * @var  array   $methods        Methods array.
 */

if (empty($methods))
{
	return false;
}
?>
<div class="uk-grid-small uk-child-width-1-3@s" uk-grid>
	<?php foreach ($methods as $m => $method):
		$checked = ((int) $value === (int) $method['id']) ? 'checked' : ''; ?>
		<div>
			<label for="<?php echo $id . '_' . $m; ?>"
				   class="uk-tile uk-padding-small uk-text-center uk-display-block uk-tile-<?php echo ($checked) ? 'secondary' : 'muted'; ?>">
				<?php if (!empty($method['media']['icon'])): ?>
					<div class="uk-text-center">
						<?php echo HTMLHelper::image($method['media']['icon'], htmlspecialchars($method['title'])); ?>
					</div>
				<?php endif; ?>
				<div>
					<input id="<?php echo $id . '_' . $m; ?>" class="uk-radio uk-hidden" type="radio"
						   name="<?php echo $name; ?>"
						   value="<?php echo $method['id']; ?>" <?php if (!empty($onchange)) echo ' onchange="' . $onchange . '"'; ?>
						<?php echo $checked; ?>>
				</div>
				<div class="uk-margin-remove">
					<?php echo $method['title']; ?>
				</div>
				<?php if (!empty($method['description'])): ?>
					<div class="uk-text-small uk-text-muted">
						<?php echo $method['description']; ?>
					</div>
				<?php endif; ?>
			</label>
		</div>
	<?php endforeach; ?>
</div>
