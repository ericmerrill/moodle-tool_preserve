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

class users extends base {

    const TYPE = 'user';

    const SRCFILE = '/users.xml';
    protected $table = 'temp_preserve_users';

    protected $OUTPUTLIST = array('id',
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
                                  'timemodified');

    public function __construct($basepath = false) {
        $table = new \xmldb_table($this->table);
        $table->add_field('id', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_field('oldid', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL);
        $table->add_field('username', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('idnumber', XMLDB_TYPE_CHAR, 255, null, XMLDB_NOTNULL);
        $table->add_field('email', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('middlename', XMLDB_TYPE_CHAR, 255, null, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('deleted', XMLDB_TYPE_INTEGER, 1, null, XMLDB_NOTNULL, null, '0');
        $table->add_field('firstaccess', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, null, '0');
        $table->add_field('lastaccess', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, null, '0');
        $table->add_field('lastlogin', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, null, '0');
        $table->add_field('currentlogin', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, null, '0');

        $this->tabledef = $table;

        parent::__construct($basepath);
    }

}
