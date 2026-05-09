<?php
/*
* @package		TF Learn Path Module
* @version		1.3
* @license		GNU General Public License version 3
*/

namespace Naftee\Module\Tflearnpath\Site\Helper;

\defined('_JEXEC') or die;

use TechFry\Library\TDb;
use TechFry\Component\TfLearn\Administrator\Helper\LessonHelper;
use TechFry\Component\TfLearn\Administrator\Helper\CourseHelper;

class TflearnpathHelper
{
    public static function getCoursePath($courseId, $user)
    {
      
        //Fetch the course from the database
        $db = new TDb('tfl_courses');
        $course = $db->get_item(['id' => $courseId]);
       
        // Check for access using CourseHelper::is_enrolled
        if (!$course || !CourseHelper::is_enrolled($courseId, $user->id)) {
            return null;
        }
        $modules = json_decode($course->modules, true) ?: []; //Extract the modules from JSON data
        $path = [];
        $i = 0;
        foreach ($modules as $module) {
            $moduleId = $module['module_id']; //Extract the module ID from the $module array
           
            // Fetch module details from the database using the module ID
            $db_mod = new TDb('tfl_modules');
            $mod = $db_mod->get_item(['id' => $moduleId]);
           
            if ($mod && $mod->published) {
                $mod->title = $module['module_name'] ?: $mod->title;
                $lessons = LessonHelper::get_lessons($moduleId, 1);

                $path[$i] = [ //Build an array entry for each module’s title and lessons
                    htmlspecialchars($mod->title),
                    $lessons ?: [] // Use lessons if available, otherwise an empty array
                ];
                $i++;
            }
        }
        return [
            'course' => $course,
            'tabs' => $path
        ];
    }
}