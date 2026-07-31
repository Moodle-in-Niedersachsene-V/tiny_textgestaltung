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
 * Konfiguration (Platzierung in Toolbar und Menue) fuer tiny_textgestaltung.
 *
 * Aktiviert zusaetzlich die nativen TinyMCE-Elemente fontsize, forecolor
 * und backcolor, die Moodle standardmaessig ausblendet, und konfiguriert
 * sie ueber die Plugin-Einstellungen.
 *
 * @module      tiny_textgestaltung/configuration
 * @copyright   2026 Moodle in Niedersachsen e. V.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {
    addMenubarItem,
    addToolbarButtons,
} from 'editor_tiny/utils';
import common from './common';

const {buttonName, menuItemName} = common;

/**
 * Liest die Plugin-Konfiguration aus den Editor-Optionen.
 *
 * @param {object} options
 * @returns {object}
 */
const getPluginSettings = (options) => {
    if (options && options.plugins && options.plugins['tiny_textgestaltung/plugin']
            && options.plugins['tiny_textgestaltung/plugin'].config) {
        return options.plugins['tiny_textgestaltung/plugin'].config;
    }
    return {};
};

/**
 * Wird von der Moodle-Tiny-Integration aufgerufen; das zurueckgegebene
 * Objekt wird in die bestehende Editor-Konfiguration gemischt.
 *
 * @param {object} instanceConfig
 * @param {object} options
 * @returns {object}
 */
export const configure = (instanceConfig, options) => {
    const settings = getPluginSettings(options);

    // Eigener Schriftart-Button plus native Elemente; Farben je nach Schalter.
    const toolbarItems = [buttonName, 'fontsize'];
    const menuItems = [menuItemName, 'fontsize'];

    if (settings.textcolorenabled) {
        toolbarItems.push('forecolor');
        menuItems.push('forecolor');
    }
    if (settings.backgroundcolorenabled) {
        toolbarItems.push('backcolor');
        menuItems.push('backcolor');
    }

    const override = {
        toolbar: addToolbarButtons(instanceConfig.toolbar, 'formatting', toolbarItems),
        menu: addMenubarItem(instanceConfig.menu, 'format', menuItems.join(' ')),
    };

    // Schriftgroessen aus den Plugin-Einstellungen.
    if (settings.fontsizes) {
        // eslint-disable-next-line camelcase
        override.font_size_formats = settings.fontsizes;
    }

    // Getrennte Paletten fuer Text- und Hintergrundfarbe.
    if (settings.textcolors && settings.textcolors.length) {
        // eslint-disable-next-line camelcase
        override.color_map_foreground = settings.textcolors;
    }
    if (settings.backgroundcolors && settings.backgroundcolors.length) {
        // eslint-disable-next-line camelcase
        override.color_map_background = settings.backgroundcolors;
    }

    // Plugin-Farben auch fuer Tabellenrahmen und Zellenhintergrund.
    if (settings.usefortable) {
        if (settings.textcolors && settings.textcolors.length) {
            // eslint-disable-next-line camelcase
            override.table_border_color_map = settings.textcolors;
        }
        if (settings.backgroundcolors && settings.backgroundcolors.length) {
            // eslint-disable-next-line camelcase
            override.table_background_color_map = settings.backgroundcolors;
        }
    }

    // Eigene Farbwahl (Pipette) zulassen.
    // eslint-disable-next-line camelcase
    override.custom_colors = true;

    return override;
};
