<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  Form $login        Login form
 * @var  Form $registration Registration form.
 *
 */

$action = Route::link('site', 'index.php?option=com_radicalmart', false);

foreach ([$login, $registration] as &$form)
{
	foreach ($form->getFieldsets() as $key => $fieldset)
	{
		foreach ($form->getFieldset($key) as $field)
		{
			$name  = $field->fieldname;
			$group = $field->group;
			$type  = strtolower($field->type);
			$class = $form->getFieldAttribute($name, 'class', '', $group);
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

			$form->setFieldAttribute($name, 'class', $class, $group);
		}
	}
}
?>
<div id="radicalmartLoginForm" class="uk-flex-top" uk-modal="container:false">
	<div class="uk-modal-dialog uk-margin-auto-vertical">
		<div class="uk-modal-header">
			<div class="uk-modal-title uk-text-center">
				<?php if ($registration): ?>
					<span class="radicalmart-login-toggle-login radicalmart-login-toggle-registration">
						<?php echo Text::_('COM_RADICALMART_LOGIN_FORM_MESSAGE'); ?>
					</span>
					<span class="radicalmart-login-toggle-login" hidden>
						<?php echo Text::_('COM_RADICALMART_LOGIN_FORM_MESSAGE_LOGIN'); ?>
					</span>
					<span class="radicalmart-login-toggle-registration" hidden>
						<?php echo Text::_('COM_RADICALMART_LOGIN_FORM_MESSAGE_REGISTRATION'); ?>
					</span>
				<?php else: ?>
					<?php echo Text::_('COM_RADICALMART_LOGIN_FORM_MESSAGE_LOGIN'); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="uk-modal-body">
			<div class="uk-alert uk-alert-danger" radicalmart-login="form_error" style="display: none"></div>
			<?php if ($registration): ?>
				<div class="radicalmart-login-toggle-login radicalmart-login-toggle-registration text-center collapse show">
					<span class="uk-button uk-button-large uk-button-primary"
						  uk-toggle="target: .radicalmart-login-toggle-login">
						<?php echo Text::_('JYES'); ?>
					</span>
					<span class="uk-button uk-button-large uk-button-secondary" data-bs-toggle="collapse"
						  uk-toggle="target: .radicalmart-login-toggle-registration">
						<?php echo Text::_('JNO'); ?>
					</span>
				</div>
			<?php endif; ?>

			<form action="<?php echo $action; ?>"
				  method="post" enctype="multipart/form-data" radicalmart-login="form_login"
				  class="radicalmart-login-toggle-login" <?php if ($registration) echo 'hidden'; ?>>
				<?php foreach ($login->getFieldsets() as $fieldset)
				{
					echo $login->renderFieldset($fieldset->name);
				} ?>
				<?php echo HTMLHelper::_('form.token'); ?>
				<input type="hidden" name="task" value="checkout.login"/>
				<div class="uk-margin-small-bottom">
					<a href="<?php echo Route::link('site', 'index.php?option=com_users&view=reset'); ?>">
						<?php echo Text::_('COM_RADICALMART_LOGIN_FORGOT_PASSWORD'); ?>
					</a>
				</div>
				<div>
					<span class="uk-button uk-button-primary"
						  onclick="window.RadicalMartLogin().login()">
						<?php echo Text::_('COM_RADICALMART_LOGIN_FORM_SUBMIT_LOGIN'); ?>
					</span>
				</div>
			</form>

			<?php if ($registration): ?>
				<form action="<?php echo $action; ?>"
					  method="post" enctype="multipart/form-data" radicalmart-login="form_registration"
					  class="radicalmart-login-toggle-registration" hidden>
					<?php foreach ($registration->getFieldsets() as $fieldset)
					{
						echo $registration->renderFieldset($fieldset->name);
					} ?>
					<?php echo HTMLHelper::_('form.token'); ?>
					<input type="hidden" name="task" value="checkout.login"/>
					<div>
						<span class="btn btn-primary"
							  onclick="window.RadicalMartLogin().registration()">
							<?php echo Text::_('COM_RADICALMART_LOGIN_FORM_SUBMIT_REGISTRATION'); ?>
						</span>
					</div>
				</form>
			<?php endif; ?>
		</div>
	</div>
</div>