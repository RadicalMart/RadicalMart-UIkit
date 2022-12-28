<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>
<?php if (!empty($this->modules['radicalmart-product-before-overview'])): ?>
	<div class="uk-margin">
		<?php foreach ($this->modules['radicalmart-product-before-overview'] as $module): ?>
			<div class="uk-margin">
				<?php if ($module->showtitle): ?>
					<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
				<?php endif; ?>
				<div><?php echo $module->render; ?></div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php if (!empty($this->product->fulltext)): ?>
	<div>
		<?php echo $this->product->fulltext; ?>
	</div>
<?php endif; ?>