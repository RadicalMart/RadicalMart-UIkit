<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;

$displayData['autocomplete'] = 'false';

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


// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets         = Factory::getApplication()->getDocument()->getWebAssetManager();
$assetsRegistry = $assets->getRegistry();

$assetsRegistry->addExtensionRegistryFile('com_radicalmart_search');
$assets->useScript('com_radicalmart_search.field.ajax-search');

?>
<div id="<?php echo $id . '_container'; ?>" radicalmart_search-field-search-ajax="container"
	 data-field_id="<?php echo $id; ?>">
	<?php echo LayoutHelper::render('joomla.form.field.text', $displayData); ?>
	<div radicalmart_search-field-search-ajax="result" >
	</div>
</div>
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
		let container = document.querySelector('#<?php echo $id . '_container'; ?>'),
			result = container.querySelector('[radicalmart_search-field-search-ajax="result"]'),
			dropdown = UIkit.dropdown(result, {
				pos: 'bottom-justify',
				mode: 'click'
			});
		container.addEventListener('onRadicalMartSearchAjaxError', (event) => {
			let data = event.detail;
			Joomla.renderMessages({
				error: [data.error.message]
			});
		});
		container.addEventListener('onRadicalMartSearchAjaxAfter', (event) => {
			console.log('onRadicalMartSearchAjaxAfter');
			let data = event.detail;
			result.innerHTML = data.response.html;
			dropdown.show();
		});
	});
</script>