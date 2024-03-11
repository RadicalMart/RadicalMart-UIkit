<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.0.0
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
use Joomla\CMS\User\User;
use Joomla\Component\RadicalMart\Site\Helper\RouteHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  User|false $user Find user.
 * @var  Form       $form Login form
 *
 */

$message = 'COM_RADICALMART_LOGIN_CHECKOUT_MESSAGE';
if (!$user)
{
	$message .= '_REGISTRATION';
}
?>
<div radicalmart-checkout-layout="login">
	<div id="radicalmartCheckoutLogin" class="uk-flex-top" uk-modal="container:false">
		<div class="uk-modal-dialog uk-margin-auto-vertical">
			<div class="uk-modal-header">
				<div class="uk-modal-title uk-text-center">
					<span class="radicalmart-checkout-login-toggle"><?php echo Text::_($message); ?></span>
					<?php if (!$user): ?>
						<span class="radicalmart-checkout-login-toggle" hidden>
							<?php echo Text::_('COM_RADICALMART_LOGIN_CHECKOUT_MESSAGE'); ?>
						</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="uk-modal-body">
				<div class="uk-alert uk-alert-danger" radicalmart-checkout="loginFormError" style="display: none"></div>
				<?php if (!$user): ?>
					<div class="radicalmart-checkout-login-toggle uk-text-center">
						<span class="uk-button uk-button-large uk-button-primary"
							  uk-toggle="target: .radicalmart-checkout-login-toggle">
							<?php echo Text::_('JYES'); ?>
						</span>
						<span class="uk-button uk-button-large uk-button-secondary"
							  onclick="RadicalMartCheckout().registration()">
							<?php echo Text::_('JNO'); ?>
						</span>
					</div>
				<?php endif; ?>
				<form action="<?php echo Route::_(RouteHelper::getCheckoutRoute(), false); ?>"
					  method="post" enctype="multipart/form-data" radicalmart-checkout="loginForm"
					  class="uk-form uk-form-horizontal radicalmart-checkout-login-toggle" <?php if (!$user) echo 'hidden'; ?>>
					<?php echo $form->renderFieldset('credentials'); ?>
					<?php echo HTMLHelper::_('form.token'); ?>
					<input type="hidden" name="task" value="checkout.login"/>
					<div>
						<span class="uk-button uk-button-primary" onclick="RadicalMartCheckout().login()">
							<?php echo Text::_('COM_RADICALMART_LOGIN_SUBMIT'); ?>
						</span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>