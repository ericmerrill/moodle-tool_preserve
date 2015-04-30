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

class inforef extends base {
    const NAME = 'inforef';
    const FILE = 'inforef.xml';

    public function __construct() {
        parent::__construct();

        // Get itemnames handled by inforef files
        $items = \backup_helper::get_inforef_itemnames();
        // Let's add all them as target paths for the processor
        foreach($items as $itemname) {
            $pathvalue = '/inforef/' . $itemname . 'ref/' . $itemname;
            $this->add_path($pathvalue, true);
        }
    }

    public function get_files($base) {
        $allfiles = get_directory_list($base);
        $filename = static::FILE;
        $files = array();

        foreach ($allfiles as $file) {
            if (strlen($file) >= strlen($filename)) {
                if (substr_compare($file, $filename, strlen($file)-strlen($filename), strlen($filename)) === 0) {
                    $files[] = $base.$file;
                }
            }
        }

        return $files;
    }

    protected function dispatch_chunk($data) {
        global $DB;
        // Received one user chunck, we are going to store it into backup_ids
        // table, with name = user and parentid = contextid for later use

        $obj = new \stdClass();
        $obj->itemname = explode('/', $data['path'], 4)[2];
        $obj->itemid = $data['tags']['id'];
        $obj->info = \backup_controller_dbops::encode_backup_temp_info((object)$data['tags']);

        if (!$DB->record_exists(static::TABLE, array('itemname' => $obj->itemname, 'itemid' => $obj->itemid))) {
            $DB->insert_record(static::TABLE, $obj);
        }
    }


}
