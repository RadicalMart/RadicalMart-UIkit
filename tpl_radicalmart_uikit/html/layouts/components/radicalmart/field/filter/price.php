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
use Joomla\Component\RadicalMart\Administrator\Helper\PriceHelper;
use Joomla\Registry\Registry;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string     $autocomplete   Autocomplete attribute for the field.
 * @var   bool       $autofocus      Is autofocus enabled?
 * @var   string     $class          Classes for the input.
 * @var   string     $description    Description of the field.
 * @var   bool       $disabled       Is this field disabled?
 * @var   string     $group          Group the field belongs to. <fields> section in form XML.
 * @var   bool       $hidden         Is this field hidden in the form?
 * @var   string     $hint           Placeholder for the field.
 * @var   string     $id             DOM id of the field.
 * @var   string     $label          Label of the field.
 * @var   string     $labelclass     Classes to apply to the label.
 * @var   bool       $multiple       Does this field support multiple values?
 * @var   string     $name           Name of the input field.
 * @var   string     $onchange       Onchange attribute for the field.
 * @var   string     $onclick        Onclick attribute for the field.
 * @var   string     $pattern        Pattern (Reg Ex) of value of the form field.
 * @var   bool       $readonly       Is this field read only?
 * @var   bool       $repeat         Allows extensions to duplicate elements.
 * @var   bool       $required       Is this field required?
 * @var   int        $size           Size attribute of the input.
 * @var   bool       $spellcheck     Spellcheck state for the form field.
 * @var   string     $validate       Validation rules to apply.
 * @var   array      $value          Value attribute of the field.
 * @var   array      $checkedOptions Options that will be set as checked.
 * @var   bool       $hasValue       Has this field a value assigned?
 * @var   array      $options        Options available for this field.
 *
 * Field specific variables
 * @var  array|false $currency       Currency data array.
 * @var  array       $hints          Fields hints.
 */

$vs = ['from', 'to'];
if (!is_array($value))
{
	$value = (new Registry($value))->toArray();
}

if (empty($hints))
{
	$hints = [];
}
foreach ($vs as $v)
{
	$val = (!empty($value[$v])) ? $value[$v] : 0;
	if ($val == 0)
	{
		$val = '';
	}
	if (!empty($val))
	{
		$val = PriceHelper::clean($val, $currency['code']);
	}
	$value[$v] = $val;

	if (empty($hints[$v]))
	{
		$hints[$v] = PriceHelper::toString(Text::_('COM_RADICALMART_PRICE_FILTER_' . $v . '_HINT'),
			$currency['code'], false);
	}
}

$decimal_separator   = (isset($currency['decimal_separator'])) ? $currency['decimal_separator'] : '.';
$thousands_separator = (isset($currency['thousands_separator'])) ? $currency['thousands_separator'] : ' ';
$pattern             = '[0-9.' . $decimal_separator . $thousands_separator . ']+?';
?>
<div class="radicalmart-input-filter-price">
	<?php foreach ($vs as $v): ?>
		<div class="uk-margin-small-bottom uk-flex uk-flex-middle">
			<label for="<?php echo $id . '_' . $v; ?>" class="uk-margin-small-right">
				<?php echo Text::_('COM_RADICALMART_PRICE_FILTER_' . $v); ?>
			</label>
			<input id="<?php echo $id . '_' . $v; ?>" name="<?php echo $name . '[' . $v . ']'; ?>"
				   class="uk-input uk-input-medium" type="text" pattern="<?php echo $pattern; ?>"
				   value="<?php echo $value[$v]; ?>"
				   placeholder="<?php echo $hints[$v]; ?>"
				<?php if (!empty($onchange)) echo 'onChange="' . $onchange . '"'; ?>>
		</div>
	<?php endforeach; ?>
	<div class="uk-text-right">
		<span class="uk-link uk-text-small uk-text-danger uk-text-lowercase"
			  onclick="this.closest('.radicalmart-input-filter-price').querySelectorAll('input')
			  .forEach(function (input) {input.value = ''; input.setAttribute('value', ''); input.dispatchEvent(new Event('change'));});">
			<?php echo Text::_('COM_RADICALMART_CLEAN'); ?>
		</span>
	</div>
</div>