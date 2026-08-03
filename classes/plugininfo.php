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
 * Plugin-Info fuer tiny_textgestaltung.
 *
 * @package    tiny_textgestaltung
 * @copyright  2026 Moodle in Niedersachsen e. V.
 * @author     Moodle in Niedersachsen e. V.
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_textgestaltung;

use context;
use editor_tiny\editor;
use editor_tiny\plugin;
use editor_tiny\plugin_with_buttons;
use editor_tiny\plugin_with_configuration;
use editor_tiny\plugin_with_menuitems;

/**
 * Bindet Schriftart, Schriftgroesse und Schriftfarben in den Tiny-Editor ein.
 */
class plugininfo extends plugin implements
        plugin_with_buttons,
        plugin_with_menuitems,
        plugin_with_configuration {

    /**
     * Standardliste web-sicherer Schriftarten (Anzeigename=CSS-Wert je Zeile).
     *
     * @return string
     */
    public static function get_default_fontlist(): string {
        return "Arial=Arial, sans-serif\n" .
               "Verdana=Verdana, sans-serif\n" .
               "Tahoma=Tahoma, sans-serif\n" .
               "Trebuchet MS=\"Trebuchet MS\", sans-serif\n" .
               "Times New Roman=\"Times New Roman\", serif\n" .
               "Georgia=Georgia, serif\n" .
               "Garamond=Garamond, serif\n" .
               "Courier New=\"Courier New\", monospace\n" .
               "Brush Script MT=\"Brush Script MT\", cursive";
    }

    /**
     * Standardliste der Schriftgroessen (Leerzeichen-getrennt).
     *
     * @return string
     */
    public static function get_default_fontsizes(): string {
        return '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt';
    }

    /**
     * Standard-Farbpalette (Anzeigename=Hexcode je Zeile).
     *
     * @return string
     */
    public static function get_default_colorlist(): string {
        return "Schwarz=#000000\n" .
               "Dunkelgrau=#595959\n" .
               "Rot=#C00000\n" .
               "Orange=#E97132\n" .
               "Gelb=#FFC000\n" .
               "Gruen=#00B050\n" .
               "Blau=#0070C0\n" .
               "Dunkelblau=#002060\n" .
               "Violett=#7030A0\n" .
               "Weiss=#FFFFFF";
    }

    /**
     * Verfuegbare Buttons dieses Plugins.
     *
     * @return string[]
     */
    public static function get_available_buttons(): array {
        return [
            'tiny_textgestaltung/schriftart',
        ];
    }

    /**
     * Verfuegbare Menueeintraege dieses Plugins.
     *
     * @return string[]
     */
    public static function get_available_menuitems(): array {
        return [
            'tiny_textgestaltung/schriftart',
        ];
    }

    /**
     * Uebergibt die Konfiguration an das JavaScript.
     *
     * @param context $context
     * @param array $options
     * @param array $fpoptions
     * @param editor|null $editor
     * @return array
     */
    public static function get_plugin_configuration_for_context(
        context $context,
        array $options,
        array $fpoptions,
        ?editor $editor = null
    ): array {
        return [
            'fonts' => self::get_fonts(),
            'fontsizes' => self::get_fontsizes(),
            'textcolors' => self::get_colormap('textcolorlist'),
            'backgroundcolors' => self::get_colormap('backgroundcolorlist'),
            'textcolorenabled' => (bool) get_config('tiny_textgestaltung', 'textcolorenabled'),
            'backgroundcolorenabled' => (bool) get_config('tiny_textgestaltung', 'backgroundcolorenabled'),
            'usefortable' => (bool) get_config('tiny_textgestaltung', 'usefortable'),
        ];
    }

    /**
     * Liest und parst die Schriftliste aus der Konfiguration.
     *
     * @return array
     */
    protected static function get_fonts(): array {
        $raw = get_config('tiny_textgestaltung', 'fontlist');
        if ($raw === false || trim($raw) === '') {
            $raw = self::get_default_fontlist();
        }

        $fonts = [];
        foreach (explode("\n", $raw) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            if (strpos($line, '=') !== false) {
                [$label, $value] = explode('=', $line, 2);
                $label = trim($label);
                $value = trim($value);
            } else {
                $label = $line;
                $value = $line;
            }
            if ($label === '' || $value === '') {
                continue;
            }
            $fonts[] = [
                'text'  => $label,
                'value' => $value,
            ];
        }
        return $fonts;
    }

    /**
     * Liest und validiert die Schriftgroessen aus der Konfiguration.
     *
     * Erlaubt sind Werte wie 12pt, 14px, 1.2em, 120%.
     *
     * @return string
     */
    protected static function get_fontsizes(): string {
        $raw = get_config('tiny_textgestaltung', 'fontsizelist');
        if ($raw === false || trim($raw) === '') {
            $raw = self::get_default_fontsizes();
        }

        $valid = [];
        foreach (preg_split('/\s+/', trim($raw)) as $token) {
            if (preg_match('/^\d+(\.\d+)?(pt|px|em|rem|%)$/', $token)) {
                $valid[] = $token;
            }
        }
        return $valid ? implode(' ', $valid) : self::get_default_fontsizes();
    }

    /**
     * Liest und validiert eine Farbpalette aus der Konfiguration.
     *
     * Format der Einstellung: eine Farbe pro Zeile als "Name=#RRGGBB".
     * Rueckgabe im TinyMCE-color_map-Format: [hex, name, hex, name, ...].
     *
     * @param string $setting Name der Einstellung (textcolorlist|backgroundcolorlist)
     * @return array
     */
    protected static function get_colormap(string $setting): array {
        $raw = get_config('tiny_textgestaltung', $setting);
        if ($raw === false || trim($raw) === '') {
            $raw = self::get_default_colorlist();
        }

        $map = [];
        foreach (explode("\n", $raw) as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '=') === false) {
                continue;
            }
            [$name, $hex] = explode('=', $line, 2);
            $name = trim($name);
            $hex = trim($hex);
            // Nur gueltige Hexcodes (#RGB, #RRGGBB) uebernehmen.
            if ($name !== '' && preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $hex)) {
                $map[] = $hex;
                $map[] = $name;
            }
        }
        return $map;
    }
}
