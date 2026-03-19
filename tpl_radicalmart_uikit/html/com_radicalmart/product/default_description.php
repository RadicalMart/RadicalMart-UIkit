<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.10
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

/** @var \Joomla\Component\RadicalMart\Site\View\Product\HtmlView $this */

use Joomla\CMS\Language\Text;

$hasTabs = false;
if (!empty($this->product->fieldsets))
{
	foreach ($this->product->fieldsets as $fieldset)
	{
		if ($fieldset->alias === 'root')
		{
			continue;
		}

		$hasTabs = true;
		break;
	}
}

$overview = $this->loadTemplate('overview');

if (!$hasTabs && !$overview)
{
	return;
}
?>
<div class="uk-margin">
	<ul class="uk-margin-remove-bottom" uk-tab uk-switcher="connect: .js-tabs">
		<?php if (!empty($overview)): ?>
			<li>
				<a href="#product_overview" class="uk-active">
					<?php echo Text::_('COM_RADICALMART_OVERVIEW'); ?>
				</a>
			</li>
		<?php endif; ?>
		<?php if (!empty($this->product->fieldsets)): ?>
			<?php foreach ($this->product->fieldsets as $fieldset):
				if ($fieldset->alias === 'root')
				{
					continue;
				} ?>
				<li>
					<a href="#fields_<?php echo $fieldset->alias; ?>">
						<?php echo $fieldset->title; ?>
					</a>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<div class="uk-card uk-card-default uk-card-body uk-card-small">
		<div class="uk-switcher js-product-switcher js-tabs">
			<?php if (!empty($overview)): ?>
				<div id="product_overview"><?php echo $this->loadTemplate('overview'); ?></div>
			<?php endif; ?>
			<?php if (!empty($this->product->fieldsets)): ?>
				<?php foreach ($this->product->fieldsets as $fieldset):
					if ($fieldset->alias === 'root')
					{
						continue;
					} ?>
					<div>
						<?php foreach ($fieldset->fields as $field):
							if (empty($field->value))
							{
								continue;
							} ?>
							<div class="uk-form-horizontal uk-margin-remove uk-clearfix">
								<div class="uk-form-label"><?php echo $field->title; ?></div>
								<div class="uk-form-controls uk-form-controls-text">
									<?php echo $field->value; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
