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

use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Version;
use Joomla\Database\DatabaseDriver;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
	public function register(Container $container)
	{
		$container->set(InstallerScriptInterface::class, new class ($container->get(AdministratorApplication::class)) implements InstallerScriptInterface {
			/**
			 * The application object
			 *
			 * @var  AdministratorApplication
			 *
			 * @since  1.0.0
			 */
			protected AdministratorApplication $app;

			/**
			 * The Database object.
			 *
			 * @var   DatabaseDriver
			 *
			 * @since  1.0.0
			 */
			protected DatabaseDriver $db;

			/**
			 * Minimum Joomla version required to install the extension.
			 *
			 * @return  string
			 *
			 * @since  1.0.0
			 */
			protected string $minimumJoomla = '4.2';

			/**
			 * Minimum PHP version required to install the extension.
			 *
			 * @return  string
			 *
			 * @since  1.0.0
			 */
			protected string $minimumPhp = '7.4';

			/**
			 * Constructor.
			 *
			 * @param   AdministratorApplication  $app  The aplications obbject.
			 *
			 * @since 1.0.0
			 */
			public function __construct(AdministratorApplication $app)
			{
				$this->app = $app;
				$this->db  = Factory::getContainer()->get('DatabaseDriver');
			}

			/**
			 * Function called after the extension is installed.
			 *
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function install(InstallerAdapter $adapter): bool
			{
				return true;
			}

			/**
			 * Function called after the extension is updated.
			 *
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function update(InstallerAdapter $adapter): bool
			{
				// Refresh media version
				(new Version())->refreshMediaVersion();

				return true;
			}

			/**
			 * Function called after the extension is uninstalled.
			 *
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function uninstall(InstallerAdapter $adapter): bool
			{
				return true;
			}

			/**
			 * Function called before extension installation/update/removal procedure commences.
			 *
			 * @param   string            $type     The type of change (install or discover_install, update, uninstall)
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function preflight(string $type, InstallerAdapter $adapter): bool
			{
				// Check compatible
				if (!$this->checkCompatible())
				{
					return false;
				}

				return true;
			}

			/**
			 * Function called after extension installation/update/removal procedure commences.
			 *
			 * @param   string            $type     The type of change (install or discover_install, update, uninstall)
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function postflight(string $type, InstallerAdapter $adapter): bool
			{
				return true;
			}

			/**
			 * Method to check compatible.
			 *
			 * @throws  \Exception
			 *
			 * @return  bool True on success, False on failure.
			 *
			 * @since  1.0.0
			 */
			protected function checkCompatible(): bool
			{
				$app = Factory::getApplication();

				// Check joomla version
				if (!(new Version())->isCompatible($this->minimumJoomla))
				{
					$app->enqueueMessage(Text::sprintf('PKG_RADICALMART_UIKIT_ERROR_COMPATIBLE_JOOMLA', $this->minimumJoomla),
						'error');

					return false;
				}

				// Check PHP
				if (!(version_compare(PHP_VERSION, $this->minimumPhp) >= 0))
				{
					$app->enqueueMessage(Text::sprintf('PKG_RADICALMART_UIKIT_ERROR_COMPATIBLE_PHP', $this->minimumPhp),
						'error');

					return false;
				}

				return true;
			}
		});
	}
};