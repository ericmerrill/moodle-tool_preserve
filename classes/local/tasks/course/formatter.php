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

namespace tool_preserve\local\tasks\course;
use tool_preserve\local\tasks;

defined('MOODLE_INTERNAL') || die();

class formatter extends tasks\base\formatter {


    public function __construct() {
        parent::__construct();


        $this->formats['category'] = self::FORMAT_FUNC;
        $this->formats['coursedisplay'] = self::FORMAT_FUNC;
        $this->labels['enablecompletion'] = array('enablecompletion', 'completion');
        $this->formats['enablecompletion'] = self::FORMAT_BOOL;
        $this->formats['groupmode'] = self::FORMAT_BOOL;
        $this->formats['groupmodeforce'] = self::FORMAT_BOOL;
        $this->formats['hiddensections'] = self::FORMAT_FUNC;
        $this->labels['legacyfiles'] = array('forcelanguage');
        $this->formats['hiddensections'] = self::FORMAT_FUNC;
        $this->labels['newsitems'] = array('newsitemsnumber');
        $this->labels['numsections'] = array('numberweeks');
        $this->formats['showgrades'] = self::FORMAT_BOOL;
        $this->formats['showreports'] = self::FORMAT_BOOL;
        $this->formats['startdate'] = self::FORMAT_DATE;
        $this->labels['theme'] = array('forcetheme');
        $this->formats['visible'] = self::FORMAT_BOOL;

        $this->formats['completionnotify'] = self::FORMAT_HIDE;
        $this->formats['marker'] = self::FORMAT_HIDE;
        $this->formats['requested'] = self::FORMAT_HIDE;
        $this->formats['summaryformat'] = self::FORMAT_HIDE;

    }

    protected function format_value_category($value) {
        return $value[0]['name'];
    }

    protected function format_value_hiddensections($value) {
        if ($value) {
            return get_string('hiddensectionsinvisible');
        } else {
            return get_string('hiddensectionscollapsed');
        }
    }

    protected function format_value_coursedisplay($value) {
        if ($value == COURSE_DISPLAY_SINGLEPAGE) {
            return get_string('coursedisplay_single');
        } else if ($value == COURSE_DISPLAY_MULTIPAGE) {
            return get_string('coursedisplay_multi');
        }

        return $value;
    }

    protected function format_value_legacyfiles($value) {
        if ($value == 0 || $value == 1) {
            return get_string('no');
        } else if ($value == 2) {
            return get_string('yes');
        }

        return $value;
    }
}
