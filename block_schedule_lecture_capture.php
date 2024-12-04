<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Scheduling lecture captures block for teachers.
 *
 * @package    block_schedule_lecture_capture
 * @copyright  2024 onwards Pasi Häkkinen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_schedule_lecture_capture extends block_base {
    function init() {
        $this->title = get_string('pluginname','block_schedule_lecture_capture');
    }

    function has_config() {
        return true;
    }

    function get_content() {
        global $USER, $CFG, $DB, $OUTPUT, $COURSE, $PAGE;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        if (!isset($CFG->block_schedule_lecture_capture_baseurl)) {
            return $this->content;
        }

        // Verify if we can see the block. If not, return null (no block).
        if (!has_capability('block/schedule_lecture_capture:viewblock', $this->page->context)) {
            return null;
        }
        
        // Check if course identifier exists in course settings and it starts with string 'otm-'
        if ($COURSE->idnumber != '' && substr($COURSE->idnumber, 0, 4) === 'otm-') {
            // language parameter for the link
            $lang = (current_language() == 'fi') ? 'fi' : 'en';
            // the link
            $this->content->text = '<div class="info"><a href="'.$CFG->block_schedule_lecture_capture_baseurl . $COURSE->idnumber.'?lang='. $lang .'" target="_blank">'. get_string('schedule_recordings_of_your_lectures', 'block_schedule_lecture_capture') .'</a>';

            if ($CFG->block_schedule_lecture_capture_checkpanoptoblock) {
                // Check if Panopto block exists.
                $panopto_block_found = false;
                $blockmanager = $PAGE->blocks;
                $blockmanager->load_blocks(true);
                foreach ($blockmanager->get_regions() as $region) {
                    foreach ($blockmanager->get_blocks_for_region($region) as $block) {
                        // check block name
                        if ($block->name() == 'panopto') {
                           $panopto_block_found = true;
                        }
                    }
                }
                
                if ($panopto_block_found) {
                    $this->content->text .= '<p>'. get_string('click_provision_link_if_shown', 'block_schedule_lecture_capture') . '</p>';
                } else {
                    $this->content->text .= '<p>'. get_string('panopto_block_recommended', 'block_schedule_lecture_capture') . '</p>';
                }
            }
            $this->content->footer .= '</div>';

        } else {
            $this->content->text = '<div class="info">'. get_string('sisu_course_needed', 'block_schedule_lecture_capture') . '</div>';
        }
        // Optional notification text
        $format = FORMAT_HTML;
        if (!empty($CFG->block_schedule_lecture_capture_notificationtext)) {
            $this->content->footer = format_text($CFG->block_schedule_lecture_capture_notificationtext, $format);
        }

        
        return $this->content;
    }

    /**
     * Defines in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats() {
        return [
            'admin' => false,
            'site-index' => false,
            'course-view' => true,
            'mod' => false,
            'my' => false,
        ];
    }

}


