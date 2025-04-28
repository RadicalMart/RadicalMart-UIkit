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

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string                   $autocomplete   Autocomplete attribute for the field.
 * @var   bool                     $autofocus      Is autofocus enabled?
 * @var   string                   $class          Classes for the input.
 * @var   string                   $description    Description of the field.
 * @var   bool                     $disabled       Is this field disabled?
 * @var   string                   $group          Group the field belongs to. <fields> section in form XML.
 * @var   bool                     $hidden         Is this field hidden in the form?
 * @var   string                   $hint           Placeholder for the field.
 * @var   string                   $id             DOM id of the field.
 * @var   string                   $label          Label of the field.
 * @var   string                   $labelclass     Classes to apply to the label.
 * @var   bool                     $multiple       Does this field support multiple values?
 * @var   string                   $name           Name of the input field.
 * @var   string                   $onchange       Onchange attribute for the field.
 * @var   string                   $onclick        Onclick attribute for the field.
 * @var   string                   $pattern        Pattern (Reg Ex) of value of the form field.
 * @var   bool                     $readonly       Is this field read only?
 * @var   bool                     $repeat         Allows extensions to duplicate elements.
 * @var   bool                     $required       Is this field required?
 * @var   int                      $size           Size attribute of the input.
 * @var   bool                     $spellcheck     Spellcheck state for the form field.
 * @var   string                   $validate       Validation rules to apply.
 * @var   array                    $value          Value attribute of the field.
 * @var   array                    $checkedOptions Options that will be set as checked.
 * @var   bool                     $hasValue       Has this field a value assigned?
 * @var   array                    $options        Options available for this field.
 *
 * Field specific variables
 * @var  int                       $shipping       Shipping method id.
 * @var  \Joomla\Registry\Registry $shippingParams Available Operation Filter.
 * @var   array                    $addresses      Customer addresses array.
 */

$app       = Factory::getApplication();
$language  = $app->getLanguage();
$providers = $shippingParams->get('providers', []);

$fields = [
	'country'   => 'uk-width-1-1',
	'region'    => 'uk-width-1-3@s',
	'city'      => 'uk-width-2-3@s',
	'zip'       => 'uk-width-1-3@s',
	'street'    => 'uk-width-2-3@s',
	'house'     => 'uk-width-1-4@s',
	'building'  => 'uk-width-1-4@s',
	'entrance'  => 'uk-width-1-4@s',
	'floor'     => 'uk-width-1-4@s',
	'apartment' => 'uk-width-1-4@s',

	'uid'     => 'uk-hidden',
	'string'  => 'uk-hidden',
	'display' => 'uk-hidden',
];

if (empty($value))
{
	$value    = ['uid' => 'new'];
	$selected = false;
}
else
{
	$selected = $value['uid'];
}

if (empty($value['provider']) && !empty($providers))
{
	$value['provider'] = $providers[0];
}

// Load assets
/** @var \Joomla\CMS\Document\Document $document */
$document = $app->getDocument();

/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $document->getWebAssetManager();
$assets->getRegistry()
	->addExtensionRegistryFile('plg_radicalmart_shipping_apiship');

$assets->useScript('plg_radicalmart_shipping_apiship.fields.addresses');
$document->addScriptOptions($id, [
	'shipping'  => $shipping,
	'addresses' => $addresses,
	'selected'  => $selected
]);
?>

<div id="<?php echo $id; ?>" radicalmart-shipping-apiship-field-addresses="container" class="uk-position-relative">
	<ul uk-tab>
		<?php foreach ($addresses as $address) :

			if ($address['uid'] === 'new')
			{
				$tab = Text::_('PLG_RADICALMART_SHIPPING_APISHIP_POINTS_ADDRESSES_FIELD_NEW');
			}
			else
			{
				$tab = Text::_('PLG_RADICALMART_SHIPPING_APISHIP_PROVIDER_' . $address['provider']);
				if (!empty($address['street']) || !empty($address['house']))
				{
					$tab .= ' -';
					if (!empty($address['street']))
					{
						$tab .= ' ' . $address['street'];
					}
					if (!empty($address['house']))
					{
						$tab .= ' ' . $address['house'];
					}
				}
			}
			?>
			<li radicalmart-shipping-apiship-field-addresses="address"
				data-value="<?php echo $address['uid']; ?>">
				<a class="uk-display-block">
					<?php echo $tab; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<div radicalmart-shipping-apiship-field-addresses="error" class="uk-alert uk-alert-danger"
		 style="display: none">
	</div>
	<div radicalmart-shipping-apiship-field-addresses="loading"
		 class="uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-overlay-default uk-position-z-index"
		 style="display: none">
		<div uk-spinner="ratio: 3"></div>
	</div>
	<div radicalmart-shipping-apiship-field-addresses="form" class="uk-grid-small uk-margin" uk-grid="">
		<div class="uk-width-1-2@s">
			<?php
			$attributes = [
				'id'    => $id . '_provider',
				'name'  => $name . '[provider]',
				'class' => 'form-control uk-select',

				'radicalmart-shipping-apiship-field-addresses' => 'input_provider',
				'data-validate-key'                            => 'validate[provider]',
			];
			?>
			<div class="uk-form-horizontal">
				<div>
					<label for="<?php echo $attributes['id']; ?>" class="uk-form-label">
						<?php echo Text::_('PLG_RADICALMART_SHIPPING_APISHIP_FIELD_PROVIDER'); ?>
					</label>
					<div class="uk-form-controls">
						<select <?php echo ArrayHelper::toString($attributes); ?>>
							<?php foreach ($providers as $provider) :
								$selected = (!empty($value['provider']) && $value['provider'] === $provider)
									? ' selected="selected"' : '';
								?>
								<option value="<?php echo $provider; ?>" <?php echo $selected; ?>>
									<?php echo Text::_('PLG_RADICALMART_SHIPPING_APISHIP_PROVIDER_' . $provider); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<?php foreach ($fields as $key => $column):
			$display = $shippingParams->get('field_' . $key, 'hidden');
			if ($display === 'hidden')
			{
				$column = 'uk-hidden';
			}

			$hint = 'PLG_RADICALMART_SHIPPING_APISHIP_FIELD_' . $key . '_HINT';
			$hint = ($language->hasKey($hint)) ? Text::_($hint) : '';

			$label = 'PLG_RADICALMART_SHIPPING_APISHIP_FIELD_' . $key;
			$label = ($language->hasKey($label)) ? Text::_($label) : $key;

			$attributes = [
				'id'          => $id . '_' . $key,
				'name'        => $name . '[' . $key . ']',
				'type'        => ($display === 'hidden') ? 'hidden' : 'text',
				'class'       => 'form-control uk-input',
				'value'       => (!empty($value[$key])) ? $value[$key] : '',
				'placeholder' => $hint,

				'radicalmart-shipping-apiship-field-addresses' => 'input_' . $key,
				'data-validate-key'                            => 'validate[' . $key . ']',
			];

			if ($display === 'required')
			{
				$attributes['required'] = '';
				$attributes['class']    .= ' required';
			}

			if ($key === 'string')
			{
				if (!empty($onchange))
				{
					$attributes['onchange'] = $onchange;
				}
				if (!empty($required))
				{
					$attributes['required'] = $required;
				}
			}
			?>
			<div class="<?php echo $column; ?>">
				<label for="<?php echo $attributes['id']; ?>" style="display: none;">
					<?php echo Text::_($label); ?>
				</label>
				<input <?php echo ArrayHelper::toString($attributes); ?>>
			</div>
		<?php endforeach; ?>
	</div>
	<div>
		<button type="button" class="uk-button uk-button-primary"
				radicalmart-shipping-apiship-field-addresses="validate_button" style="display:none">
			<?php echo Text::_('PLG_RADICALMART_SHIPPING_APISHIP_POINTS_ADDRESSES_FIELD_VALIDATE'); ?>
		</button>
	</div>
</div>