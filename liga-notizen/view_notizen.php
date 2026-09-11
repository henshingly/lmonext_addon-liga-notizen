<?php
/**
 * Project: LMOnext
 * Filename: addon/liga-notizen/view_notizen.php
 * Fileversion: 1.2.0
 *
 * PHP version 8.2
 *
 * @author    Torsten Hofmann <entwickler@bastel-code.de>
 * @copyright 2026 Torsten Hofmann
 * @license   GPL-3.0-only
 *
 * ── View: Liga-Notizen ──────────────────────────────────────────────────────
 *
 * Zeigt alle Notizen einer ausgewählten Liga an. Notizen können angelegt,
 * bearbeitet und gelöscht werden. Farbcodierung für visuelle Kategorisierung.
 */

// SICHERHEITSFIX (Beitrag: Integrationsprüfung des Addons vor Übernahme):
// requireLogin() fehlte hier komplett - diese Ansicht (inkl. Lesezugriff
// auf alle Liga-Notizen) wäre ohne diese Zeile für JEDEN ohne Login direkt
// per admin.php?action=notizen erreichbar gewesen. Siehe auch
// handler_notizen.php für den identischen Fix bei den beiden POST-Handlern
// dieses Addons.
requireLogin();

// ── Tabelle sicherstellen ────────────────────────────────────────────────────
ensureNotizenTable();

// ── Liga-Auswahl ──────────────────────────────────────────────────────────────
$db = getDB();
$ligaId = (int)($_GET['liga_id'] ?? 0);

// Alle Ligen für Dropdown
$ligenStmt = $db->query('SELECT id, name FROM ' . tbl('liga') . ' ORDER BY name');
$allLigen = $ligenStmt ? $ligenStmt->fetchAll() : [];

// ── Notizen für ausgewählte Liga laden ────────────────────────────────────────
$notizen = [];
$selectedLiga = null;
if ($ligaId > 0) {
    $sLiga = $db->prepare('SELECT id, name FROM ' . tbl('liga') . ' WHERE id = ?');
    $sLiga->execute([$ligaId]);
    $selectedLiga = $sLiga->fetch();

    $sNotizen = $db->prepare(
        'SELECT * FROM ' . tbl('liga_notizen') . ' WHERE liga_id = ? ORDER BY geaendert_am DESC'
    );
    $sNotizen->execute([$ligaId]);
    $notizen = $sNotizen->fetchAll();
}

// ── Bearbeitungsmodus ────────────────────────────────────────────────────────
$editNotiz = null;
$editId = (int)($_GET['edit'] ?? 0);
if ($editId > 0) {
    $sEdit = $db->prepare('SELECT * FROM ' . tbl('liga_notizen') . ' WHERE id = ?');
    $sEdit->execute([$editId]);
    $editNotiz = $sEdit->fetch();
}

// ── Farb-Definitionen ───────────────────────────────────────────────────────
$farben = [
    'gelb'  => ['#fef3c7', '#92400e', '#f59e0b'],
    'rot'   => ['#fee2e2', '#991b1b', '#ef4444'],
    'gruen' => ['#d1fae5', '#065f46', '#22c55e'],
    'blau'  => ['#dbeafe', '#1e40af', '#3b82f6'],
    'lila'  => ['#e9d5ff', '#6b21a8', '#a855f7'],
];
// Übersetzte Anzeigenamen für die Farben (statt ucfirst($key), das aus
// "gruen" wörtlich "Gruen" statt "Grün" gemacht hätte).
$farbenLabels = [
    'gelb'  => t('notizen_color_gelb'),
    'rot'   => t('notizen_color_rot'),
    'gruen' => t('notizen_color_gruen'),
    'blau'  => t('notizen_color_blau'),
    'lila'  => t('notizen_color_lila'),
];

// ── Page-Title ───────────────────────────────────────────────────────────────
$pageTitle = '📝 ' . t('notizen_title');
?>

<div class="content-inner" style="padding:24px">

  <!-- ── Liga-Auswahl ─────────────────────────────────────────────────── -->
  <div class="card" style="margin-bottom:20px">
    <h2 style="font-size:.8rem;font-weight:600;margin-bottom:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px"><?= h(t('notizen_label_liga_select')) ?></h2>
    <form method="get" action="" style="display:flex;gap:10px;align-items:center">
      <input type="hidden" name="action" value="notizen">
      <select name="liga_id" onchange="this.form.submit()"
              style="background:var(--bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius);padding:8px 12px;font-size:.9rem;min-width:200px">
        <option value="0"><?= h(t('notizen_option_liga_select')) ?></option>
        <?php foreach ($allLigen as $liga): ?>
          <option value="<?= (int)$liga['id'] ?>" <?= $ligaId === (int)$liga['id'] ? 'selected' : '' ?>>
            <?= h($liga['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>
  </div>

  <?php if ($ligaId > 0 && $selectedLiga): ?>

    <!-- ── Neue Notiz anlegen ─────────────────────────────────────────── -->
    <div class="card" style="margin-bottom:20px">
      <h2 style="font-size:.8rem;font-weight:600;margin-bottom:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px">
        <?= $editNotiz ? h(t('notizen_heading_edit')) : h(t('notizen_heading_new', ['liga' => $selectedLiga['name']])) ?>
      </h2>
      <form method="post" action="?action=notiz_save">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= $editNotiz ? (int)$editNotiz['id'] : 0 ?>">
        <input type="hidden" name="liga_id" value="<?= $ligaId ?>">
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:12px">
          <input type="text" name="titel" placeholder="<?= h(t('notizen_placeholder_titel')) ?>"
                 value="<?= $editNotiz ? h($editNotiz['titel']) : '' ?>"
                 style="flex:1;min-width:200px;background:var(--bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius);padding:8px 12px;font-size:.9rem">
          <select name="farbe" style="background:var(--bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius);padding:8px 12px;font-size:.9rem">
            <?php foreach ($farben as $key => $f): ?>
              <option value="<?= h($key) ?>" <?= ($editNotiz && $editNotiz['farbe'] === $key) ? 'selected' : '' ?>>
                <?= h($farbenLabels[$key]) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <textarea name="inhalt" placeholder="<?= h(t('notizen_placeholder_inhalt')) ?>"
                  style="width:100%;min-height:80px;background:var(--bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius);padding:10px 12px;font-size:.9rem;font-family:inherit;resize:vertical;margin-bottom:12px"><?= $editNotiz ? h($editNotiz['inhalt']) : '' ?></textarea>
        <div style="display:flex;gap:8px">
          <button type="submit" class="btn btn-primary btn-sm" style="text-decoration:none">
            ✓ <?= $editNotiz ? h(t('notizen_btn_save')) : h(t('notizen_btn_create')) ?>
          </button>
          <?php if ($editNotiz): ?>
            <a href="?action=notizen&liga_id=<?= $ligaId ?>" class="btn btn-muted btn-sm" style="text-decoration:none"><?= h(t('common_cancel')) ?></a>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- ── Notizen-Liste ─────────────────────────────────────────────── -->
    <?php if (empty($notizen)): ?>
      <div class="card" style="text-align:center;padding:32px;color:var(--muted)">
        <p style="font-size:.95rem"><?= h(t('notizen_empty_liga')) ?></p>
        <p style="font-size:.82rem;margin-top:4px"><?= h(t('notizen_empty_hint')) ?></p>
      </div>
    <?php else: ?>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px">
        <?php foreach ($notizen as $n): 
          $farbe = $farben[$n['farbe']] ?? $farben['gelb'];
        ?>
          <div style="background:<?= $farbe[0] ?>;border:1px solid <?= $farbe[2] ?>33;border-radius:var(--radius);padding:16px;border-left:4px solid <?= $farbe[2] ?>">
            <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:8px">
              <h3 style="font-size:.95rem;font-weight:600;color:<?= $farbe[1] ?>;margin:0"><?= h($n['titel']) ?></h3>
              <div style="display:flex;gap:4px;flex-shrink:0">
                <a href="?action=notizen&liga_id=<?= $ligaId ?>&edit=<?= (int)$n['id'] ?>"
                   style="color:var(--muted);text-decoration:none;font-size:.85rem" title="<?= h(t('notizen_edit')) ?>">✏️</a>
                <form method="post" action="?action=notiz_delete" style="display:inline"
                      onsubmit="return confirm('<?= h(t('notizen_confirm_del')) ?>')">
                  <?= csrfField() ?>
                  <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                  <input type="hidden" name="liga_id" value="<?= $ligaId ?>">
                  <button type="submit" style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:.85rem;padding:0" title="<?= h(t('notizen_delete')) ?>">🗑️</button>
                </form>
              </div>
            </div>
            <?php if ($n['inhalt'] !== ''): ?>
              <p style="font-size:.85rem;color:<?= $farbe[1] ?>cc;white-space:pre-wrap;margin-bottom:8px"><?= h($n['inhalt']) ?></p>
            <?php endif; ?>
            <div style="font-size:.72rem;color:var(--muted);margin-top:auto">
              <?= h($n['erstellt_von'] ?? '') ?> · <?= date('d.m.Y H:i', strtotime($n['geaendert_am'])) ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php elseif ($ligaId === 0): ?>
    <div class="card" style="text-align:center;padding:48px;color:var(--muted)">
      <p style="font-size:1.1rem">📝 <?= h(t('notizen_title')) ?></p>
      <p style="font-size:.85rem;margin-top:8px"><?= h(t('notizen_empty_no_liga_hint')) ?></p>
      <p style="font-size:.78rem;margin-top:16px;color:var(--muted)">
        <?= h(t('notizen_empty_example_hint')) ?>
      </p>
    </div>
  <?php endif; ?>

</div>
