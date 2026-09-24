<?php
/*
* @package        TF Learn Path Module
* @version        1.6
* @license        GNU General Public License version 3
*/

//No direct access
\defined('_JEXEC') or die; 

use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

// TF Learn Component: admin/src/Helper/Completion.php
use TechFry\Component\TfLearn\Administrator\Helper\Completion;

// TF Learn Component: admin/src/Helper/Course.php
use TechFry\Component\TfLearn\Administrator\Helper\Course;

// TF Learn Component: admin/src/Helper/Lesson.php
use TechFry\Component\TfLearn\Administrator\Helper\Lesson;

// TF Learn Component: admin/src/Helper/Restriction.php
use TechFry\Component\TfLearn\Administrator\Helper\Restriction;

// TF Learn Library: src/View/Sky/Accordion.php
use TechFry\Library\View\Sky\Accordion;

// TF Learn Library: src/View/Sky/Tabs.php
use TechFry\Library\View\Sky\Tabs;

// TF Learn Library: src/View/Sky/Block.php
use TechFry\Library\View\Sky\Block;

$titleClass     = $params->get('module_title_class', '');
$incompleteIcon = $params->get('path_incomplete_icon', 'fa-regular fa-square');
$completeIcon   = $params->get('path_complete_icon', 'fa-solid fa-square-check');
$lockIcon       = $params->get('path_lock_icon', 'fa-solid fa-lock');
$layout         = $params->get('path_layout', 'block');
$show_ref       = (int) $params->get('path_show_ref', 0);
$courseId       = (int) $params->get('course_id', 0);

// Retrieve the configured Menu Item ID and prepare the string
$pathsItemId    = (int) $params->get('paths_itemid', 0);
$itemidString   = $pathsItemId ? '&Itemid=' . $pathsItemId : '';

?>
<div class="tflearn-path">
    <?php
    echo '<h2' . ($titleClass ? ' class="' . $titleClass . '"' : '') . '>' . htmlspecialchars($path['course']->title) . '</h2>';
    ?>
        <?php if (!empty($path['tabs'])) : ?>
            <?php
            $tabsContent    = [];

            foreach ($path['tabs'] as $tab) {
                $moduleTitle = $tab[0];
                $lessons     = $tab[1];
                $lessonOutput = '';

                foreach ($lessons as $lesson) {
                    
                    // Instantiate Restriction class and call check_restriction()
                    $restrictionObj = new Restriction([
                        'course_id' => $courseId,
                        'lesson_id' => $lesson->id,
                        'user_id'   => $user->id
                    ]);
                    $restrict = $restrictionObj->check_restriction();
                    
                    // Append the dynamic Itemid string to the Route
                    $url      = Route::_('index.php?option=com_tflearn&view=page&course=' . $courseId . '&id=' . $lesson->id . ($lesson->lesson_type == 'multi' ? '&section=1' : '') . $itemidString);
                    
                    // Instantiate the Lesson object with lesson_id
                    $lessonObj = new Lesson(['lesson_id' => $lesson->id]);
                    $contents = $lessonObj->get_content();
                    
                    $totalPages = count($contents);
                    $link = ($totalPages || $lesson->description) ? '<a href="' . $url . '">' . htmlspecialchars($lesson->title) . '</a>' : htmlspecialchars($lesson->title);

                    $lessonOutput .= '<div class="mb-1">';
                    if ($restrict) {
                        $lessonOutput .= '<i class="' . $lockIcon . '"></i> ';
                        $lessonOutput .= '<strong>' . htmlspecialchars($lesson->title) . '</strong>';
                        $lessonOutput .= '<br><small>' . $restrict . '</small>';
                    } else {
                        // Instantiate Completion class and call instance method get_completion()
                        $completionObj = new Completion([
                            'user_id'   => $user->id, 
                            'lesson_id' => $lesson->id
                        ]);
                        
                        $completion = $user->id ? $completionObj->get_completion() : null;
                        $lessonIcon = $completion ? $completeIcon : $incompleteIcon;
                        
                        $lessonOutput .= '<i class="' . $lessonIcon . '"></i> ';
                       $lessonOutput .= '<strong>' . (($show_ref && $lesson->ref) ? $lesson->ref . '. ' : '') . $link . '</strong>';
                    }
                    $lessonOutput .= '</div>';
                }
                $tabsContent[] = [$moduleTitle, $lessonOutput];
            }

            switch ($layout) {
                case 'accordion':
                    $display = new Accordion($tabsContent, ['first_open' => 0]);
                    break;

                case 'tabs':
                    $display = new Tabs($tabsContent, ['type' => 'tabs']);
                    break;

                default:
                    $display = new Block($tabsContent, ['show_heading' => 1]);
                    break;
            }
            echo $display->display();
            ?>
        <?php endif; ?>
</div>