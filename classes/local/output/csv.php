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

namespace tool_preserve\local\output;

defined('MOODLE_INTERNAL') || die();

class csv extends base {

    protected $fields = false;

    protected function format_row($row) {
        if(is_object($row)) {
            $fields = array_keys(get_object_vars($row));
        }
        else if(is_array($row)) {
            $fields = array_keys($row);
        }

        $array  = (array)$row;
        $values = array();
        foreach($fields as $field) {
            if(strpos($array[$field], ',')) {
                $values[] = '"'.str_replace('"', '\"', $array[$field]).'"';
            }
            else {
                $values[] = $array[$field];
            }
        }


        //TODO formatting.
        return implode(',', $values)."\r\n";
    }

    public function set_fields($fields) {
        $this->fields = (object)$fields;
    }

    public function output_labels() {
        if ($this->fields) {
            $this->output_row($this->fields);
        }
    }
}
