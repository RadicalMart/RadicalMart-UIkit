<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

/** @var \Joomla\Component\RadicalMart\Site\View\Product\HtmlView $this */

if (!$this->variability || !$this->variabilityForm)
{
	return;
}

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

$this->getDocument()->addScriptOptions($jsSelector, $jsData);
$this->getDocument()->getWebAssetManager()
		->useScript('com_radicalmart.site.variability');
?>
<div radicalmart-variability="<?php echo $jsSelector; ?>">
	<?php foreach ($this->variabilityForm->getGroup('') as $field):
		$group = $field->__get('group');
		$name = $field->__get('fieldname'); ?>
		<div class="uk-form-horizontal uk-margin-small uk-clearfix">
			<div class="uk-form-label">
				<?php echo $this->variabilityForm->getLabel($name, $group); ?>
			</div>
			<div class="uk-form-controls uk-form-controls-text">
				<?php echo $this->variabilityForm->getInput($name, $group); ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>