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
 * Befehle (Button und Menueeintrag) fuer tiny_textgestaltung.
 *
 * @module      tiny_textgestaltung/commands
 * @copyright   2026 Moodle in Niedersachsen e. V.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {get_strings as getStrings} from 'core/str';
import common from './common';
import {getFonts} from './options';

const {component, icon, buttonName, menuItemName} = common;

// Inline-SVG fuer das Icon ("A"-Glyphe). Vermeidet einen externen Bild-Fetch.
const iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" ' +
    'viewBox="0 0 24 24"><path fill="currentColor" d="M9.6 4h1.9l5.1 13h-2.1l-1.24' +
    '-3.3H7.85L6.6 17H4.5L9.6 4zm.94 2.53L8.5 11.9h4.06L10.55 6.53zM19 19H5v1.6h14V19z"/></svg>';

/**
 * Wendet eine Schriftart auf die aktuelle Auswahl an.
 *
 * @param {tinyMCE.Editor} editor
 * @param {string} value CSS-Wert der Schriftart
 */
const applyFont = (editor, value) => {
    editor.execCommand('FontName', false, value);
    editor.focus();
};

/**
 * Entfernt die Schriftartformatierung von der aktuellen Auswahl.
 *
 * @param {tinyMCE.Editor} editor
 */
const removeFont = (editor) => {
    editor.formatter.remove('fontname');
    editor.focus();
};

/**
 * Prueft, ob eine Schriftart aktuell aktiv ist.
 *
 * @param {tinyMCE.Editor} editor
 * @param {string} value
 * @returns {boolean}
 */
const isActive = (editor, value) => {
    const current = editor.queryCommandValue('FontName');
    if (!current) {
        return false;
    }
    const normalise = (str) => str.toLowerCase().replace(/['"]/g, '').trim();
    return normalise(current) === normalise(value);
};

/**
 * Baut die Menueeintraege der Schriftliste.
 *
 * @param {tinyMCE.Editor} editor
 * @param {string} removeLabel
 * @returns {Array<object>}
 */
const buildItems = (editor, removeLabel) => {
    const fonts = getFonts(editor) || [];
    const items = fonts.map((font) => ({
        type: 'togglemenuitem',
        text: font.text,
        onAction: () => applyFont(editor, font.value),
        onSetup: (api) => {
            const update = () => api.setActive(isActive(editor, font.value));
            update();
            editor.on('NodeChange', update);
            return () => editor.off('NodeChange', update);
        },
    }));

    items.push({type: 'separator'});
    items.push({
        type: 'menuitem',
        text: removeLabel,
        onAction: () => removeFont(editor),
    });

    return items;
};

/**
 * Registriert Button und Menueeintrag am Editor.
 *
 * @returns {Promise<function(tinyMCE.Editor): void>}
 */
export const getSetup = async() => {
    const [
        buttonTooltip,
        menuItemText,
        removeLabel,
    ] = await getStrings([
        'button_schriftart',
        'menuitem_schriftart',
        'removefont',
    ].map((key) => ({key, component})));

    return (editor) => {
        // Eigenes Icon inline registrieren.
        editor.ui.registry.addIcon(icon, iconSvg);

        // Dropdown-Button in der Werkzeugleiste.
        editor.ui.registry.addMenuButton(buttonName, {
            icon,
            tooltip: buttonTooltip,
            fetch: (callback) => {
                callback(buildItems(editor, removeLabel));
            },
        });

        // Verschachtelter Eintrag im Format-Menue.
        editor.ui.registry.addNestedMenuItem(menuItemName, {
            icon,
            text: menuItemText,
            getSubmenuItems: () => buildItems(editor, removeLabel),
        });
    };
};
