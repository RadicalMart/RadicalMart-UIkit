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

if (!isset($displayData['customer_id']))
{
	$displayData['customer_id'] = 0;
}
if (!isset($displayData['order_id']))
{
	$displayData['order_id'] = 0;
}
if (!isset($displayData['currency']))
{
	$displayData['currency'] = '';
}
if (!isset($displayData['context']))
{
	$displayData['context'] = '';
}
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
 * @var  string  $context        Form context.
 * @var  int     $customer_id    User id for check.
 * @var  int     $order_id       Order id for check.
 * @var  string  $currency       Currency for check.
 * @var  array   $codes          Codes data array.
 */

// Load assets
if (!$readonly)
{
	/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
	$assets = Factory::getApplication()->getDocument()->getWebAssetManager();
	$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart_bonuses');
	$assets->useScript('com_radicalmart_bonuses.fields.codes');
}
?>
<div radicalmart_bonuses-field-codes="container" data-name="<?php echo $name; ?>" data-context="<?php echo $context; ?>"
	 data-customer_id="<?php echo $customer_id; ?>"
	 data-order_id="<?php echo $order_id; ?>" data-currency="<?php echo $currency; ?>">
	<div radicalmart_bonuses-field-codes="error" class="uk-alert uk-alert-danger"
		 style="display: none"></div>
	<div radicalmart_bonuses-field-codes="success" class="uk-alert uk-alert-success" style="display: none"></div>
	<div radicalmart_bonuses-field-codes="loading"
		 class="uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-overlay-default"
		 style="display: none">
		<div uk-spinner="ratio: 3"></div>
	</div>
	<?php if (!empty($codes)): ?>
		<div class="uk-flex uk-flex-wrap">
			<?php foreach ($codes as $code):
				$codeTitle = $code->code;
				if ($code->referral)
				{
					$codeTitle .= ' (' . Text::_('COM_RADICALMART_BONUSES_CODE_REFERRAL') . ')';
				}
				?>
				<div radicalmart_bonuses-field-codes="code" data-code="<?php echo $code->code; ?>">
					<?php if ($readonly): ?>
						<span class="uk-button uk-button-small uk-button-default uk-margin-small-right uk-margin-small-bottom">
							<?php echo $codeTitle; ?>
						</span>
					<?php else: ?>
						<button type="button"
								class="uk-button uk-button-small uk-button-default uk-margin-small-right uk-margin-small-bottom uk-flex uk-flex-nowrap uk-flex-middle"
								radicalmart_bonuses-field-codes="delete"
								data-code="<?php echo $code->code; ?>">
							<?php echo $codeTitle; ?>
							<span radicalmart_bonuses-field-codes="delete" class="uk-text-danger uk-margin-small-left"
								  uk-icon="icon:close; ratio:0.9"></span>
						</button>
					<?php endif; ?>
					<input type="hidden" name="<?php echo $name; ?>[]" value="<?php echo $code->id; ?>">
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if (!$readonly): ?>
		<div>
			<button type="button" radicalmart_bonuses-field-codes="show"
					class="uk-button uk-button-small uk-button-secondary">
				<?php echo Text::_('COM_RADICALMART_BONUSES_FIELD_CODES_FORM_SHOW'); ?>
			</button>
		</div>
		<div class="uk-margin-small-top" radicalmart_bonuses-field-codes="form" style="display: none">
			<div>
				<input class="form-control uk-input" radicalmart_bonuses-field-codes="input"/>
			</div>
			<div class="uk-margin-small-top">
				<button type="button" radicalmart_bonuses-field-codes="apply"
						class="uk-button uk-button-small uk-button-primary">
					<?php echo Text::_('COM_RADICALMART_BONUSES_FIELD_CODES_CODE_APPLY'); ?>
				</button>
				<button type="button" radicalmart_bonuses-field-codes="hide"
						class="uk-button uk-button-small uk-button-danger">
					<?php echo Text::_('JCANCEL'); ?>
				</button>
			</div>
		</div>
	<?php endif; ?>
</div>

