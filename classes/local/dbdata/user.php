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

namespace tool_preserve\local\dbdata;

defined('MOODLE_INTERNAL') || die();

class user extends base {
    const NAME = 'user';
    const FILE = 'users.xml';
    const INFOREF = 'userref';

    public function __construct() {
        parent::__construct();

        $this->add_path('/users/user', true);
        $this->add_path('/users/user/custom_fields/custom_field');
        $this->add_path('/users/user/tags/tag');
        $this->add_path('/users/user/preferences/preference');


    }

    //protected $table = 'temp_preserve_users';

    /*protected $OUTPUTLIST = array('id',
                                  'username',
                                  'idnumber',
                                  'email',
                                  'firstname',
                                  'middlename',
                                  'lastname',
                                  'deleted',
                                  'firstaccess',
                                  'lastaccess',
                                  'lastlogin',
                                  'currentlogin',
                                  'timecreated',
                                  'timemodified');*/

    /*public function __construct($basepath = false) {
        parent::__construct($basepath);
    }*/


}
