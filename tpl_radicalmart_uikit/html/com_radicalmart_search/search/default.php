<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.15
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMartSearch\Site\View\Search\HtmlView $this */
?>
<div id="RadicalMart" class="search">
	<h1 class="uk-h2 uk-margin uk-margin-remove-top">
		<?php echo $this->params->get('seo_search_h1', Text::_('COM_RADICALMART_SEARCH_TITLE')); ?>
	</h1>
	<div class="uk-margin">
		<form action="<?php echo $this->link; ?>" class="uk-search uk-search-default">
			<?php $this->filterForm->setFieldAttribute('keyword', 'class', 'uk-search-input');
			echo $this->filterForm->getInput('keyword'); ?>
			<button class="uk-search-icon-flip" uk-search-icon
					title="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>"></button>
		</form>
	</div>
	<div class="uk-margin">
		<?php if (empty($this->items)) : ?>
			<div class="uk-alert uk-alert-warning">
				<?php echo Text::_('COM_RADICALMART_ERROR_PRODUCTS_NOT_FOUND'); ?>
			</div>
		<?php else: ?>
			<div class="products-list">
				<div uk-grid uk-height-match="target: > div > .product-block .middle">
					<?php foreach ($this->items as $item): ?>
						<div class="uk-width-1-3@m uk-width-1-2@s">
							<?php echo LayoutHelper::render('components.radicalmart.products.item.grid',
									['product' => $item, 'mode' => $this->mode]); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="list-pagination uk-margin-medium">
				<?php echo $this->pagination->getPaginationLinks(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>