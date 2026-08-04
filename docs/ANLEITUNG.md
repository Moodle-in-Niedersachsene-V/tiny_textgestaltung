# Anleitung: Textgestaltung (Niedersachsen)

Plugin `tiny_textgestaltung` – Moodle in Niedersachsen e. V.

Das Plugin erweitert den Tiny-Editor um vier Werkzeuge: **Schriftart,
Schriftgröße, Textfarbe und Hintergrundfarbe**. Es ersetzt die
kostenpflichtig gewordenen Plugins `tiny_fontfamily` und `tiny_fontsize`
und deckt zusätzlich Schriftfarben ab.

## Für Lehrkräfte: Bedienung

Alle vier Werkzeuge finden Sie an zwei Stellen des Editors:

- **In der Werkzeugleiste** bei den Formatierungs-Buttons (neben
  Fett/Kursiv): das „A“-Symbol öffnet die Schriftartauswahl, daneben
  liegen Schriftgröße, Textfarbe und Hintergrundfarbe.
- **Im Menü** unter *Format*: Schriftart, Schriftgröße, Textfarbe,
  Hintergrundfarbe.

**Anwendung:** Text markieren, dann das gewünschte Werkzeug anklicken und
einen Wert wählen. Die aktuell aktive Schriftart ist im Menü mit einem
Häkchen markiert. Der Eintrag „Schriftart entfernen“ setzt die Schrift
auf den Standard zurück. Bei den Farben steht neben der Palette eine
freie Farbwahl über einen Farbwähler-Dialog mit Hex-Eingabe zur
Verfügung; „Entfernen“ setzt die Farbe zurück. Sofern aktiviert, stehen
die Farben auch in den Tabellenwerkzeugen für Rahmen und
Zellenhintergrund bereit.

**Hinweis zur Barrierefreiheit:** Setzen Sie Farben sparsam und mit
ausreichend Kontrast ein – Farbe sollte nie der einzige Bedeutungsträger
sein. Die voreingestellte Palette ist entsprechend gewählt.

## Für Administratorinnen und Administratoren: Einstellungen

*Website-Administration → Plugins → Texteditoren → TinyMCE →
Textgestaltung (Niedersachsen)*

Konfigurierbar sind zwei Listen für Schrift und Größe, getrennte
Farbpaletten für Text- und Hintergrundfarbe (jeweils per Schalter
aktivierbar) sowie die Nutzung der Farben in Tabellen.

### 1. Verfügbare Schriftarten

Eine pro Zeile im Format `Anzeigename=CSS-Wert`:

```
Arial=Arial, sans-serif
Trebuchet MS="Trebuchet MS", sans-serif
```

Ohne „=“ wird die Zeile zugleich als Name und CSS-Wert verwendet. Der
Auslieferungsstandard umfasst neun Schriften (Arial, Verdana, Tahoma,
Trebuchet MS, Times New Roman, Georgia, Garamond, Courier New, Brush
Script MT) in der aus `tiny_fontfamily` gewohnten Reihenfolge.
Empfehlung: möglichst web-sichere Schriften verwenden, damit die
Darstellung auf allen Geräten identisch ist.

### 2. Verfügbare Schriftgrößen

Leerzeichen-getrennt, erlaubte Einheiten `pt`, `px`, `em`, `rem`, `%`:

```
8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt
```

Ungültige Einträge werden automatisch verworfen.

### 3. Textfarben und 4. Hintergrundfarben

Getrennte Paletten, je eine Farbe pro Zeile im Format `Name=#RRGGBB`
(der Name erscheint als Tooltip); beide Paletten lassen sich über die
zugehörigen Schalter komplett deaktivieren, der jeweilige Button
verschwindet dann aus Werkzeugleiste und Menü:

```
Rot=#C00000
Blau=#0070C0
```

Nur gültige Hex-Codes werden übernommen. Die freie Farbwahl (Farbwähler
mit Hex-Eingabe) steht zusätzlich zur Verfügung. Die Option **„Farben
für Tabellenrahmen und Zellenhintergrund verwenden“** stellt die
Textfarben als Rahmenfarben und die Hintergrundfarben als
Zellhintergründe in den Tabellenwerkzeugen bereit. Ein CSS-Klassen-Modus
wie in `tiny_fontcolor` wird bewusst nicht angeboten, da er die
Übertragung von Inhalten zwischen Instanzen erschwert.

Die Nutzung kann über die Capability `tiny/textgestaltung:use`
rollenbasiert gesteuert werden (Standard: für alle Nutzer erlaubt).

## Installation und Update

- ZIP über *Website-Administration → Plugins → Plugins installieren*
  hochladen (Zielordner: `lib/editor/tiny/plugins/textgestaltung/`).
- Vorher deinstallieren, falls vorhanden: `tiny_schriftart`
  (Vorgängername), `tiny_fontfamily`, `tiny_fontsize`, `tiny_fontcolor`
  – sonst erscheinen Buttons doppelt.
- Nach jedem Update: Caches leeren (*Website-Administration →
  Entwicklung → Caches leeren*) und im Browser hart neu laden
  (Strg+F5).

## Häufige Fragen

**Bleiben alte Formatierungen erhalten?** Ja. Alle Formatierungen liegen
als Inline-Styles direkt im Inhalt und werden unabhängig vom Plugin
korrekt angezeigt und weiterbearbeitet.

**Was passiert mit der Schriftliste beim Update?** Wurde die Liste nie
verändert, hebt das Update sie automatisch auf den aktuellen
Auslieferungsstandard an. Von Administratoren angepasste Listen bleiben
unverändert; leere Felder greifen stets auf den eingebauten Standard
zurück.

**Warum fehlt eine früher genutzte Schriftart im Menü?** Das Menü zeigt
nur die konfigurierte Liste. Bestehender Text in anderen Schriften wird
trotzdem korrekt dargestellt; um die Schrift neu zuzuweisen, muss sie in
den Einstellungen ergänzt werden.

## Lizenz

GNU GPL v3 oder später – Moodle in Niedersachsen e. V.
