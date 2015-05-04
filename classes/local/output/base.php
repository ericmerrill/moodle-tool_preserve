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

abstract class base {
    protected $filepath = false;

    protected $fh = false;

    const PLAINTEXT = true;

    public function __construct($file) {
        $this->filepath = $file;
    }

    public function output_rows($data) {
        foreach ($data as $row) {
            $this->output_row($row);
        }
    }

    public function output_row($row) {
        if (!$this->fh) {
            $this->open_file();
        }

        $info = $this->format_row($row);
        print $info;
        if (static::PLAINTEXT) {
            print "<br>";
        }
        fwrite($this->fh, $info);
    }

    public function open_file() {
        print "<br><hr><b>Opening file: {$this->filepath}:</b><br>";

        if(!($this->fh = @fopen($this->filepath, 'w'))) {
            print_error("Failed to open file: {$this->filepath}");
        }
    }

    public function close_file() {
        if ($this->fh) {
            fclose($this->fh);
            $this->fh = false;
        }
    }

    protected abstract function format_row($row);

}
