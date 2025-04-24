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

defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   Form   $form      The form instance for render the section
 * @var   string $basegroup The base group name
 * @var   string $group     Current group name
 * @var   array  $buttons   Array of the buttons that will be rendered
 */

$fields = [
	'provider'  => 'uk-width-1-1',
	'country'   => 'uk-width-1-1',
	'region'    => 'uk-width-1-3@s',
	'city'      => 'uk-width-2-3@s',
	'zip'       => 'uk-width-1-3@s',
	'street'    => 'uk-width-2-3@s',
	'house'     => 'uk-width-1-4@s',
	'building'  => 'uk-width-1-4@s',
	'entrance'  => 'uk-width-1-4@s',
	'floor'     => 'uk-width-1-4@s',
	'apartment' => 'uk-width-1-4@s',

	'uid'     => 'uk-hidden',
	'string'  => 'uk-hidden',
	'display' => 'uk-hidden',
]
?>
<div class="subform-repeatable-group uk-card uk-card-default uk-card-body" data-base-name="<?php echo $basegroup; ?>"
	 data-group="<?php echo $group; ?>">
	<?php if (!empty($buttons) && (!empty($buttons['remove']))) : ?>
		<div class="uk-text-right">
			<button type="button" class="group-remove uk-button uk-button-danger uk-button-small"
					aria-label="<?php echo Text::_('JGLOBAL_FIELD_REMOVE'); ?>">
				<span uk-icon="icon:minus; ratio:0.8" aria-hidden="true"></span>
			</button>
		</div>
	<?php endif; ?>
	<div class="uk-grid-small" uk-grid="">
		<?php foreach ($fields as $key => $column):
			if (empty($form->getField($key)))
			{
				continue;
			} ?>
			<div class="<?php echo $column; ?>">
				<?php echo $form->renderField($key); ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if (!empty($buttons) && (!empty($buttons['add']))) : ?>
	<div class="uk-text-right">
		<button type="button" class="group-add uk-button uk-button-primary uk-button-small"
				aria-label="<?php echo Text::_('JGLOBAL_FIELD_ADD'); ?>">
			<span uk-icon="icon:plus; ratio:0.8" aria-hidden="true"></span>
		</button>
		<?php endif; ?>
	</div>
</div>