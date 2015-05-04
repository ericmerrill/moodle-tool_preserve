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

namespace tool_preserve\local\tasks\users;
use tool_preserve\local\tasks;

defined('MOODLE_INTERNAL') || die();

class formatter extends tasks\base\formatter {


    public function __construct() {
        parent::__construct();

        $this->labels['aim'] = array('aimid');
        $this->formats['currentlogin'] = self::FORMAT_HIDE;
        $this->formats['custom_fields'] = self::FORMAT_FUNC;
        $this->formats['descriptionformat'] = self::FORMAT_HIDE;
        $this->formats['firstaccess'] = self::FORMAT_DATE_TIME;
        $this->labels['icq'] = array('icqnumber');
        $this->formats['lastaccess'] = self::FORMAT_DATE_TIME;
        $this->formats['lastlogin'] = self::FORMAT_DATE_TIME;
        $this->labels['msn'] = array('msnid');
        $this->formats['picture'] = self::FORMAT_FUNC; //TODO.
        $this->labels['phone1'] = array('phone');
        $this->formats['preferences'] = self::FORMAT_FUNC;
        $this->labels['skype'] = array('skypeid');
        $this->formats['tags'] = self::FORMAT_FUNC;
        $this->labels['yahoo'] = array('yahooid');

    }

    protected function format_value_custom_fields($value) {
        return serialize($value); // TODO.
    }

    protected function format_value_tags($value) {
        return serialize($value); // TODO.
    }

    protected function format_value_preferences($value) {
        return serialize($value); // TODO.
    }

    protected function format_value_picture($value) {
        return serialize($value); // TODO.
    }
}
