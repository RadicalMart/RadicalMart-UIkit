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
use Joomla\Utilities\ArrayHelper;

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
 * @var  string|null $context        Field context.
 *
 */

// Load assets
/** @var \Joomla\CMS\Document\Document $document */
$document = Factory::getApplication()->getDocument();

/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $document->getWebAssetManager();
$assets->getRegistry()
	->addExtensionRegistryFile('plg_radicalmart_shipping_apiship');

$assets->useScript('plg_radicalmart_shipping_apiship.fields.tariffs');
$document->addScriptOptions($id, [
	'context' => $context
]);
?>
<div id="<?php echo $id; ?>" radicalmart-shipping-apiship-field-tariffs="container" class="uk-position-relative"
	 data-name="<?php echo $name; ?>">
	<div radicalmart-shipping-apiship-field-tariffs="error" class="uk-alert uk-alert-danger alert alert-error"
		 style="display: none">
	</div>
	<?php if (!empty($hint)): ?>
		<div radicalmart-shipping-apiship-field-tariffs="loading" class="uk-text-meta">
			<?php echo $hint; ?>
		</div>
	<?php endif; ?>
	<div radicalmart-shipping-apiship-field-tariffs="list"></div>
	<?php foreach (['id', 'name', 'cost', 'hash'] as $key)
	{
		$attributes = [
			'id'    => $id . '_' . $key,
			'name'  => $name . '[' . $key . ']',
			'type'  => 'hidden',
			'value' => (!empty($value[$key])) ? $value[$key] : '',

			'radicalmart-shipping-apiship-field-tariffs' => 'input_' . $key,
		];

		if ($key === 'id')
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

		echo '<input ' . ArrayHelper::toString($attributes) . '>';
	} ?>
</div>