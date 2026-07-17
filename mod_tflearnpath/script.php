<?php
/*
* @package    TF Learnpath Module
* @version    1.5
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

\defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\LibraryHelper;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;

return new class () implements InstallerScriptInterface
{
  
    private string $minimumJoomla = '5.0.0';
    private string $minimumPhp    = '8.1.0';
  
    public function install(InstallerAdapter $adapter): bool {
        Factory::getApplication()->enqueueMessage(Text::_('MOD_TFLEARNPATH_INSTALL'),'success');
        return true;
    }

    public function update(InstallerAdapter $adapter): bool{
        Factory::getApplication()->enqueueMessage(Text::_('MOD_TFLEARNPATH_UPDATE'), 'success');
        return true;
    }

    public function uninstall(InstallerAdapter $adapter): bool {
        Factory::getApplication()->enqueueMessage(Text::_('MOD_TFLEARNPATH_UNINSTALL'), 'info');
        return true;
    }
    
    public function preflight(string $type, InstallerAdapter $adapter): bool
    {
      
        if (version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
            Factory::getApplication()->enqueueMessage(sprintf(Text::_('JLIB_INSTALLER_MINIMUM_PHP'), $this->minimumPhp), 'error');
            return false;
        }

        if (version_compare(JVERSION, $this->minimumJoomla, '<')) {
            Factory::getApplication()->enqueueMessage(sprintf(Text::_('JLIB_INSTALLER_MINIMUM_JOOMLA'), $this->minimumJoomla), 'error');
            return false;
        }

        if (!LibraryHelper::isEnabled('techfry')) {
            $message = '<strong><p>Please download and install TF Library before installing ' . $adapter->element . '</p></strong>';
            $message .= '<a class="btn btn-success" href="https://labs.joomlafry.com/downloads/techfry.zip" download>';
            $message .= '<i class="fas fa-download"></i> Download TF Library!</a>';
            Factory::getApplication()->enqueueMessage($message);
            return false;
        }

        return true;
    }

    public function postflight(string $type, InstallerAdapter $adapter): bool {
        Factory::getApplication()->enqueueMessage(Text::_('MOD_TFLEARNPATH_POSTFLIGHT'), 'info');
        return true;
    }
};