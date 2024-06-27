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

use Joomla\CMS\Layout\LayoutHelper;

?>
<div uk-slider="autoplay: true" class="uk-margin-medium">
	<div class="uk-position-relative uk-visible-toggle" tabindex="0">
		<ul class="uk-slider-items uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-grid"
			uk-height-match="target: > li > div > .uk-card > .uk-card-body">
			<?php foreach ($this->children as $child): ?>
				<li class="item-<?php echo $child->id; ?>">
					<div class="uk-padding-small uk-padding-remove-horizontal">
						<?php echo LayoutHelper::render('components.radicalmart.categories.item.grid', $child); ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
		   uk-slider-item="previous"></a>
		<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
		   uk-slider-item="next"></a>
	</div>
	<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
</div>
