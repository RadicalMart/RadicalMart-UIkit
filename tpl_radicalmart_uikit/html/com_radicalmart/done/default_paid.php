<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.2.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

?>
<div id="RadicalMart" class="done paid uk-text-center">
	<div class="uk-text-center uk-container uk-container-small">
		<div uk-icon="icon:check; ratio:5" class="uk-text-success"></div>
		<h1 class="uk-h2 uk-margin-small-top">
			<?php echo $this->params->get('seo_done_paid_h1',
				($this->menuCurrent) ? $this->menu->title : Text::_('COM_RADICALMART_DONE_PAGE_PAID_H1')); ?>
		</h1>
		<div>
			<a href="<?php echo Uri::root(); ?>" class="uk-button uk-button-default">
				<?php echo Text::_('COM_RADICALMART_DONE_PAGE_TO_HOME'); ?>
			</a>
			<a href="<?php echo $this->order->link; ?>" class="uk-button uk-button-default">
				<?php echo Text::_('COM_RADICALMART_DONE_PAGE_TO_ODER'); ?>
			</a>
		</div>
	</div>
</div>
