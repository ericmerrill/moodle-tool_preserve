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
 * Tool to "preserve" data in a human readable format.
 *
 * @package    tool_preserve
 * @author     Eric Merrill <merrill@oakland.edu>
 * @copyright  2015 Oakland University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true);

require('../../../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('toolpreserve');

$go = optional_param('go', 0, PARAM_BOOL);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('pluginname', 'tool_preserve'));


echo $OUTPUT->box_start();


$controller = new \tool_preserve\extract_controller('/Users/merrill/ex/input');

// $controller->setup_temp_tables();
// $controller->drop_temp_tables();



echo $OUTPUT->box_end();


//echo $OUTPUT->notification('Rebuilding course cache...', 'notifysuccess');

//echo $OUTPUT->continue_button(new moodle_url('/admin/'));

echo $OUTPUT->footer();

