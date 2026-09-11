<?php
/**
 * Project: LMOnext
 * Filename: addon/liga-notizen/lang/de.php
 * Fileversion: 1.1.0
 *
 * @license   GPL-3.0-only
 *
 * Vollständig überarbeitet (auf Wunsch) - die bereits vorbereiteten
 * Schlüssel (notizen_title etc.) waren im Code bisher nirgends genutzt;
 * alle Texte waren fest auf Deutsch programmiert. notizen_saved bleibt aus
 * Kompatibilitätsgründen erhalten, wird aber durch die spezifischeren
 * notizen_updated/notizen_created ersetzt (Original unterschied bereits
 * zwischen Update und Neuanlage - diese Unterscheidung bleibt erhalten).
 */

return [
    'nav_notizen'        => 'Liga-Notizen',
    'notizen_title'      => 'Liga-Notizen',
    'notizen_empty'      => 'Keine Notizen vorhanden',
    'notizen_new'        => 'Neue Notiz',
    'notizen_edit'       => 'Bearbeiten',
    'notizen_delete'     => 'Löschen',
    'notizen_confirm_del'=> 'Notiz wirklich löschen?',
    'notizen_saved'      => 'Notiz gespeichert.',
    'notizen_deleted'    => 'Notiz gelöscht.',
    'notizen_err_title'  => 'Titel darf nicht leer sein.',
    'notizen_err_liga'   => 'Liga-ID fehlt.',

    // ── Neu ergänzt ──────────────────────────────────────────────────────────
    'notizen_label_liga_select'    => 'Liga auswählen',
    'notizen_option_liga_select'   => '— Liga wählen —',
    'notizen_heading_edit'         => 'Notiz bearbeiten',
    'notizen_heading_new'          => 'Neue Notiz für {liga}',
    'notizen_placeholder_titel'    => 'Titel...',
    'notizen_placeholder_inhalt'   => 'Notiz-Inhalt...',
    'notizen_color_gelb'           => 'Gelb',
    'notizen_color_rot'            => 'Rot',
    'notizen_color_gruen'          => 'Grün',
    'notizen_color_blau'           => 'Blau',
    'notizen_color_lila'           => 'Lila',
    'notizen_btn_save'             => 'Speichern',
    'notizen_btn_create'           => 'Anlegen',
    'notizen_empty_liga'           => '📝 Keine Notizen für diese Liga vorhanden.',
    'notizen_empty_hint'           => 'Lege oben die erste Notiz an.',
    'notizen_empty_no_liga_hint'   => 'Wähle oben eine Liga aus, um Notizen anzulegen oder zu sehen.',
    'notizen_empty_example_hint'   => 'Dieses Addon ist ein Beispiel für das Addon-System von LMOnext.',
    'notizen_updated'              => 'Notiz aktualisiert.',
    'notizen_created'              => 'Notiz angelegt.',
    'notizen_err_db'               => 'Datenbankfehler: {msg}',
    'notizen_err_invalid_id'       => 'Ungültige Notiz-ID.',
    'notizen_err_delete'           => 'Fehler beim Löschen: {msg}',
];
