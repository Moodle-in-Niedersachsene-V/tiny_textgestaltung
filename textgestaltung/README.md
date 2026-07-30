# tiny_textgestaltung – Textgestaltung (Niedersachsen)

Ein Plugin für den **Tiny-Editor** in Moodle 5.x, das Schriftart,
Schriftgröße sowie Text- und Hintergrundfarbe für markierten Text
bereitstellt. Freier Ersatz für die kostenpflichtig gewordenen Plugins
`tiny_fontfamily` und `tiny_fontsize`, deckt zusätzlich Schriftfarben ab.

## Funktionen

- **Schriftart:** eigener Dropdown-Button mit konfigurierbarer Liste,
  aktive Schrift mit Häkchen, Eintrag „Schriftart entfernen"
- **Schriftgröße, Textfarbe, Hintergrundfarbe:** über die nativen,
  von Moodle standardmäßig ausgeblendeten TinyMCE-Elemente –
  Größenliste und Farbpalette über die Plugin-Einstellungen konfigurierbar,
  freie Farbwahl (Pipette) inklusive
- Alle Elemente erscheinen in der Werkzeugleiste (Formatierungsgruppe)
  **und** im Format-Menü
- Speichert keine personenbezogenen Daten (Null-Privacy-Provider)

## Installation

1. ZIP über *Website-Administration → Plugins → Plugins installieren*
   hochladen, oder Ordner nach `lib/editor/tiny/plugins/textgestaltung/`
   entpacken.
2. Datenbank-Upgrade ausführen.
3. Einstellungen unter *Website-Administration → Plugins →
   Texteditoren → TinyMCE → Textgestaltung (Niedersachsen)* anpassen.

## Einstellungen

**Schriftarten** – eine pro Zeile, `Anzeigename=CSS-Wert`:

```
Arial=Arial, sans-serif
Times New Roman="Times New Roman", serif
```

**Schriftgrößen** – Leerzeichen-getrennt, Einheiten pt/px/em/rem/%:

```
8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt
```

**Farbpalette** – eine Farbe pro Zeile, `Name=#RRGGBB` (gilt für Text-
und Hintergrundfarbe):

```
Rot=#C00000
Blau=#0070C0
```

## Hinweis

Dieses Plugin ersetzt `tiny_schriftart` (Vorgängername). Vor der
Installation `tiny_schriftart` sowie ggf. `tiny_fontcolor` und
`tiny_fontsize` deinstallieren, um doppelte Buttons zu vermeiden.
Einstellungen des Vorgängers müssen neu eingetragen werden.

## Kompatibilität

- Moodle 5.x (`requires = 2025041400`)
- Tiny-Editor (Standard ab Moodle 4.1, alleiniger Editor ab Moodle 5.1)

## Lizenz

GNU GPL v3 oder später.

## Maintainer

Moodle in Niedersachsen e. V.
