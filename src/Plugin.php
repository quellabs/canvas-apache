<?php
	
	namespace Quellabs\CanvasApache;
	
	use Composer\Composer;
	use Composer\IO\IOInterface;
	use Composer\Plugin\PluginInterface;
	use Composer\EventDispatcher\EventSubscriberInterface;
	use Composer\Installer\PackageEvents;
	use Composer\Installer\PackageEvent;
	
	class Plugin implements PluginInterface, EventSubscriberInterface {
		
		public function activate(Composer $composer, IOInterface $io) {
			// Plugin activation
		}
		
		public function deactivate(Composer $composer, IOInterface $io) {
			// Plugin deactivation
		}
		
		public function uninstall(Composer $composer, IOInterface $io) {
			// Plugin uninstall
		}
		
		public static function getSubscribedEvents(): array {
			return [
				PackageEvents::POST_PACKAGE_INSTALL => 'onPostPackageInstall',
			];
		}
		
		public function onPostPackageInstall(PackageEvent $event) {
			$package = $event->getOperation()->getPackage();
			
			// Only run for this package
			if ($package->getName() !== 'quellabs/canvas-apache') {
				return;
			}
			
			$io = $event->getIO();
			$composer = $event->getComposer();
			$vendorDir = $composer->getConfig()->get('vendor-dir');
			$projectRoot = dirname($vendorDir);
			$publicDir = $projectRoot . '/public';
			
			// Create public directory if it doesn't exist
			if (!is_dir($publicDir)) {
				mkdir($publicDir, 0755, true);
				$io->write('<info>Created public directory</info>');
			} else {
				$io->write('<comment>Public directory already exists</comment>');
			}
			
			// Get template directory from installed package
			$packagePath = $vendorDir . '/quellabs/canvas-apache';
			
			// Copy index.php
			$indexSource = $packagePath . '/templates/index.php';
			$indexDest = $publicDir . '/index.php';
			
			if (!file_exists($indexDest) && file_exists($indexSource)) {
				if (copy($indexSource, $indexDest)) {
					$io->write('<info>Copied index.php to public directory</info>');
				} else {
					$io->writeError('<error>Failed to copy index.php</error>');
				}
			} else {
				$io->write('<comment>index.php already exists, skipping</comment>');
			}
			
			// Copy .htaccess
			$htaccessSource = $packagePath . '/templates/.htaccess';
			$htaccessDest = $publicDir . '/.htaccess';
			
			if (!file_exists($htaccessDest) && file_exists($htaccessSource)) {
				if (copy($htaccessSource, $htaccessDest)) {
					$io->write('<info>Copied .htaccess to public directory</info>');
				} else {
					$io->writeError('<error>Failed to copy .htaccess</error>');
				}
			} else {
				$io->write('<comment>.htaccess already exists, skipping</comment>');
			}
		}
	}