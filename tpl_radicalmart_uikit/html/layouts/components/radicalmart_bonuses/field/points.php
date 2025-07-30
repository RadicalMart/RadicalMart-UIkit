<?php
/*
 * @package     RadicalMart Bonuses Package
 * @subpackage  com_radicalmart_bonuses
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
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

if (!isset($displayData['points_order']))
{
	$displayData['points_order'] = 0;
}
if (!isset($displayData['points_customer']))
{
	$displayData['points_customer'] = 0;
}

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string $autocomplete    Autocomplete attribute for the field.
 * @var   bool   $autofocus       Is autofocus enabled?
 * @var   string $class           Classes for the input.
 * @var   string $description     Description of the field.
 * @var   bool   $disabled        Is this field disabled?
 * @var   string $group           Group the field belongs to. <fields> section in form XML.
 * @var   bool   $hidden          Is this field hidden in the form?
 * @var   string $hint            Placeholder for the field.
 * @var   string $id              DOM id of the field.
 * @var   string $label           Label of the field.
 * @var   string $labelclass      Classes to apply to the label.
 * @var   bool   $multiple        Does this field support multiple values?
 * @var   string $name            Name of the input field.
 * @var   string $onchange        Onchange attribute for the field.
 * @var   string $onclick         Onclick attribute for the field.
 * @var   string $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   bool   $readonly        Is this field read only?
 * @var   bool   $repeat          Allows extensions to duplicate elements.
 * @var   bool   $required        Is this field required?
 * @var   int    $size            Size attribute of the input.
 * @var   bool   $spellcheck      Spellcheck state for the form field.
 * @var   string $validate        Validation rules to apply.
 * @var   array  $value           Value attribute of the field.
 * @var   array  $checkedOptions  Options that will be set as checked.
 * @var   bool   $hasValue        Has this field a value assigned?
 * @var   array  $options         Options available for this field.
 *
 * Field specific variables
 * @var  string  $context         Form context.
 * @var  int     $customer_id     User id for check.
 * @var  int     $order_id        Order id for check.
 * @var  string  $currency        Currency for check.
 *
 * @var  float   $points_customer Total customer points.
 * @var  float   $points_apply    Points apply to order.
 * @var  array   $formula         Apply points formula.
 */

$app = Factory::getApplication();
$app->getLanguage()->load('com_radicalmart_bonuses');

// Load assets
if (!$readonly)
{
	/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
	$assets = Factory::getApplication()->getDocument()->getWebAssetManager();
	$assets->getRegistry()->addExtensionRegistryFile('com_radicalmart_bonuses');
	$assets->useScript('com_radicalmart_bonuses.fields.points');
}

$value = (!empty($value)) ? $value : 0;
?>
<div radicalmart_bonuses-field-points="container"
	 data-name="<?php echo $name; ?>"
	 data-context="<?php echo $context; ?>"
	 data-customer_id="<?php echo $customer_id; ?>"
	 data-order_id="<?php echo $order_id; ?>"
	 data-currency="<?php echo $currency; ?>">
	<div radicalmart_bonuses-field-points="error" class="uk-alert uk-alert-danger"
		 style="display: none"></div>
	<div radicalmart_bonuses-field-points="success" class="uk-alert uk-alert-success" style="display: none"></div>
	<div radicalmart_bonuses-field-points="loading"
		 class="uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-overlay-default"
		 style="display: none">
		<div uk-spinner="ratio: 3"></div>
	</div>
	<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>"
		   radicalmart_bonuses-field-points="field">
	<div class="uk-grid-small uk-grid-row-small uk-margin" uk-grid="">
		<?php if (!$readonly): ?>
			<div class="uk-width-2-5@s">
				<?php echo ($context === 'com_radicalmart.checkout')
					? Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_CUSTOMER_CHECKOUT') . ':'
					: Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_CUSTOMER') . ':'; ?>
			</div>
			<div class="uk-width-3-5@s uk-text-danger">
				<?php echo $points_customer; ?>
			</div>
		<?php endif; ?>
		<div class="uk-width-2-5@s">
			<?php echo ($context === 'com_radicalmart.checkout')
				? Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_VALUE_CHECKOUT') . ':'
				: Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_VALUE') . ':'; ?>
		</div>
		<div class="uk-width-3-5@s uk-text-success">
			<?php echo $value ?>
		</div>
		<?php if ($context === 'com_radicalmart.checkout'): ?>
			<div class="uk-width-2-5@s">
				<?php echo Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_APPLY_CHECKOUT') . ':' ?>
			</div>
			<div class="uk-width-3-5@s uk-text-warning">
				<?php echo $points_apply; ?>
			</div>
		<?php endif; ?>
		<div class="uk-width-2-5@s">
			<?php echo Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_FORMULA') . ':'; ?>
		</div>
		<div class="uk-width-3-5@s uk-text-secondary">
			<?php echo $formula['text']; ?>
		</div>
	</div>
	<?php if (!$readonly): ?>
		<div>
			<button type="button" radicalmart_bonuses-field-points="add"
					class="uk-button uk-button-small uk-button-secondary"
					style="display: none">
				<?php echo Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_FORM_ADD'); ?>
			</button>
			<button type="button" radicalmart_bonuses-field-points="change"
					class="uk-button uk-button-small uk-button-secondary"
					style="display: none">
				<?php echo Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_FORM_CHANGE'); ?>
			</button>
		</div>
		<div class="uk-margin-top" radicalmart_bonuses-field-points="form" style="display: none">
			<div>
				<input class="uk-input" radicalmart_bonuses-field-points="input"/>
			</div>
			<div class="uk-margin-small-top">
				<button type="button" radicalmart_bonuses-field-points="apply"
						class="uk-button uk-button-small uk-button-primary">
					<?php echo Text::_('COM_RADICALMART_BONUSES_FIELD_POINTS_FORM_APPLY'); ?>
				</button>
				<button type="button" radicalmart_bonuses-field-points="hide"
						class="uk-button uk-button-small uk-button-danger">
					<?php echo Text::_('JCANCEL'); ?>
				</button>
			</div>
		</div>
	<?php endif; ?>
</div>