<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.11
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Personal\HtmlView $this */

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
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

// Set uikit classes to form
require_once(JPATH_THEMES . '/system/radicalmart_uikit/helpers/uikit_form_classes.php');
setUikitFormClasses($this->form);

$excludeFieldsets = ['hidden'];
$sections         = [
		'contacts' => [],
		'others'   => [],
];
$shippingSections = [];
$paymentSections  = [];

foreach ($this->form->getFieldsets() as $key => $fieldset)
{
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

		continue;
	}

	if (str_starts_with($fieldset->name, 'shipping_method_')
			&& preg_match('#^shipping_method_[1-9]*#i', $fieldset->name, $matches))
	{
		$section = $matches[0];
		if (!isset($shippingSections[$section]))
		{
			$shippingSections[$section] = [];
		}

		$shippingSections[$section][] = $fieldset;

		continue;
	}

	if (str_starts_with($fieldset->name, 'payment_method_')
			&& preg_match('#^payment_method_[1-9]*#i', $fieldset->name, $matches))
	{
		$section = $matches[0];
		if (!isset($paymentSections[$section]))
		{
			$paymentSections[$section] = [];
		}

		$paymentSections[$section][] = $fieldset;

		continue;
	}

	if (str_contains($fieldset->name, '_'))
	{
		$section = explode('_', $fieldset->name, 2)[0];
		if (!empty($section) && isset($sections[$section]))
		{
			$sections[$section][] = $fieldset;
			continue;
		}
	}

	$sections['others'][] = $fieldset;
}
?>
<div id="RadicalMart" class="personal">
	<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
		<div class="uk-width-medium@m uk-flex-last uk-flex-first@m">
			<?php echo LayoutHelper::render('components.radicalmart.account.sidebar'); ?>
			<?php if (!empty($this->modules['radicalmart-account-sidebar'])): ?>
				<div class="uk-margin">
					<?php foreach ($this->modules['radicalmart-account-sidebar'] as $module): ?>
						<div class="uk-margin">
							<?php if ($module->showtitle): ?>
								<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
							<?php endif; ?>
							<div><?php echo $module->render; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<div>
			<h1 class="uk-h2 uk-margin uk-margin-remove-top">
				<?php echo $this->params->get('seo_personal_h1',
						($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_PERSONAL')); ?>
			</h1>
			<form action="<?php echo $this->link; ?>" name="personalForm" id="personalForm" method="post"
				  enctype="multipart/form-data" class="uk-form form-validate">
				<?php if (!empty($sections['contacts'])): ?>
					<div id="personal_section_contacts"
						 class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
						<div class="uk-card-header">
							<h2 class="uk-margin-remove uk-h4">
								<?php echo Text::_('COM_RADICALMART_CONTACTS'); ?>
							</h2>
						</div>
						<div class="uk-card-body">
							<?php foreach ($sections['contacts'] as $fieldset): ?>
								<fieldset id="personal_<?php echo $fieldset->name; ?>" class="uk-fieldset">
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

					<div id="personal_section_shipping_<?php echo $method->id; ?>"
						 class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
						<div class="uk-card-header">
							<h2 class="uk-margin-remove uk-h4">
								<?php echo Text::sprintf('COM_RADICALMART_PERSONAL_SHIPPING', $method->title); ?>
							</h2>
						</div>
						<div class="uk-card-body">
							<?php if (!empty($content)): ?>
								<?php echo $content; ?>
							<?php else: ?>
								<?php foreach ($section as $fieldset): ?>
									<fieldset id="personal_<?php echo $fieldset->name; ?>"
											  class="uk-fieldset">
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

					<div id="personal_section_payment_<?php echo $method->id; ?>"
						 class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
						<div class="uk-card-header">
							<h2 class="uk-margin-remove uk-h4">
								<?php echo Text::sprintf('COM_RADICALMART_PERSONAL_PAYMENT', $method->title); ?>
							</h2>
						</div>
						<div class="uk-card-body">
							<?php if (!empty($content)): ?>
								<?php echo $content; ?>
							<?php else: ?>
								<?php foreach ($section as $fieldset): ?>
									<fieldset id="personal_<?php echo $fieldset->name; ?>"
											  class="uk-fieldset">
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
					</div>
				<?php endforeach; ?>

				<?php if (!empty($sections['others'])): ?>
					<?php foreach ($sections['others'] as $fieldset): ?>
						<div class="uk-margin uk-position-relative uk-card uk-card-default uk-card-small">
							<?php if (!empty($fieldset->label)): ?>
								<div class="uk-card-header">
									<h2 class="uk-margin-remove uk-h4">
										<?php echo Text::_($fieldset->label); ?>
									</h2>
								</div>
							<?php endif; ?>
							<fieldset id="personal_<?php echo $fieldset->name; ?>" class="uk-fieldset">
								<div class="uk-child-width-1-2@s" uk-grid>
									<?php echo $this->form->renderFieldset($fieldset->name); ?>
								</div>
							</fieldset>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

				<div class="uk-hidden">
					<?php echo $this->form->renderFieldset('hidden'); ?>
				</div>

				<div class="uk-card-footer uk-text-center">
					<button class="uk-button uk-button-primary"><?php echo Text::_('JSAVE'); ?></button>
				</div>

				<input type="hidden" name="option" value="com_radicalmart"/>
				<input type="hidden" name="task" value="personal.save"/>
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
