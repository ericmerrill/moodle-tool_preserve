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

namespace tool_preserve;

use \tool_preserve\local\dbdata;
use \tool_preserve\local\xmldata;

defined('MOODLE_INTERNAL') || die();

class extract_controller {

    var $users = false;

    var $basepath = false;

    public function __construct($basepath = false) {
        if ($basepath) {
            $this->basepath = $basepath;

            $this->users = new dbdata\users($basepath);

        }
    }

    public function setup_temp_tables() {
        if ($this->users) {
            $this->users->create_temp_tables();
        }
    }

    public function drop_temp_tables() {
        if ($this->users) {
            $this->users->drop_temp_tables();
        }
    }
}
