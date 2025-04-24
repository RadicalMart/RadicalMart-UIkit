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

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  string $page_title   The page title.
 * @var  string $page_message The page message.
 * @var  string $page_error   The page error message.
 * @var  object $order        The order data.
 * @var  array  $payment      The payment plugin data.
 *
 */
?>
<div class="uk-text-center uk-container uk-container-small">
	<div uk-icon="icon:close; ratio:5" class="uk-text-danger"></div>
	<div class="uk-h3 uk-margin-small"><?php echo $page_message; ?></div>
	<?php if (!empty($page_error)): ?>
		<div class="uk-text-danger uk-margin-small">
			<?php echo $page_error; ?>
		</div>
	<?php endif; ?>
	<div class="uk-margin">
		<a href="<?php echo $order->link; ?>" class="uk-button uk-button-primary">
			<?php echo Text::_('COM_RADICALMART_PAYMENT_ERROR_PAGE_BUTTON'); ?>
		</a>
	</div>
</div>