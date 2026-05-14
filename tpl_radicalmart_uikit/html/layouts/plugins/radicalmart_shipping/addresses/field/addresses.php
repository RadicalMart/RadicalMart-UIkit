<?php
/*
 * @package     RadicalMart Shipping Addresses Plugin
 * @subpackage  plg_radicalmart_shipping_addresses
 * @version     3.0.18
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
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
 *
 * Field specific variables
 * @var  array   $addresses      Addresses array.
 */

Factory::getApplication()->getDocument()->addScriptOptions($name, ['addresses' => $addresses]);
?>
<div class="uk-grid-small uk-child-width-1-3@s" uk-grid <?php if (empty($addresses)) echo 'style="display: none"'; ?>
     radicalmart-shipping-addresses="addresses" data-name="<?php echo $name; ?>">
	<?php foreach ($addresses as $a => $address):
		$checked = ($value === $address['shipping_address_uid']) ? 'checked' : ''; ?>
		<div radicalmart-shipping-addresses="address" data-uid="<?php echo $address['shipping_address_uid']; ?>">
			<label for="<?php echo $id . '_' . $a; ?>"
			       class="uk-tile uk-padding-small uk-display-block uk-tile-muted">
				<input id="<?php echo $id . '_' . $a; ?>" class="uk-hidden" type="radio"
				       name="<?php echo $name; ?>"
				       value="<?php echo $address['shipping_address_uid']; ?>" <?php if (!empty($onchange)) echo ' onchange="' . $onchange . '"'; ?>
						<?php echo $checked; ?>>
				<div>
					<div class="uk-margin-small-bottom">
						<?php echo $address['string']; ?>
					</div>
					<div class="uk-text-right">
						<button type="button" class="uk-button uk-button-danger uk-button-small" style="display: none"
						        radicalmart-shipping-addresses="change">
							<?php echo Text::_('PLG_RADICALMART_SHIPPING_ADDRESSES_FIELD_CHANGE'); ?>
						</button>
					</div>
				</div>
			</label>
		</div>
	<?php endforeach; ?>
	<div radicalmart-shipping-addresses="address" data-uid="new">
		<?php $checked = ($value === 'new') ? 'checked' : ''; ?>
		<label for="<?php echo $id . '_new'; ?>"
		       class="uk-tile uk-padding-small uk-display-block uk-tile-muted">
			<input id="<?php echo $id . '_new'; ?>" class="uk-hidden" type="radio"
			       name="<?php echo $name; ?>"
			       value="new" <?php if (!empty($onchange)) echo ' onchange="' . $onchange . '"'; ?>
					<?php echo $checked; ?>>
			<div class="uk-margin-small-bottom">
				<?php echo Text::_('PLG_RADICALMART_SHIPPING_ADDRESSES_FIELD_ADD'); ?>
			</div>
		</label>
	</div>
</div>
<script>
	let container = document.querySelector('[radicalmart-shipping-addresses="addresses"][data-name="<?php echo $name; ?>"]'),
		inputs = container.querySelectorAll('input');

	function setActive() {
		inputs.forEach(input => {
			input.closest('label').classList.toggle('uk-tile-secondary', input.checked);
			input.closest('label').classList.toggle('uk-tile-muted', !input.checked);
		})
	}

	setActive();

	inputs.forEach((input) => {
		input.addEventListener('change', setActive)
	})

</script>