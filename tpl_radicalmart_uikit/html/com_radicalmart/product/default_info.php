<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.0.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

?>
<?php if (!empty($this->product->categories)): ?>
	<div class="categories uk-margin">
		<?php foreach ($this->product->categories as $category): ?>
			<a href="<?php echo $category->link; ?>"
			   class="uk-text-italic uk-text-nowrap uk-text-small uk-margin-small-right">
				#<?php echo $category->title; ?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
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
<?php if (!empty($this->product->fieldsets) && isset($this->product->fieldsets['root']) && !empty($this->product->fieldsets['root']->fields)): ?>
	<div class="product-main-fields uk-margin">
		<?php foreach ($this->product->fieldsets['root']->fields as $field):
			if (empty($field->value)) continue; ?>
			<div class="uk-form-horizontal uk-margin-remove uk-clearfix">
				<div class="uk-form-label"><?php echo $field->title; ?></div>
				<div class="uk-form-controls uk-form-controls-text">
					<?php echo $field->value; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php if (!empty($this->product->manufacturers)): ?>
	<div class="uk-margin">
		<ul class="uk-thumbnav">
			<?php foreach ($this->product->manufacturers as $manufacturer): ?>
				<li>
					<a href="<?php echo $manufacturer->link; ?>" uk-tooltip
					   title="<?php echo Text::sprintf('COM_RADICALMART_PRODUCT_MANUFACTURER_LINK', $manufacturer->title); ?>">
						<?php if ($src = $manufacturer->media->get('icon'))
						{
							echo MediaHelper::renderImage(
								'com_radicalmart.categories.manufacturer',
								$src,
								[
									'alt'     => $manufacturer->title,
									'loading' => '$manufacturer',
								],
								[
									'category_id' => $manufacturer->id,
									'no_image'    => false,
									'thumb'       => true,
								]);
						}
						else
						{
							echo $manufacturer->title;
						} ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>