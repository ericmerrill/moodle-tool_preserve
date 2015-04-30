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

require_once($CFG->dirroot.'/backup/util/includes/restore_includes.php');

defined('MOODLE_INTERNAL') || die();

abstract class base extends \tool_preserve\local\xml\db_processor {
    const TABLE = 'temp_preserve_data';


    public function __construct() {
        parent::__construct();
    }

    public function get_files($base) {
        return array($base.static::FILE);
    }

    public function create_temp_tables() {
        global $DB;
        $table = new \xmldb_table(static::TABLE);
        $table->add_field('id', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_field('itemname', XMLDB_TYPE_CHAR, 160, null, XMLDB_NOTNULL, null, null);
        $table->add_field('itemid', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, null, null);
        $table->add_field('info', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_key('itemname_itemid_uk', XMLDB_KEY_UNIQUE, array('itemname','itemid'));

        $dbman = $DB->get_manager();

        try {
            if (!$dbman->table_exists($table)) {
                $dbman->create_temp_table($table);
            }
        } catch (Exception $e) {
            mtrace('Temporary table creation failed: '. $e->getMessage());
            return false;
        }
    }

    public function drop_temp_tables() {
        global $DB;

        $dbman = $DB->get_manager();

        if ($dbman->table_exists(static::TABLE)) {
            try {
                $table = new \xmldb_table(static::TABLE);
                $dbman->drop_table($table);
            } catch (Exception $e) {
                mtrace("Error occured while dropping temporary tables!");
            }
        }
    }

    public static function get_record($itemname, $itemid) {
        global $DB;
        $classpath = __NAMESPACE__ . '\\' . $itemname;

        $obj = $DB->get_record($classpath::TABLE, array('itemname' => $itemname, 'itemid' => $itemid));

        if (!$obj) {
            return false;
        }

        return \backup_controller_dbops::decode_backup_temp_info($obj->info);
    }

//     public function __construct($basepath = false) {
//         if ($basepath && static::SRCFILE) {
//             $this->create_temp_tables();
//             $this->filepath = $basepath.static::SRCFILE;
//
//             if (!file($this->filepath)) {
//                 mtrace("File {$this->filepath} not found");
//             } else {
//                 $this->rawxml = simplexml_load_file($this->filepath);
//             }
//         }
//     }
//
//     public static function xml_to_object(\SimpleXMLElement $xml) {
//         $out = new \stdClass();
//
//         if (empty($xml->children())) {
//             return $xml->__toString();
//         }
//
//         foreach ($xml as $key => $value) {
//             if ($value instanceof \SimpleXMLElement) {
//                 $out->$key = self::xml_to_object($value);
//             } else {
//                 $out->$key = $value;
//             }
//         }
//
//         return $out;
//     }
//
//     protected function convert_all() {
//         if ($this->fullyloaded) {
//             return;
//         }
//         $type = static::TYPE;
//         foreach ($this->rawxml->$type as $xml) {
//             $this->get_object($xml->attributes()['id']->__toString());
//         }
//         $this->fullyloaded = true;
//     }
//
//     public function get_object($id) {
//         if (isset($this->objects[$id])) {
//             return $this->objects[$id];
//         }
//
//         $xmlobj = false;
//         $type = static::TYPE;
//         foreach ($this->rawxml->$type as $obj) {
//             if ($obj->attributes()['id'] == $id) {
//                 $xmlobj = $obj;
//                 break;
//             }
//         }
//         if (!$xmlobj) {
//             $this->objects[$id] = false;
//             return false;
//         }
//
//         $obj = static::xml_to_object($xmlobj);
//         $obj->id = $id;
//         $this->objects[$id] = $obj;
//
//         return $obj;
//     }
//
//     public function to_tab_all() {
//         // Todo header row.
//         $this->convert_all();
//         $output = '';
//         foreach ($this->objects as $id => $val) {
//             $output .= $this->to_tab_line($id);
//         }
//
//         return $output;
//     }
//
//     public function to_tab_line($id) {
//         $obj = $this->get_object($id);
//         if (!$obj) {
//             return '';
//         }
//
//         $output = '';
//         if ($this->OUTPUTLIST) {
//             foreach ($this->OUTPUTLIST as $key) {
//                 if (isset($obj->$key)) {
//                     $val = str_replace("\t", "    ", $obj->$key);
//                     $output .= $val."\t";
//                 } else {
//                     $output .= "\t";
//                 }
//             }
//         } else {
//             foreach ($obj as $value) {
//                 $output .= $value."\t";
//             }
//         }
//
//         return $output."\n";
//     }
}
