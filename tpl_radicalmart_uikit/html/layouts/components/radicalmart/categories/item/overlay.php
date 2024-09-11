<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.2.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

/* @var object $displayData Category object */

use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

?>
<a class="uk-display-block uk-inline-clip uk-card uk-overflow-hidden uk-link-reset uk-transition-toggle"
   href="<?php echo $displayData->link; ?>">
	<div class="uk-cover-container uk-height-medium uk-transition-scale-up uk-transition-opaque">
		<?php echo MediaHelper::renderImage(
			'com_radicalmart.categories',
			$displayData->media->get('image', $displayData->media->get('icon')),
			[
				'alt'      => $displayData->title,
				'loading'  => 'lazy',
				'uk-cover' => ''
			],
			[
				'category_id' => $displayData->id,
				'no_image'    => true,
				'thumb'       => true,
			]); ?>
	</div>
	<div class="uk-overlay uk-overlay-primary uk-light uk-position-bottom">
		<?php echo $displayData->title; ?>
	</div>
</a>