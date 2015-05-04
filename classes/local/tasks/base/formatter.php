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

namespace tool_preserve\local\tasks\base;

defined('MOODLE_INTERNAL') || die();

abstract class formatter {
    const FORMAT_FUNC = 0;
    const FORMAT_RAW = 1;
    const FORMAT_DATE_TIME = 2;
    const FORMAT_DATE = 3;
    const FORMAT_TIME = 4;
    const FORMAT_USER = 5;
    const FORMAT_COURSE = 6;
    const FORMAT_SIZE = 7;
    const FORMAT_BOOL = 8;
    const FORMAT_HIDE = 9;

    protected $strmanager = false;

    protected $labels = array('maxbytes' => array('maxbytes', 'admin'));
    protected $formats = array('id' => self::FORMAT_RAW,
                               'contextid' => self::FORMAT_RAW,
                               'timecreated' => self::FORMAT_DATE_TIME,
                               'timemodified' => self::FORMAT_DATE_TIME,
                               'userid' => self::FORMAT_USER,
                               'courseid' => self::FORMAT_COURSE,
                               'maxbytes' => self::FORMAT_SIZE);

    public function __construct() {
        $this->strmanager = get_string_manager();
    }

    public function get_pair($label, $value) {
        if (isset($this->formats[$label]) && $this->formats[$label] === self::FORMAT_HIDE) {
            return false;
        }
        $row = new \stdClass();

        $row->label = $this->get_label($label);
        $row->value = $this->get_value($label, $value);

        return $row;
    }

    public function format_row($row) {
        $array = (array)$row;
        foreach ($array as $label => $value) {
            $array[$label] = $this->get_value($label, $value);
        }

        return (object)$array;
    }

    public function get_labels_row($row) {
        $array = (array) $row;
        $labels = new \stdClass();
        foreach ($array as $label => $value) {
            $labels->$label = $this->get_label($label);
        }

        return $labels;
    }

    public function get_value($label, $value) {
        if (!isset($this->formats[$label])) {
            return $value;
        }

        switch ($this->formats[$label]) {
            case self::FORMAT_RAW:
                return (string)$value;
                break;
            case self::FORMAT_DATE_TIME:
            case self::FORMAT_DATE:
                return userdate($value);
                break;
            case self::FORMAT_TIME:
                return format_time($value);
                break;
            case self::FORMAT_USER:
                return "##{$value}##"; // TODO!
                break;
            case self::FORMAT_COURSE:
                return "[[{$value}]]"; // TODO!
                break;
            case self::FORMAT_FUNC:
                $func = 'format_value_'.$label;
                return $this->$func($value);
                break;
            case self::FORMAT_SIZE:
                return display_size($value);
                break;
            case self::FORMAT_BOOL:
                if ($value) {
                    return $this->strmanager->get_string('yes');
                } else {
                    return $this->strmanager->get_string('no');
                }
                break;
        }

        return $value;
    }

    public function get_label($label) {
        if (!isset($this->labels[$label])) {
            return $this->get_undef_string($label);
        }

        if (is_string($this->labels[$label])) {
            return $this->labels[$label];
        }

        if (is_array($this->labels[$label])) {
            if (count($this->labels[$label]) === 1) {
                return $this->strmanager->get_string($this->labels[$label][0], '');
            } else if (count($this->labels[$label]) === 2) {
                return $this->strmanager->get_string($this->labels[$label][0], $this->labels[$label][1]);
            }
        }

        return $this->get_undef_string($label);
    }

    protected function get_undef_string($label) {
        if ($this->strmanager->string_exists($label, '')) {
            return $this->strmanager->get_string($label, '');
        }
        if ($this->strmanager->string_exists($label, 'tool_preserve')) {
            return $this->strmanager->get_string($label, 'tool_preserve');
        }
        return "**{$label}**";
    }




}
