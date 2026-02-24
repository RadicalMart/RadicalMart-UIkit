<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.4
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\RadicalMart\Site\View\Product\HtmlView $this */
?>
<div class="info">
	<?php if (!empty($this->product->categories)): ?>
		<div class="categories uk-margin-small">
			<?php foreach ($this->product->categories as $category): ?>
				<a href="<?php echo $category->link; ?>"
				   class="uk-text-italic uk-text-nowrap uk-text-small uk-margin-small-right">
					#<?php echo $category->title; ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<h1 class="uk-h2 uk-margin-small">
		<?php echo $this->params->get('seo_product_h1', $this->product->title); ?>
	</h1>

	<?php echo $this->product->event->afterDisplayTitle; ?>

	<?php echo $this->loadTemplate('buy'); ?>


	<?php if (!empty($this->modules['radicalmart-product-before-introtext'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-product-before-introtext'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($this->product->introtext)): ?>
		<div>
			<?php echo $this->product->introtext; ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($this->modules['radicalmart-product-after-introtext'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-product-after-introtext'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($this->product->fieldsets) && isset($this->product->fieldsets['root'])
			&& !empty($this->product->fieldsets['root']->fields)): ?>
		<div class="product-main-fields uk-margin">
			<?php foreach ($this->product->fieldsets['root']->fields as $field):
				if (empty($field->value) || !empty($this->variability->fields[$field->alias]))
				{
					continue;
				} ?>
				<div class="uk-form-horizontal uk-margin-small uk-clearfix">
					<div class="uk-form-label"><?php echo $field->title; ?></div>
					<div class="uk-form-controls uk-form-controls-text">
						<?php echo $field->value; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php echo $this->loadTemplate('variability'); ?>
</div>
