<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.17
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

if (empty($product->manufacturers))
{
	return;
}
?>
<div class="uk-margin">
	<ul class="uk-thumbnav">
		<?php foreach ($product->manufacturers as $manufacturer): ?>
			<li>
				<a href="<?php echo $manufacturer->link; ?>" uk-tooltip
				   title="<?php echo Text::sprintf('COM_RADICALMART_PRODUCT_MANUFACTURER_LINK', $manufacturer->title); ?>"
				   class="uk-display-inline-block uk-margin-small-right uk-margin-small-bottom"
				   style="height: 45px">
					<?php if ($src = $manufacturer->media->get('icon'))
					{
						echo MediaHelper::renderImage(
								'com_radicalmart.categories.manufacturer', $src,
								[
										'alt'     => $manufacturer->title,
										'loading' => 'lazy',
										'style'   => 'max-width: 100%; max-height:100%;',
								],
								[
										'category_id' => $manufacturer->id,
										'no_image'    => false,
										'thumb'       => true,
								]);
					}
					else
					{
						echo $manufacturer->title;
					} ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
