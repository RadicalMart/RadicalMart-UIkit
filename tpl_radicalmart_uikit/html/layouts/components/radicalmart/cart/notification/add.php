<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.1.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  array  $entry   Entry data.
 * @var  object $product Product data.
 * @var  object $cart    All cart data.
 *
 */
?>
<div radicalmart-cart-layout="notification_add">
	<div id="radicalmartCartNotificationAdd" class="uk-flex-top" uk-modal="container:false">
		<div class="uk-modal-dialog uk-margin-auto-vertical">
			<div class="uk-modal-body uk-text-center">
				<div class="uk-h2"><?php echo Text::_('COM_RADICALMART_CART_NOTIFICATION_ADD'); ?></div>
				<div>
					<a class="uk-modal-close uk-button uk-button-default">
						<?php echo Text::_('COM_RADICALMART_CONTINUE_SHOPPING'); ?></a>
					<a href="<?php echo $cart->link; ?>" class="uk-button uk-button-primary">
						<?php echo Text::_('COM_RADICALMART_CHECKOUT'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>