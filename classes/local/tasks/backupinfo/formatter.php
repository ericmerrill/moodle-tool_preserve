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

namespace tool_preserve\local\tasks\backupinfo;
use tool_preserve\local\tasks;

defined('MOODLE_INTERNAL') || die();

class formatter extends tasks\base\formatter {
    protected $whitelist = array('name',
                                 'moodle_version',
                                 'moodle_release',
                                 'backup_version',
                                 'backup_release',
                                 'backup_date',
                                 'include_files',
                                 'original_wwwroot',
                                 'original_site_identifier_hash',
                                 'original_course_id',
                                 'original_course_fullname',
                                 'original_course_shortname',
                                 'original_course_startdate',
                                 'original_course_contextid',
                                 'original_system_contextid');

    public function __construct() {
        parent::__construct();

        $this->labels['backup_date'] = array('backupdate', 'backup');
        $this->formats['backup_date'] = self::FORMAT_DATE_TIME;
        $this->labels['backup_release'] = array('backupversion', 'backup');
        $this->labels['backup_version'] = array('backupversion', 'backup');
        //$this->labels['include_files'] = array('backupdate', 'backup');
        $this->formats['include_files'] = self::FORMAT_BOOL;
        $this->labels['moodle_release'] = array('moodleversion', 'backup');
        $this->labels['moodle_version'] = array('moodleversion', 'backup');
        $this->labels['original_course_fullname'] = array('fullname');
        $this->labels['original_course_id'] = array('id', 'tool_preserve');
        $this->labels['original_course_shortname'] = array('shortname');
        $this->labels['original_course_startdate'] = array('startdate');
        $this->formats['original_course_startdate'] = self::FORMAT_DATE_TIME;
        $this->labels['original_wwwroot'] = array('originalwwwroot', 'backup');

    }


}
