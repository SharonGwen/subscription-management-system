<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html?error=' . urlencode('Please log in.'));
    exit;
}
$username = htmlspecialchars($_SESSION['username'] ?? 'User');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Subscriptions Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* small override for table layout inside dashboard */
    .card { width: 920px; max-width:95vw; }
    table.subs-table { width:100%; border-collapse:collapse; margin-top:12px; }
    .subs-table th, .subs-table td { padding:10px; text-align:left; }
    .subs-table thead th { color:var(--muted); font-weight:700; font-size:13px; }
    .subs-table tbody td { background: rgba(255,255,255,0.02); border-top:1px solid rgba(255,255,255,0.03); }
    /* Add button */
    .top-row { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-top:8px; }
    .muted-small { color:var(--muted); font-size:13px; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Welcome, <?= $username ?> 👋</h1>
    <div class="top-row">
      <div class="muted-small">Manage your subscriptions — add, edit or delete without reloading.</div>
      <div>
        <button id="addSubBtn" class="btn">+ Add Subscription</button>
        <a href="logout.php" class="btn" style="margin-left:8px; display:inline-block;">Logout</a>
      </div>
    </div>

    <table class="subs-table" aria-describedby="subscriptions">
      <thead>
        <tr>
          <th>Service</th>
          <th>Start</th>
          <th>Next Payment</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Days Left</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="subsBody">
        <!-- filled by JS -->
        <tr><td colspan="7" style="text-align:center;color:var(--muted);">Loading…</td></tr>
      </tbody>
    </table>

    <p class="small-note">Tip: Use Edit to adjust billing dates or price. Delete removes a subscription permanently.</p>
  </div>

  <!-- Modal -->
  <div id="subModalBackdrop" class="modal-backdrop" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true">
      <h3 id="modalTitle">Add Subscription</h3>
      <form id="subForm">
        <label class="small" style="display:block; color:var(--muted); margin-bottom:6px;">Service name</label>
        <input name="service_name" class="input" required placeholder="e.g., Netflix">

        <div class="form-row">
          <div style="flex:1;">
            <label class="small" style="display:block; color:var(--muted); margin-bottom:6px;">Start date</label>
            <input name="start_date" type="date" class="input" required>
          </div>
          <div style="flex:1;">
            <label class="small" style="display:block; color:var(--muted); margin-bottom:6px;">Next payment</label>
            <input name="next_payment" type="date" class="input" required>
          </div>
        </div>

        <div class="form-row">
          <input name="amount" class="input" required placeholder="Amount (e.g., 499.00)">
          <select name="status" class="input" style="max-width:160px;">
            <option>Active</option>
            <option>Pending</option>
            <option>Expired</option>
          </select>
        </div>

        <div class="foot">
          <button type="button" class="btn secondary" onclick="document.getElementById('subModalBackdrop').classList.remove('show')">Cancel</button>
          <button type="submit" class="btn">Save</button>
        </div>
      </form>
    </div>
  </div>

  <div id="toastMsg" class="toast"></div>

  <script src="subscriptions.js" defer></script>
  <script src="script.js" defer></script>
</body>
</html>

