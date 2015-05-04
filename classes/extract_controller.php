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
use \tool_preserve\local\xml;
use \tool_preserve\local\tasks;

defined('MOODLE_INTERNAL') || die();

class extract_controller {

    protected $users = false;
    protected $files = false;
    protected $inforef = false;

    protected $basepath = false;
    protected $outputpath = false;
    protected $output = false;

    const USER_TABLE = 'temp_preserve_users';
    const FILE_TABLE = 'temp_preserve_files';

    public function __construct($outputpath = false, $basepath = false) {
        global $DB;
        $this->users = new dbdata\user();
        $this->files = new dbdata\file();
        $this->inforef = new dbdata\inforef();

        $this->create_temp_tables();

        if ($basepath) {
            //$this->load_data($basepath);

            $course = new tasks\course\task($outputpath, $basepath);

            $course->execute();

            $llogs = new tasks\legacylogs\task($outputpath, $basepath);

            $llogs->execute();

        }
    }

    public function __destruct() {
        $this->drop_temp_tables();
    }

    public function load_data($basepath) {
        $this->basepath = $basepath;

        $parser = new xml\parser();

        $parser->setup($this->inforef, $basepath);
        $parser->process();

        $parser->set_processor($this->users);
        $parser->process();

        $parser->set_processor($this->files);
        $parser->process();
    }

    public function create_temp_tables() {
        $this->users->create_temp_tables();
        $this->files->create_temp_tables();
        $this->inforef->create_temp_tables();
    }

    public function drop_temp_tables() {
        $this->users->drop_temp_tables();
        $this->files->drop_temp_tables();
        $this->inforef->drop_temp_tables();
    }
}


