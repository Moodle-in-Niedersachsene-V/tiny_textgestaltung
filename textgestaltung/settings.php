<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Einstellungen fuer tiny_textgestaltung.
 *
 * @package    tiny_textgestaltung
 * @copyright  2026 Moodle in Niedersachsen e. V.
 * @author     Moodle in Niedersachsen e. V.
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtextarea(
        'tiny_textgestaltung/fontlist',
        get_string('fontlist', 'tiny_textgestaltung'),
        get_string('fontlist_desc', 'tiny_textgestaltung'),
        \tiny_textgestaltung\plugininfo::get_default_fontlist(),
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configtextarea(
        'tiny_textgestaltung/fontsizelist',
        get_string('fontsizelist', 'tiny_textgestaltung'),
        get_string('fontsizelist_desc', 'tiny_textgestaltung'),
        \tiny_textgestaltung\plugininfo::get_default_fontsizes(),
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configtextarea(
        'tiny_textgestaltung/colorlist',
        get_string('colorlist', 'tiny_textgestaltung'),
        get_string('colorlist_desc', 'tiny_textgestaltung'),
        \tiny_textgestaltung\plugininfo::get_default_colorlist(),
        PARAM_RAW
    ));
}
