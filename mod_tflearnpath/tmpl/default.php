<?php
/*
* @package		TF Learn Path Module
* @version		1.3
* @license		GNU General Public License version 3
*/

//No direct access
\defined('_JEXEC') or die; 

use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use TechFry\Component\TfLearn\Administrator\Helper\CompletionHelper;
use TechFry\Component\TfLearn\Administrator\Helper\CourseHelper;
use TechFry\Component\TfLearn\Administrator\Helper\LessonHelper;

$titleClass = $params->get('module_title_class', '');
$incompleteIcon = $params->get('path_incomplete_icon', 'fa-regular fa-square');
$completeIcon   = $params->get('path_complete_icon', 'fa-solid fa-square-check');
$lockIcon       = $params->get('path_lock_icon', 'fa-solid fa-lock');
$layout         = $params->get('path_layout', 'block');
$show_ref       = (int) $params->get('path_show_ref', 0);
$courseId       = (int) $params->get('course_id', 0);

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
                    $restrict = CourseHelper::check_restrict($lesson->id, $user->id, $courseId);
                    $url      = Route::_('index.php?option=com_tflearn&view=page&course=' . $courseId . '&id=' . $lesson->id . ($lesson->lesson_type == 'multi' ? '&section=1' : ''));
                    $contents = LessonHelper::get_content($lesson->id);
                    
                    $totalPages = count($contents);
                    $link = ($totalPages || $lesson->description) ? '<a href="' . $url . '">' . htmlspecialchars($lesson->title) . '</a>' : htmlspecialchars($lesson->title);

                    $lessonOutput .= '<div class="mb-1">';
                    if ($restrict) {
                        $lessonOutput .= '<i class="' . $lockIcon . '"></i> ';
                        $lessonOutput .= '<strong>' . htmlspecialchars($lesson->title) . '</strong>';
                        $lessonOutput .= '<br><small>' . $restrict . '</small>';
                    } else {
                        $completion = $user->id ? CompletionHelper::get_completion($user->id, $lesson->id) : null;
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
                    $display = new TechFry\Library\View\Sky\Accordion($tabsContent, ['first_open' => 0]);
                    break;
                case 'tabs':
                    $display = new TechFry\Library\View\Sky\Tabs($tabsContent, ['type' => 'tabs']);
                    break;
                default:
                    $display = new TechFry\Library\View\Sky\Block($tabsContent, ['show_heading' => 1]);
                    break;
            }
            echo $display->display();
            ?>
        <?php endif; ?>
</div>
