# Changelog: liga-notizen-Addon (LMOnext)

Beispiel-/Referenz-Addon von Torsten Hofmann: Notizen pro Liga anlegen,
bearbeiten und löschen. Demonstriert das Addon-System (Manifest, Handler,
View, Sprachdateien, CSRF-Schutz, Hook-Integration).

Vor der Übernahme sicherheitsgeprüft - kritische Lücken gefunden und
behoben (siehe unten).

## Version 1.2.0 (Vollständige Mehrsprachigkeit)

- Feature (auf Wunsch): die gesamte Funktionalität ist jetzt über Sprachdateien steuerbar statt fest auf Deutsch programmiert zu sein. Betrifft handler_notizen.php 1.2.0 (alle Flash-/Fehlermeldungen) und view_notizen.php 1.2.0 (komplette Admin-Oberfläche: Labels, Buttons, Farb-Bezeichnungen, Platzhalter, Bestätigungsdialoge, Leer-Zustände).
- Die bereits vorbereiteten Schlüssel (notizen_title, notizen_edit, notizen_confirm_del usw.) werden jetzt tatsächlich genutzt; lang/de.php und lang/en.php um rund 20 weitere Schlüssel ergänzt, die im Original noch fehlten (Liga-Auswahl-Label, Formular-Überschriften mit {liga}-Platzhalter, Farb-Bezeichnungen, Platzhaltertexte, Leer-Zustände, differenzierte Erfolgsmeldungen für Anlegen vs. Aktualisieren).
- Die Original-Unterscheidung zwischen "Notiz aktualisiert." und "Notiz angelegt." blieb erhalten (zwei spezifische Schlüssel notizen_updated/notizen_created statt einer pauschalen "gespeichert"-Meldung).
- Farb-Auswahl im Formular nutzt jetzt echte Übersetzungen statt ucfirst($key) - das hätte aus "gruen" wörtlich "Gruen" statt "Grün" gemacht.
- Wiederverwendung des bereits bestehenden globalen Core-Schlüssels common_cancel für den Abbrechen-Button, statt eines weiteren addon-eigenen Duplikats.
- Gegen den Addon-Manager-Sicherheitsscanner erneut getestet: keine Treffer.

## Version 1.1.0 (Sicherheits- und Integrationsfixes)

- KRITISCHER Sicherheitsfix (view_notizen.php 1.1.0, handler_notizen.php 1.1.0): requireLogin() fehlte an allen drei zugriffsrelevanten Stellen (der Admin-Ansicht selbst sowie beiden POST-Handlern notiz_save/notiz_delete). Anders als requireCsrf() (zentral in admin.php für jeden POST-Request geprüft - das war hier bereits korrekt abgesichert, keine Änderung nötig) gibt es KEINE zentrale, unbedingte Login-Prüfung im Core - jeder Admin-Handler muss sie selbst als erste Zeile aufrufen. Ohne diesen Fix wäre die gesamte Liga-Notizen-Verwaltung (Ansicht UND Schreibzugriff) für jeden ohne Login direkt erreichbar gewesen.
- Bugfix (addon.json): db_tables enthielt den Tabellennamen mit fest eingebautem "lmo_"-Präfix ("lmo_liga_notizen"), obwohl der tatsächliche PHP-Code über tbl('liga_notizen') (ohne Präfix, das Präfix wird von tbl() bzw. bei einem Addon-Datenlöschvorgang zur Laufzeit dynamisch ergänzt, siehe AddonManager::purgeData()) arbeitet - bei einer Installation mit einem anderen DB-Präfix als "lmo_" hätte ein Datenlöschvorgang über den Addon-Manager versucht, eine falsch benannte (doppelt/falsch präfigierte) Tabelle zu löschen, das "Tabellen müssen wieder löschbar sein"-Kriterium wäre nicht erfüllt gewesen. Auf den Basis-Namen ohne Präfix korrigiert, konsistent mit allen anderen Addons dieses Systems.
- min_core_version von 1.4.0 auf 1.9.2 korrigiert (das Addon nutzt requireLogin() und die AVAILABLE_LANGUAGES-basierte Addon-Sprachladung, die erst in neueren Core-Versionen vollständig funktionieren).
- Kleinere Verbesserung: ensureNotizenTable() verschluckte Fehler bei der Tabellenerstellung bisher komplett stillschweigend - jetzt über error_log() protokolliert.
- Gegen den Addon-Manager-Sicherheitsscanner getestet: keine Treffer. Alle Nutzereingaben bereits im Original korrekt mit h() escaped, CSRF-Felder in beiden Formularen bereits vorhanden.
- WICHTIGER ZUSATZFUND (im CORE behoben, keine weitere Änderung an diesem Addon nötig): der von diesem Addon deklarierte Hook-Handler (notizenOnLigaDeleted) wäre bis vor Kurzem nie ausgelöst worden, da der Core den Hook "liga.deleted" bisher nirgends feuerte. Siehe CHANGELOG.md des Hauptsystems, admin/handler_liga.php, für den Fix - mit der dortigen Ergänzung funktioniert der hier deklarierte Hook jetzt wie vom Addon vorgesehen. Zusätzlich profitiert dieses Addon bereits automatisch vom früheren Core-Fix in src/Addon/AddonManager.php (Drei-Phasen-Boot: Sprachen/Templates → Handler-Dateien laden → Hooks registrieren), der sicherstellt, dass die Hook-Handler-Funktion zum Zeitpunkt der Registrierung bereits bekannt ist.

## Version 1.0.3

- Letzte Version von Torsten Hofmann vor der Integrationsprüfung.
