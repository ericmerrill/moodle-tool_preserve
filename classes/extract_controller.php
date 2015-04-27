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

defined('MOODLE_INTERNAL') || die();

class extract_controller {

    protected $users = false;
    protected $files = false;

    protected $basepath = false;

    const USER_TABLE = 'temp_preserve_users';
    const FILE_TABLE = 'temp_preserve_files';

    public function __construct($basepath = false) {
        global $DB;
        if ($basepath) {
            $this->users = new dbdata\user();
            $this->users->create_temp_tables();

            $this->files = new dbdata\file();
            $this->files->create_temp_tables();

            $parser = new xml\parser();

            $parser->setup($this->users, $basepath);
            $parser->process();

            $users = $this->users;
            echo $DB->count_records($users::TABLE);

            $parser->set_processor($this->files);
            $parser->process();

            $files = $this->files;
            echo $DB->count_records($files::TABLE);


            print_r(dbdata\base::get_record('file', 65519));

            $this->drop_temp_tables();
        }
    }

    public function create_temp_tables() {

    }

    public function drop_temp_tables() {
        $this->users->drop_temp_tables();
        $this->files->drop_temp_tables();
    }
}


