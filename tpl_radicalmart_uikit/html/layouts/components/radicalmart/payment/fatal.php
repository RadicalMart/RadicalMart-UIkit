<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2023 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

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
	if (!empty($page_exception->getCode()))
	{
		$message .= ' (' . $page_exception->getCode() . ')';
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
?>
<div class="uk-text-center uk-container uk-container-small">
	<div uk-icon="icon:close; ratio:5" class="uk-text-danger"></div>
	<div class="uk-h3 uk-margin-small"><?php echo $page_message; ?></div>
	<?php if (!empty($message)): ?>
		<div class="uk-text-danger uk-margin-small-bottom">
			<code><?php echo $message; ?></code>
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