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

abstract class base extends \tool_preserve\local\xmldata\base {
    protected $tabledef = false;
    protected $table = false;


    public function __construct($basepath = false) {
        parent::__construct($basepath);

        if ($basepath) {
            $this->load_to_db();
        }
    }

    public function load_to_db() {
        global $DB;

        if (!$this->rawxml) {
            return false;
        }

        $type = static::TYPE;
        foreach ($this->rawxml->$type as $xml) {
            // Need to use the parent XML get_object();
            $obj = parent::get_object($xml->attributes()['id']->__toString());
            $obj->oldid = $obj->id;
            unset($obj->id);

            $DB->insert_record($this->table, $obj);
        }
    }

    protected static function fix_old_id($obj) {
        if ($obj) {
            $obj->id = $obj->oldid;
        }
        return $obj;
    }

    public function get_object($id) {
        global $DB;

        $obj = $DB->get_record($this->table, array('oldid' => $id));

        return self::fix_old_id($obj);
    }

    public function to_tab_all() {
        global $DB;

        $output = '';
        $rs = $DB->get_recordset($this->table);
        foreach ($rs as $record) {
            $output .= $this->object_to_tab(self::fix_old_id($record));
        }
        $rs->close();

        return $output;
    }

    protected function object_to_tab($obj) {
        $output = '';
        if ($this->OUTPUTLIST) {
            foreach ($this->OUTPUTLIST as $key) {
                if (isset($obj->$key)) {
                    $val = str_replace("\t", "    ", $obj->$key);
                    $output .= $val."\t";
                } else {
                    $output .= "\t";
                }
            }
        } else {
            foreach ($obj as $value) {
                $output .= $value."\t";
            }
        }

        return $output."\n";
    }

    public function to_tab_line($id) {
        $obj = $this->get_object($id);
        if (!$obj) {
            return '';
        }

        return $this->object_to_tab($obj);
    }

    public function create_temp_tables() {
        global $DB;
        if (!$this->tabledef) {
            return true;
        }

        $dbman = $DB->get_manager();

        try {
            if ($this->tabledef) {
                if (!$dbman->table_exists($this->tabledef)) {
                    $dbman->create_temp_table($this->tabledef);
                }
            }
        } catch (Exception $e) {
            mtrace('Temporary table creation failed: '. $e->getMessage());
            return false;
        }
    }

    public function drop_temp_tables() {
        global $DB;
        if (!$this->tabledef) {
            return true;
        }

        $dbman = $DB->get_manager();

        if ($this->tabledef) {
            if ($dbman->table_exists($this->tabledef)) {
                try {
                    $dbman->drop_table($this->tabledef);
                } catch (Exception $e) {
                    mtrace("Error occured while dropping temporary tables!");
                }
            }
        }
    }
}
