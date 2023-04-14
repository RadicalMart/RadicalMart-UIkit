<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     1.1.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2023 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
$assets->useScript('keepalive')
	->useScript('form.validate');

if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

$excludeFieldsets = ['hidden'];
$sections         = [
	'contacts' => [],
	'others'   => [],
];

$shippingSections = [];
$paymentSections  = [];

foreach ($this->form->getFieldsets() as $key => $fieldset)
{
	foreach ($this->form->getFieldset($key) as $field)
	{
		$name  = $field->fieldname;
		$group = $field->group;
		$type  = strtolower($field->type);
		$class = $this->form->getFieldAttribute($name, 'class', '', $group);
		$input = $field->input;
		if ($type === 'text' || $type === 'email')
		{
			$class .= ' uk-input';
		}
		elseif ($type === 'list' || preg_match('#<select#', $input))
		{
			$class .= ' uk-select';
		}
		elseif ($type === 'textarea' || preg_match('#<textarea#', $input))
		{
			$class .= ' uk-textarea';
		}
		elseif ($type === 'range')
		{
			$class .= ' uk-range';
		}

		$this->form->setFieldAttribute($name, 'class', $class, $group);
	}

	if (in_array($fieldset->name, $excludeFieldsets))
	{
		continue;
	}

	if (empty($this->form->getFieldset($fieldset->name)))
	{
		continue;
	}

	if ($fieldset->name !== 'others' && isset($sections[$fieldset->name]))
	{
		$sections[$fieldset->name][] = $fieldset;
	}
	elseif (strpos($fieldset->name, 'shipping_method_') !== false)
	{
		if (preg_match('#shipping_method_[1-9]*#i', $fieldset->name, $matches))
		{
			$section = $matches[0];
			if (!empty($section))
			{
				if (!isset($shippingSections[$section]))
				{
					$shippingSections[$section] = [];
				}

				$shippingSections[$section][] = $fieldset;
			}
			else
			{
				$sections['others'][] = $fieldset;
			}
		}
		else
		{
			$sections['others'][] = $fieldset;
		}
	}
	elseif (strpos($fieldset->name, 'payment_method_') !== false)
	{
		if (preg_match('#payment_method_[1-9]*#i', $fieldset->name, $matches))
		{
			$section = $matches[0];
			if (!empty($section))
			{
				if (!isset($paymentSections[$section]))
				{
					$paymentSections[$section] = [];
				}

				$paymentSections[$section][] = $fieldset;
			}
			else
			{
				$sections['others'][] = $fieldset;
			}
		}
		else
		{
			$sections['others'][] = $fieldset;
		}
	}
	elseif (strpos($fieldset->name, '_') !== false)
	{
		$section = explode('_', $fieldset->name, 2)[0];
		if (!empty($section) && isset($sections[$section]))
		{
			$sections[$section][] = $fieldset;
		}
		else
		{
			$sections['others'][] = $fieldset;
		}
	}
	else
	{
		$sections['others'][] = $fieldset;
	}
}
$language = Factory::getApplication()->getLanguage();
?>
<div id="RadicalMart" class="personal">
	<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
		<div class="uk-width-1-4@m">
			<?php echo LayoutHelper::render('components.radicalmart.account.sidebar'); ?>
		</div>
		<div>
			<form action="<?php echo $this->link; ?>" name="personalForm" id="personalForm" method="post"
				  enctype="multipart/form-data"
				  class="uk-card uk-card-default uk-card-small uk-form form-validate">
				<div class="uk-card-header">
					<h1 class="uk-h2">
						<?php echo $this->params->get('seo_personal_h1', Text::_('COM_RADICALMART_PERSONAL')); ?>
					</h1>
				</div>
				<div class="uk-card-body">
					<?php if (!empty($sections['contacts'])): ?>
						<div class="personal-section-contacts uk-margin-large-bottom">
							<h2 class="h3 mb-3">
								<?php echo Text::_('COM_RADICALMART_CONTACTS'); ?>
							</h2>
							<?php foreach ($sections['contacts'] as $fieldset): ?>
								<fieldset id="personal_<?php echo $fieldset->name; ?>"
										  class="options-form form-horizontal uk-fieldset">
									<?php if (!empty($fieldset->label)): ?>
										<legend class="uk-h4"><?php echo Text::_($fieldset->label); ?></legend>
									<?php endif; ?>
									<div class="uk-child-width-1-2@s" uk-grid>
										<?php echo $this->form->renderFieldset($fieldset->name); ?>
									</div>
								</fieldset>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<?php foreach ($shippingSections as $key => $section):
						if (!isset($this->shippingMethods[$key]))
						{
							continue;
						}
						$method  = $this->shippingMethods[$key];
						$hide    = ($method->disabled) ? 'style="display:none"' : '';
						$content = (empty($method->layout)) ? false : LayoutHelper::render($method->layout, [
							'item'      => $this->item,
							'form'      => $this->form,
							'shipping'  => $method,
							'fieldsets' => $section,
							'group'     => 'shipping.' . $key,
						]);
						?>
						<div class="personal-section-<?php echo $key; ?> uk-margin-large-bottom" <?php echo $hide; ?>>
							<h2 class="h3 mb-3">
								<?php echo Text::sprintf('COM_RADICALMART_PERSONAL_SHIPPING', $method->title); ?>
							</h2>
							<?php if (!empty($content)): ?>
								<?php echo $content; ?>
							<?php else: ?>
								<?php foreach ($section as $fieldset): ?>
									<fieldset id="personal_<?php echo $fieldset->name; ?>"
											  class="options-form form-horizontal uk-fieldset">
										<?php if (!empty($fieldset->label)): ?>
											<legend class="uk-h4"><?php echo Text::_($fieldset->label); ?></legend>
										<?php endif; ?>
										<div class="uk-child-width-1-2@s" uk-grid>
											<?php echo $this->form->renderFieldset($fieldset->name); ?>
										</div>
									</fieldset>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
					<?php foreach ($paymentSections as $key => $section):
						if (!isset($this->paymentMethods[$key]))
						{
							continue;
						}
						$method  = $this->paymentMethods[$key];
						$hide    = ($method->disabled) ? 'style="display:none"' : '';
						$content = (empty($method->layout)) ? false : LayoutHelper::render($method->layout, [
							'item'      => $this->item,
							'form'      => $this->form,
							'payment'   => $method,
							'fieldsets' => $section,
							'group'     => 'payment.' . $key,
						]);
						?>
						<div class="personal-section-<?php echo $key; ?> uk-margin-large-bottom" <?php echo $hide; ?>>
							<h2 class="uk-h3  uk-margin-bottom">
								<?php echo Text::sprintf('COM_RADICALMART_PERSONAL_PAYMENT', $method->title); ?>
							</h2> <?php if (!empty($content)): ?>
								<?php echo $content; ?>
							<?php else: ?>
								<?php foreach ($section as $fieldset): ?>
									<fieldset id="personal_<?php echo $fieldset->name; ?>"
											  class="options-form form-horizontal uk-fieldset">
										<?php if (!empty($fieldset->label)): ?>
											<legend class="uk-h4"><?php echo Text::_($fieldset->label); ?></legend>
										<?php endif; ?>
										<div class="uk-child-width-1-2@s" uk-grid>
											<?php echo $this->form->renderFieldset($fieldset->name); ?>
										</div>
									</fieldset>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
					<?php if (!empty($sections['others'])): ?>
						<div class="personal-section-others uk-margin-bottom">
							<div>
								<?php foreach ($sections['others'] as $fieldset): ?>
									<fieldset id="personal_<?php echo $fieldset->name; ?>"
											  class="options-form form-horizontal uk-fieldset">
										<?php if (!empty($fieldset->label)): ?>
											<legend class="uk-h4"><?php echo Text::_($fieldset->label); ?></legend>
										<?php endif; ?>
										<div class="uk-child-width-1-2@s" uk-grid>
											<?php echo $this->form->renderFieldset($fieldset->name); ?>
										</div>
									</fieldset>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="uk-card-footer uk-text-center">
					<button class="uk-button uk-button-primary"><?php echo Text::_('JSAVE'); ?></button>
				</div>
				<div class="uk-hidden">
					<?php echo $this->form->renderFieldset('hidden'); ?>
				</div>
				<input type="hidden" name="option" value="com_radicalmart"/>
				<input type="hidden" name="task" value="personal.save"/>
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
