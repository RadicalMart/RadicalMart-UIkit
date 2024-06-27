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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\RadicalMart\Site\Helper\RouteHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  string     $page_title     The page title.
 * @var  string     $page_message   The page message.
 * @var  \Exception $page_exception The page exception object.
 * @var  object     $order          The order data.
 * @var  array      $payment        The payment plugin data.
 *
 */

$message    = '';
$backtraces = [];
if (!empty($page_exception))
{
	$message = $page_exception->getMessage();
	if (!empty($message))
	{
		$message = nl2br($message);
	}
	if (!empty($page_exception->getCode()))
	{
		$message = '(' . $page_exception->getCode() . ') ' . $message;
	}

	if ((int) Factory::getApplication()->getConfig()->get('debug', 0) === 1)
	{
		$e         = $page_exception;
		$backtrace = false;
		while ((!empty($e)))
		{
			$backtrace = $e->getTrace();
			array_unshift($backtrace, [
				'file'     => $e->getFile(),
				'line'     => $e->getLine(),
				'function' => '']);
			$backtraces[] = $backtrace;

			$e = $e->getPrevious();
		}
	}
}

$button_href = Uri::root();
$button_text = 'COM_RADICALMART_PAYMENT_FATAL_PAGE_HOME_BUTTON';
if (!empty($order))
{
	$button_href = $order->link;
	$button_text = 'COM_RADICALMART_PAYMENT_FATAL_PAGE_ORDER_BUTTON';
}
elseif (!Factory::getApplication()->getIdentity()->guest)
{
	$button_href = Route::_(RouteHelper::getOrdersRoute(), false);
	$button_text = 'COM_RADICALMART_PAYMENT_FATAL_PAGE_ORDERS_BUTTON';
}
?>
<div class="uk-text-center uk-container uk-container-small">
	<div uk-icon="icon:close; ratio:5" class="uk-text-danger"></div>
	<div class="uk-h3 uk-margin-small"><?php echo $page_message; ?></div>
	<?php if (!empty($message)): ?>
		<div class="uk-text-danger uk-margin-small-bottom">
			<?php echo $message; ?>
		</div>
	<?php endif; ?>
	<div class="uk-margin">
		<a href="<?php echo $order->link; ?>" class="uk-button uk-button-primary">
			<?php echo Text::_('COM_RADICALMART_PAYMENT_ERROR_PAGE_BUTTON'); ?>
		</a>
	</div>
	<?php foreach ($backtraces as $backtrace): ?>
		<div class="uk-margin-small-top">
			<?php echo LayoutHelper::render('joomla.error.backtrace', ['backtrace' => $backtrace]); ?>
		</div>
	<?php endforeach; ?>
</div>