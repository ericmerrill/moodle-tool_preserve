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
use tool_preserve\local;

defined('MOODLE_INTERNAL') || die();

class task extends local\tasks\base\task {

	public function __construct($basepath = false) {
        parent::__construct($basepath);
	}

	public function execute() {

        $parser = new local\xml\parser();
        $processor = new file();


        $parser->setup($processor, $this->basepath);
        $parser->process();

        $format = new formatter();

        $rawdata = $processor->coursedata;
        $data = array();

        foreach ($rawdata as $label => $value) {
            $row = $format->get_pair($label, $value);

            $data[] = $row;
        }


        foreach ($data as $row) {
            print $row->label.': '.$row->value."<br>\n";
        }

        //print "<pre>"; print_r($rawdata); print "</pre>";
	}

	public function cleanup() {

	}

// 	protected function format_data($label, $value) {
// 	    $output = array();
// 	    $valuetype = ;
// 	    switch ($label) {
// 	        case '':
//
// 	            break;
//             case '':
//
//                 break;
//             default:
//
// 	    }
// 	}
//
// 	protected function format_value() {
//
// 	}
//
// 	protected function format_label() {
//
// 	}
}
