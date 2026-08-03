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
 * Upgrade-Schritte fuer tiny_textgestaltung.
 *
 * @package    tiny_textgestaltung
 * @copyright  2026 Moodle in Niedersachsen e. V.
 * @author     Moodle in Niedersachsen e. V.
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Fuehrt die Upgrade-Schritte aus.
 *
 * @param int $oldversion Bisher installierte Version
 * @return bool
 */
function xmldb_tiny_textgestaltung_upgrade($oldversion): bool {

    if ($oldversion < 2026073005) {
        // Fruehe Builds lieferten eine 5er-Schriftliste als Standard aus,
        // die bei der Installation gespeichert wurde. Steht im Feld noch
        // exakt dieser alte, unveraenderte Standard, wird er auf den
        // aktuellen vollstaendigen Standard angehoben. Von Administratoren
        // angepasste Listen bleiben unangetastet.
        $olddefault = "Arial=Arial, sans-serif\n" .
            "Times New Roman=\"Times New Roman\", serif\n" .
            "Verdana=Verdana, sans-serif\n" .
            "Georgia=Georgia, serif\n" .
            "Courier New=\"Courier New\", monospace";

        $current = get_config('tiny_textgestaltung', 'fontlist');
        if ($current !== false) {
            // Zeilenenden normalisieren (Textareas liefern ggf. \r\n).
            $normalised = trim(str_replace("\r\n", "\n", $current));
            if ($normalised === $olddefault) {
                set_config('fontlist',
                    \tiny_textgestaltung\plugininfo::get_default_fontlist(),
                    'tiny_textgestaltung');
            }
        }

        upgrade_plugin_savepoint(true, 2026073005, 'tiny', 'textgestaltung');
    }

    return true;
}
