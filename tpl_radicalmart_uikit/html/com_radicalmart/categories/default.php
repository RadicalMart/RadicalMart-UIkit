<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     1.0.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

// Load assets
/** @var Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}
?>
<div id="RadicalMart" class="radicalmart-container categories">
	<h1>
		<?php echo $this->params->get('seo_categories_h1', $this->category->title); ?>
	</h1>
	<?php if (!empty($this->category->introtext)): ?>
		<div class="category info">
			<?php echo $this->category->introtext; ?>
		</div>
	<?php endif; ?>
	<?php if (empty($this->items)) : ?>
		<div class="uk-alert uk-alert-warning">
			<?php echo Text::_('COM_RADICALMART_ERROR_CATEGORIES_NOT_FOUND'); ?>
		</div>
	<?php else : ?>
		<div class="categories-list uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid
			 uk-height-match="target: > div > .uk-card > .uk-card-body">
			<?php foreach ($this->items as $item) : ?>
				<div class="item-<?php echo $item->id; ?>">
					<?php echo LayoutHelper::render('components.radicalmart.categories.item.grid', $item); ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($this->category->fulltext)): ?>
		<div class="fulltext">
			<?php echo $this->category->fulltext; ?>
		</div>
	<?php endif; ?>
</div>