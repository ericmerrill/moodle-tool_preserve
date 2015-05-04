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

namespace tool_preserve\local\tasks\legacylogs;

use tool_preserve\local\tasks;

defined('MOODLE_INTERNAL') || die();

class file extends tasks\base\file {
    const FILE = 'course/logs.xml';
    const XMLPATH = '/logs/log';

    private $firstrow = true;

    protected function dispatch_chunk($data) {
        if ($this->output) {
            if ($this->firstrow) {
                $labels = $this->formatter->get_labels_row($data['tags']);
                $this->firstrow = false;
                $this->output->set_fields($labels);
                $this->output->output_labels();
            }

            $row = $this->formatter->format_row($data['tags']);
            $this->output->output_row($row);
        }
    }

}
