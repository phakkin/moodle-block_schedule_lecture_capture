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
 * Scheduling lecture captures block settings.
 *
 * @package    block_schedule_lecture_capture
 * @copyright  2024 onwards Pasi Häkkinen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('block_schedule_lecture_capture_baseurl', get_string('baseurl', 'block_schedule_lecture_capture'),
                   get_string('baseurl_desc', 'block_schedule_lecture_capture'), '', PARAM_URL, 80));
    $settings->add(new admin_setting_configtext('block_schedule_lecture_capture_notificationtext', get_string('notificationtext', 'block_schedule_lecture_capture'),
                   get_string('notificationtext_desc', 'block_schedule_lecture_capture'), '', PARAM_TEXT, 80));
    $settings->add(new admin_setting_configcheckbox('block_schedule_lecture_capture_checkpanoptoblock', get_string('checkpanoptoblock', 'block_schedule_lecture_capture'),
                       get_string('checkpanoptoblock_desc', 'block_schedule_lecture_capture'), 0));
}
