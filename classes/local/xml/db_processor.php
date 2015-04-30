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

namespace tool_preserve\local\xml;

defined('MOODLE_INTERNAL') || die();


class db_processor extends processor {
    const INFOREF = FALSE;

    public function __construct() {
        parent::__construct(array());

    }

    protected function dispatch_chunk($data) {
        global $DB;
        // Received one user chunck, we are going to store it into backup_ids
        // table, with name = user and parentid = contextid for later use

        $obj = new \stdClass();
        $obj->itemname = static::NAME;
        $obj->itemid = $data['tags']['id'];
        $obj->info = \backup_controller_dbops::encode_backup_temp_info((object)$data['tags']);

        $inforef = static::INFOREF;
        if ($inforef) {
            $params = array('itemname' => $inforef, 'itemid' => $obj->itemid);
            if (!$DB->record_exists(\tool_preserve\local\dbdata\inforef::TABLE, $params)) {
                return;
            }
        }

        if (!$DB->record_exists(static::TABLE, array('itemname' => $obj->itemname, 'itemid' => $obj->itemid))) {
            $DB->insert_record(static::TABLE, $obj);
        }
    }

    protected function notify_path_start($path) {
        // nothing to do
    }

    protected function notify_path_end($path) {
        // nothing to do
    }

    /**
     * Provide NULL decoding
     */
    public function process_cdata($cdata) {
        if ($cdata === '$@NULL@$') {
            return null;
        }
        return $cdata;
    }
}
