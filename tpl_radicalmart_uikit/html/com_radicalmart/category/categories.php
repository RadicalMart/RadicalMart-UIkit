<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.14
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Category\HtmlView $this */

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}
?>
<div id="RadicalMart" class="categories">
	<h1 class="uk-h2 uk-margin uk-margin-remove-top">
		<?php echo $this->params->get('seo_categories_h1', $this->category->title); ?>
	</h1>
	<?php if (!empty($this->category->introtext)): ?>
		<div class="category info">
			<?php echo $this->category->introtext; ?>
		</div>
	<?php endif; ?>
	<?php if (empty($this->children)) : ?>
		<div class="uk-alert uk-alert-warning">
			<?php echo Text::_('COM_RADICALMART_ERROR_CATEGORIES_NOT_FOUND'); ?>
		</div>
	<?php else : ?>
		<div class="categories-list uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid
			 uk-height-match="target: > div > .uk-card > .uk-card-body">
			<?php foreach ($this->children as $item) : ?>
				<div class="item-<?php echo $item->id; ?>">
					<?php echo LayoutHelper::render('components.radicalmart.categories.item.grid', $item); ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($this->category->fulltext)): ?>
		<div class="fulltext uk-margin-medium uk-card uk-card-default uk-card-body">
			<?php echo $this->category->fulltext; ?>
		</div>
	<?php endif; ?>
</div>