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

if (!$this->variability || !$this->variabilityForm) return;

$jsSelector = 'radicalmart_variability_' . $this->product->id;
$jsData     = [
	'products'        => [],
	'fields'          => array_keys($this->variability->fields),
	'current_product' => $this->product->id
];
foreach ($this->variability->products as $p => $product)
{
	$jsData['products'][$p] = [
		'id'     => $product->id,
		'title'  => $product->title,
		'link'   => $product->link,
		'fields' => $product->fieldsVariability
	];
}
$this->document->addScriptOptions($jsSelector, $jsData);
$this->document->getWebAssetManager()
	->useScript('com_radicalmart.site.variability');
?>
<div radicalmart-variability="<?php echo $jsSelector; ?>">
	<?php foreach ($this->variabilityForm->getFieldsets() as $fieldset)
	{
		echo $this->variabilityForm->renderFieldset($fieldset->name);
	} ?>
</div>