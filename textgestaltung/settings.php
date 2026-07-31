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

    $settings->add(new admin_setting_configcheckbox(
        'tiny_textgestaltung/textcolorenabled',
        get_string('textcolorenabled', 'tiny_textgestaltung'),
        get_string('textcolorenabled_desc', 'tiny_textgestaltung'),
        1
    ));

    $settings->add(new admin_setting_configtextarea(
        'tiny_textgestaltung/textcolorlist',
        get_string('textcolorlist', 'tiny_textgestaltung'),
        get_string('textcolorlist_desc', 'tiny_textgestaltung'),
        \tiny_textgestaltung\plugininfo::get_default_colorlist(),
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configcheckbox(
        'tiny_textgestaltung/backgroundcolorenabled',
        get_string('backgroundcolorenabled', 'tiny_textgestaltung'),
        get_string('backgroundcolorenabled_desc', 'tiny_textgestaltung'),
        1
    ));

    $settings->add(new admin_setting_configtextarea(
        'tiny_textgestaltung/backgroundcolorlist',
        get_string('backgroundcolorlist', 'tiny_textgestaltung'),
        get_string('backgroundcolorlist_desc', 'tiny_textgestaltung'),
        \tiny_textgestaltung\plugininfo::get_default_colorlist(),
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configcheckbox(
        'tiny_textgestaltung/usefortable',
        get_string('usefortable', 'tiny_textgestaltung'),
        get_string('usefortable_desc', 'tiny_textgestaltung'),
        1
    ));
}
