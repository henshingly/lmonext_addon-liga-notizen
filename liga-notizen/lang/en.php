<?php
/**
 * Project: LMOnext
 * Filename: addon/liga-notizen/lang/en.php
 * Fileversion: 1.1.0
 *
 * @license   GPL-3.0-only
 *
 * Vollständig überarbeitet - siehe lang/de.php für den ausführlichen
 * Hintergrund. Schlüssel-Set identisch, nur die Werte sind englisch.
 */

return [
    'nav_notizen'        => 'League Notes',
    'notizen_title'      => 'League Notes',
    'notizen_empty'      => 'No notes available',
    'notizen_new'        => 'New Note',
    'notizen_edit'       => 'Edit',
    'notizen_delete'     => 'Delete',
    'notizen_confirm_del'=> 'Really delete this note?',
    'notizen_saved'      => 'Note saved.',
    'notizen_deleted'    => 'Note deleted.',
    'notizen_err_title'  => 'Title cannot be empty.',
    'notizen_err_liga'   => 'League ID missing.',

    // ── Newly added ──────────────────────────────────────────────────────────
    'notizen_label_liga_select'    => 'Select league',
    'notizen_option_liga_select'   => '— choose league —',
    'notizen_heading_edit'         => 'Edit note',
    'notizen_heading_new'          => 'New note for {liga}',
    'notizen_placeholder_titel'    => 'Title...',
    'notizen_placeholder_inhalt'   => 'Note content...',
    'notizen_color_gelb'           => 'Yellow',
    'notizen_color_rot'            => 'Red',
    'notizen_color_gruen'          => 'Green',
    'notizen_color_blau'           => 'Blue',
    'notizen_color_lila'           => 'Purple',
    'notizen_btn_save'             => 'Save',
    'notizen_btn_create'           => 'Add',
    'notizen_empty_liga'           => '📝 No notes for this league yet.',
    'notizen_empty_hint'           => 'Add the first note above.',
    'notizen_empty_no_liga_hint'   => 'Choose a league above to create or view notes.',
    'notizen_empty_example_hint'   => 'This add-on is an example for the LMOnext addon system.',
    'notizen_updated'              => 'Note updated.',
    'notizen_created'              => 'Note created.',
    'notizen_err_db'               => 'Database error: {msg}',
    'notizen_err_invalid_id'       => 'Invalid note ID.',
    'notizen_err_delete'           => 'Error while deleting: {msg}',
];
