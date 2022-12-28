<?php
/*
 * @package     RadicalMart Package
 * @subpackage  plg_radicalmart_shipping_standard
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2021 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

defined('_JEXEC') or die;

extract($displayData);

use Joomla\CMS\Form\Form;

/**
 * Layout variables
 * -----------------
 *
 * @var  Form    $form   Form object.
 * @var  object  $item   Checkout object.
 * @var  object  $shipping Checkout shipping method object.
 * @var  boolean $new    Button target.
 *
 */

if (empty($shipping))
{
	return false;
}
?>
<div class="uk-grid-small" uk-grid="">
	<?php if ($shipping->params->get('field_country', 1)): ?>
		<div class="uk-width-1-1"><?php echo $form->renderField('country', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_city', 1)): ?>
		<div class="uk-width-2-3@s"><?php echo $form->renderField('city', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_zip', 1)): ?>
		<div class="uk-width-1-3@s"><?php echo $form->renderField('zip', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_street', 1)): ?>
		<div class="uk-width-2-3@s"><?php echo $form->renderField('street', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_house', 1)): ?>
		<div class="uk-width-1-3@s"><?php echo $form->renderField('house', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_building', 1)): ?>
		<div class="uk-width-1-4@s"><?php echo $form->renderField('building', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_entrance', 1)): ?>
		<div class="uk-width-1-4@s"><?php echo $form->renderField('entrance', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_floor', 1)): ?>
		<div class="uk-width-1-4@s"><?php echo $form->renderField('floor', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_apartment', 1)): ?>
		<div class="uk-width-1-4@s"><?php echo $form->renderField('apartment', 'shipping'); ?></div>
	<?php endif; ?>
	<?php if ($shipping->params->get('field_comment', 1)): ?>
		<div class="uk-width-1-1"><?php echo $form->renderField('comment', 'shipping'); ?></div>
	<?php endif; ?>
</div>

