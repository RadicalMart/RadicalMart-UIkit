<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.2.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

\defined('_JEXEC') or die;

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
 */

$attributes = [
	'id'                => $id,
	'name'              => $name,
	'value'             => $value,
	'type'              => 'text',
	'spellcheck'        => 'false',
	'class'             => (!empty($class)) ? $class . ' uk-input' : 'uk-input',
	'radicalmart-login' => 'code_input',
];

if (!empty($onchange))
{
	$attributes['onchange'] = $onchange;
}

if (!empty($required))
{
	$attributes['required'] = '';
}

if (!empty($hint))
{
	$attributes['placeholder'] = $hint;
}

if (!empty($readonly))
{
	$attributes['readonly'] = '';
}
else
{
	// Load assets
	/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
	$assets         = Factory::getApplication()->getDocument()->getWebAssetManager();
	$assetsRegistry = $assets->getRegistry();

	$assetsRegistry->addExtensionRegistryFile('com_radicalmart');
	$assets->useScript('com_radicalmart.site.login');
}
?>
<div>
	<div radicalmart-login="code_success" class="uk-alert uk-alert-success" style="display: none">
		<?php echo Text::_('COM_RADICALMART_LOGIN_CODE_SUCCESS'); ?>
	</div>
	<div radicalmart-login="code_error" class="uk-alert uk-alert-danger" style="display: none">
	</div>
	<div radicalmart-login="code_start" style="display: none">
		<button type="button" class="uk-button uk-button-small uk-button-default" radicalmart-login="code_button"
		        onclick="window.RadicalMartLogin().codeSend(this)">
			<?php echo Text::_('COM_RADICALMART_LOGIN_CODE_SEND'); ?>
		</button>
	</div>
	<div radicalmart-login="code_field" class="uk-margin-small" style="display: none">
		<input <?php echo ArrayHelper::toString($attributes); ?> />
	</div>
	<div radicalmart-login="code_repeat">
		<div radicalmart-login="code_repeat_message" class="uk-text-small uk-text-primary uk-margin-small" style="display: none"></div>
		<div>
			<button type="button" class="uk-button uk-button-small uk-button-default" radicalmart-login="code_button"
			        onclick="window.RadicalMartLogin().codeSend(this)">
				<?php echo Text::_('COM_RADICALMART_LOGIN_CODE_REPEAT'); ?>
			</button>
		</div>
	</div>
</div>