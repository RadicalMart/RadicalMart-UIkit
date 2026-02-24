<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.4
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $product Product object.
 * @var  string $mode    RadicalMart mode.
 *
 */

if (empty($product->badges))
{
	return;
}
?>
<div class="uk-position-top-left uk-position-z-index">
	<?php foreach ($product->badges as $badge): ?>
		<a href="<?php echo $badge->link; ?>" uk-tooltip
		   class="uk-display-inline-block uk-margin-small-top uk-margin-small-left"
		   style="height: 45px; width: 45px"
		   title="<?php echo Text::sprintf('COM_RADICALMART_PRODUCT_BADGE_LINK', $badge->title); ?>">
			<?php if ($src = $badge->media->get('icon'))
			{
				echo MediaHelper::renderImage(
						'com_radicalmart.categories.badge',
						$src,
						[
								'alt'     => $badge->title,
								'loading' => 'lazy',
								'style'   => 'max-width: 100%; max-height:100%;',
						],
						[
								'category_id' => $badge->id,
								'no_image'    => false,
								'thumb'       => true,
						]);
			}
			else
			{
				echo '<span class="uk-label">' . $badge->title . '</span>';
			} ?>
		</a>
	<?php endforeach; ?>
</div>