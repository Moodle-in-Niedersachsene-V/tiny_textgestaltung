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
 * Optionen fuer tiny_textgestaltung.
 *
 * @module      tiny_textgestaltung/options
 * @copyright   2026 Moodle in Niedersachsen e. V.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {getPluginOptionName} from 'editor_tiny/options';
import common from './common';

const {pluginName} = common;
const fontsName = getPluginOptionName(pluginName, 'fonts');

/**
 * Registriert die Optionen dieses Plugins am Editor.
 *
 * @param {tinyMCE.Editor} editor
 */
export const register = (editor) => {
    // Wichtig: direkt an editor.options aufrufen, damit "this" erhalten bleibt.
    editor.options.register(fontsName, {
        processor: 'array',
        "default": [],
    });
};

/**
 * Liefert die konfigurierte Schriftliste.
 *
 * @param {tinyMCE.Editor} editor
 * @returns {Array<{text: string, value: string}>}
 */
export const getFonts = (editor) => editor.options.get(fontsName);
