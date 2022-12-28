<?php
/*
 * @package     RadicalMart Package
 * @subpackage  com_radicalmart
 * @version     1.0.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2021 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
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
 * @var  object $order        The order data.
 * @var  array  $payment      The payment plugin data.
 *
 */
?>
<div class="uk-text-center uk-container uk-container-small">
	<div uk-icon="icon:credit-card; ratio:5"></div>
	<div class="uk-h3 uk-margin-small"><?php echo $page_message; ?></div>
	<div class="uk-text-muted uk-margin-small">
		<?php echo Text::sprintf('COM_RADICALMART_PAYMENT_PAY_PAGE_DESCRIPTION', $payment['link']); ?>
	</div>
	<div class="uk-margin-small">
		<?php echo Text::_('COM_RADICALMART_PAYMENT_PAY_PAGE_TIMER'); ?>
	</div>
</div>
<script>
	let left = 10,
		timer = setInterval(function () {
			if (left <= 0) {
				clearInterval(timer);
				window.location.href = '<?php echo $payment['link']?>';
			}
			document.querySelector('[radicalmart-payment-timer]').innerText = 10 - (10 - left);
			left -= 1;
		}, 1000);
</script>