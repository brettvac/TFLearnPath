# TF Learn Path Module for Joomla

![TF Learnpath logo](Tf-Learnpath.jpg)

**TF Learn Path** is a Joomla module designed to display lesson navigation for courses created using the **TF Learn** component. 

When you install and configure **TF Learn Path**, it provides a visual representation of course modules and lessons, with support for multiple layouts (block, accordion, or tabs) and access restrictions. Perfect for e-learning websites, this module helps users navigate their learning journey with ease.

## Features

- **Easily Display Lessons:** The module shows the course title, followed by sections (modules) and their lessons. Lessons are linked to their respective pages in `com_tflearn` if accessible based on the course completion requirements.
- **Multiple Layout Options:** Choose between block, accordion, or tabs layouts to match your site’s design.
- **Access Control:** Seamlessly integrates with `com_tflearn` to check user access to the lesson. If a user hasn't completed the previous lesson, restricted lessons show a lock icon and message.
- **Customizable Styling:** Easily add CSS classes for the module title and/or layout elements such as icons for completed/incomplete lessons.

## Requirements

- **TF Learn Component:** You should have already installed [TF Learn](https://joomlafry.com/joomla-extensions/learn-joomla-extension) and added some courses, modules and lessons, otherwise I'm not sure why you want to install this module.
- **TF Library:** Requires the [Tech Fry Library](https://labs.joomlafry.com/downloads/techfry.zip) to work.

## Installation

1. **Download or install the Module with this URL**
   - Install via Joomla’s Extension Manager (`Extensions > Manage > Install`) the latest release from this link: [https://github.com/brettvac/TFLearnpath/releases/latest/download/mod_tflearnpath.zip](https://github.com/brettvac/TFLearnpath/releases/latest/download/mod_tflearnpath.zip).
   - The module will check for the TechFry Library during installation and prompt you if it’s missing.

2. **Enable the Module:**
   - Go to `Extensions > Modules`.
   - Search for "TF Learnpath" and click to edit.
   - Add your course to display and desired layout.
   - Set the status to "Published" 
   - Assign the module to the desired position and menu items.

## Module Parameters

- **Course ID (`course_id`):** Specify the ID of the `com_tflearn` course to display (e.g., `2`).
- **Layout (`path_layout`):** Choose the display style:
  - `block`: Simple stacked layout.
  - `accordion`: Collapsible sections (defaults to all closed).
  - `tabs`: Tabbed navigation.
- **Lesson Order (`lessons_order_col`, `lessons_order_dirn`):** Sort lessons by a field (e.g., `ordering`, `title`) in ascending (`ASC`) or descending (`DESC`) order.
- **Module Title Class (`module_title_class`):** Add a CSS class for the course title (e.g., `text-center`).
- **Icons (`path_incomplete_icon`, `path_complete_icon`, `path_lock_icon`):** Customize Font Awesome icons for lesson states (e.g., `fa-regular fa-square` for incomplete).

### Example Setup

1. Create a course in `com_tflearn` with modules and lessons.
2. In the TF Learnpath module settings:
   - Set `Course ID` to your course’s ID.
   - Choose `accordion` layout.
   - Assign the module to a position (e.g., `sidebar-right`) and a menu item.
3. Save and view the frontend—your learning path will display with collapsible sections.

## Contributions
The code to display the lessons is directly copied from the [TF Learn](https://joomlafry.com/joomla-extensions/learn-joomla-extension) component (the best LMS for Joomla!)

## FAQ

**Q: Can I use Podia instead of TF Learn to host my courses?**  
**A:** I guess so! I've never used that platform.  

**Q:  Can I use TF Learn(path) with Joomla! 4?**
**A:** No, TF Learn only works with Joomla! versions 5 and later, so the latest release only works with Joomla! 5 and up. 

**Q: This plugin is awesome! Can I send a donation?**  
**A:** Sure! Send your cryptonation to the following wallets:

`BTC 1PXWZJcBfehqgV25zWdVDS6RF2yVMxFkZD`

`Eth 0xC9b695D4712645Ba178B4316154621B284e2783D`
