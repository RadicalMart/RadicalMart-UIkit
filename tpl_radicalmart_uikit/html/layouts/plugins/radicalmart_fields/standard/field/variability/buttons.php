<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     1.1.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2023 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

defined('_JEXEC') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string  $autocomplete   Autocomplete attribute for the field.
 * @var   boolean $autofocus      Is autofocus enabled?
 * @var   string  $class          Classes for the input.
 * @var   string  $description    Description of the field.
 * @var   boolean $disabled       Is this field disabled?
 * @var   string  $group          Group the field belongs to. <fields> section in form XML.
 * @var   boolean $hidden         Is this field hidden in the form?
 * @var   string  $hint           Placeholder for the field.
 * @var   string  $id             DOM id of the field.
 * @var   string  $label          Label of the field.
 * @var   string  $labelclass     Classes to apply to the label.
 * @var   boolean $multiple       Does this field support multiple values?
 * @var   string  $name           Name of the input field.
 * @var   string  $onchange       Onchange attribute for the field.
 * @var   string  $onclick        Onclick attribute for the field.
 * @var   string  $pattern        Pattern (Reg Ex) of value of the form field.
 * @var   boolean $readonly       Is this field read only?
 * @var   boolean $repeat         Allows extensions to duplicate elements.
 * @var   boolean $required       Is this field required?
 * @var   integer $size           Size attribute of the input.
 * @var   boolean $spellcheck     Spellcheck state for the form field.
 * @var   string  $validate       Validation rules to apply.
 * @var   string  $value          Value attribute of the field.
 * @var   array   $checkedOptions Options that will be set as checked.
 * @var   boolean $hasValue       Has this field a value assigned?
 * @var   array   $options        Options available for this field.
 *
 */
?>

<div class="uk-button-group">
	<?php foreach ($options as $o => $option):
		if ((int) $option->disable === 1) continue;
		$checked    = ($option->value === $value) ? ' selected' : '';
		$attributes = array(
			'id'    => $id . '_' . $o,
			'name'  => $name,
			'value' => htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8'),
			'class' => 'uk-hidden'
		);
		if (!empty($onchange)) $attributes['onchange'] = $onchange;
		if ($checked) $attributes['checked'] = '';
		?>
		<label for="<?php echo $id . '_' . $o; ?>"
			   class="uk-button uk-button-<?php echo ($checked) ? 'primary' : 'default'; ?>">
			<input type="radio" <?php echo ArrayHelper::toString($attributes); ?>>
			<?php echo Text::_($option->text); ?>
		</label>
	<?php endforeach; ?>
</div>