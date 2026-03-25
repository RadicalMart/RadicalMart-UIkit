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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $product      Product object.
 * @var  string $mode         RadicalMart mode.
 * @var  int    $height_px    Int height value in px
 * @var  int    $width_px     Int width value in px
 * @var  string $height_class Sting uikit height class (uk-height-medium as default)
 * @var  string $width_class  Sting uikit height class (uk-height-medium as default)
 * @var  bool   $link         Is link block
 */

$blur = (!empty($product->image)) ? HTMLHelper::image($product->image, '', [], false, true)
		: HTMLHelper::image('com_radicalmart/no-image.svg', '', [], true, true);

$style = '';
$class = 'uk-flex uk-flex-center uk-flex-middle uk-position-relative uk-overflow-hidden ';
if (!empty($height_px))
{
	$style .= ' height: ' . $height_px . 'px;';
}
elseif (!empty($height_class))
{
	$class .= ' ' . $height_class;
}
else
{
	$class .= ' uk-height-medium';
}

if (!empty($width_px))
{
	$style .= ' width: ' . $width_px . 'px;';
}
elseif (!empty($width_class))
{
	$class .= ' ' . $width_class;
}
else
{
	$class .= ' uk-width-1-1';
}

if (!isset($link))
{
	$link = $product->link;
}


?>
<?php if (!empty($link)) : ?>
	<a href="<?php echo $link; ?>" class="<?php echo $class; ?>" style="<?php echo $style; ?>">
		<div class="uk-position-cover uk-background-cover uk-background-center-center" style="
				background-image: url('<?php echo $blur; ?>');
				filter: blur(14px) brightness(0.85);
				transform: scale(1.1);"></div>
		<?php echo MediaHelper::renderImage(
				'com_radicalmart.metas.variability.grid', $product->image,
				[
						'alt'     => $product->title,
						'loading' => 'lazy',
						'style'   => 'max-width: 100%; max-height:100%;',
						'class'   => 'uk-position-relative uk-position-z-index',
				],
				[
						'meta_id'  => $product->id,
						'no_image' => true,
						'thumb'    => true,
				]); ?>
	</a>
<?php else: ?>
	<div class="<?php echo $class; ?>" style="<?php echo $style; ?>">
		<div class="uk-position-cover uk-background-cover uk-background-center-center" style="
				background-image: url('<?php echo $blur; ?>');
				filter: blur(14px) brightness(0.85);
				transform: scale(1.1);"></div>
		<?php echo MediaHelper::renderImage(
				'com_radicalmart.metas.variability.grid', $product->image,
				[
						'alt'     => $product->title,
						'loading' => 'lazy',
						'style'   => 'max-width: 100%; max-height:100%;',
						'class'   => 'uk-position-relative uk-position-z-index',
				],
				[
						'meta_id'  => $product->id,
						'no_image' => true,
						'thumb'    => true,
				]); ?>>
	</div>
<?php endif; ?>
