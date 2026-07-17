<?php
/*
* @package		TF Learn Path Module
* @version		1.5
* @license		GNU General Public License version 3
*/

namespace Naftee\Module\Tflearnpath\Site\Helper;

\defined('_JEXEC') or die;

use TechFry\Library\TDb;
// 1. Changed from CourseHelper and LessonHelper to Course and Lesson
use TechFry\Component\TfLearn\Administrator\Helper\Lesson;
use TechFry\Component\TfLearn\Administrator\Helper\Course;

class TflearnpathHelper
{
    public static function getCoursePath($courseId, $user)
    {
        // Fetch the course from the database
        $db = new TDb('tfl_courses');
        $course = $db->get_item(['id' => $courseId]);
       
        // Instantiate the Course object with the user and course ID
        $courseObj = new Course([
            'course_id' => $courseId, 
            'user_id' => $user->id
        ]);
       
        // Call the instance method
        if (!$course || !$courseObj->is_enrolled()) {
            return null;
        }
        
        $modules = json_decode($course->modules, true) ?: []; 
        $path = [];
        $i = 0;
        
        foreach ($modules as $module) {
            $moduleId = $module['module_id']; 
           
            // Fetch module details from the database using the module ID
            $db_mod = new TDb('tfl_modules');
            $mod = $db_mod->get_item(['id' => $moduleId]);
           
            if ($mod && $mod->published) {
                $mod->title = $module['module_name'] ?: $mod->title;
                
                // Instantiate the Lesson object with the required config
                $lessonObj = new Lesson(['module_id' => $moduleId]);
                
                // Call the instance method
                $lessons = $lessonObj->get_lessons(1);

                $path[$i] = [ 
                    htmlspecialchars($mod->title),
                    $lessons ?: [] 
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