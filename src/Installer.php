<?php
	
	namespace YourVendor\PublicFolderInstaller;
	
	use Composer\Script\Event;
	
	class Installer {
		public static function install(Event $event) {
			$io = $event->getIO();
			$vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
			$projectRoot = dirname($vendorDir);
			$publicDir = $projectRoot . '/public';
			
			// Create public directory if it doesn't exist
			if (!is_dir($publicDir)) {
				mkdir($publicDir, 0755, true);
				$io->write('<info>Created public directory</info>');
			} else {
				$io->write('<comment>Public directory already exists</comment>');
			}
			
			// Copy index.php
			$indexSource = __DIR__ . '/../templates/index.php';
			$indexDest = $publicDir . '/index.php';
			
			if (!file_exists($indexDest)) {
				if (copy($indexSource, $indexDest)) {
					$io->write('<info>Copied index.php to public directory</info>');
				} else {
					$io->writeError('<error>Failed to copy index.php</error>');
				}
			} else {
				$io->write('<comment>index.php already exists, skipping</comment>');
			}
			
			// Copy .htaccess
			$htaccessSource = __DIR__ . '/../templates/.htaccess';
			$htaccessDest = $publicDir . '/.htaccess';
			
			if (!file_exists($htaccessDest)) {
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