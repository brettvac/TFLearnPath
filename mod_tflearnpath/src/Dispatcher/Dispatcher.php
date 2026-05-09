<?php
/*
* @package    TF Learn Path Module
* @version    1.3
* @license    GNU General Public License version 3
*/

namespace Naftee\Module\Tflearnpath\Site\Dispatcher;

//No direct access
\defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;

class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
    {
    use HelperFactoryAwareTrait;

    /**
     * Returns the layout data.
     *
     * @return  array|false
     */
    protected function getLayoutData()
        {       
        // Get base data (module, app, input, params and template)
        $data = parent::getLayoutData();

        // The parent getLayoutData() puts the module's Registry object into $data['params']
        $params = $data['params'];
        
        // Get the course ID for the path we want to display
        $courseId = (int) $params->get('course_id', 0);
               
        if (!$courseId) {
           return false;
        }

        //Get the user ID for course access check
        $user = $this->app->getIdentity();
        
        // Fetch path for the course using the method inside the helper
        $path = $this->getHelperFactory()->getHelper('TflearnpathHelper')->getCoursePath($courseId, $user);  

        if ($path === null) 
            {
            return false;  //Helper failed to return an array for the course
            }
        
        // Inject variables into the data array for the tmpl
        $data['course_id'] = $courseId;
        $data['user']      = $user;
        $data['path']      = $path;
        
        return $data;
 
        }
    }