// js/subscriptions.js
document.addEventListener('DOMContentLoaded', () => {
  const tableBody = document.querySelector('#subsBody');
  const addBtn = document.getElementById('addSubBtn');
  const modalBackdrop = document.getElementById('subModalBackdrop');
  const modalForm = document.getElementById('subForm');
  const modalTitle = document.getElementById('modalTitle');
  const toast = document.getElementById('toastMsg');

  let editingId = null;

  function showToast(text) {
    toast.textContent = text;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
  }

  async function fetchSubs() {
    try {
      const res = await fetch('fetch_subs.php', { credentials: 'same-origin' });
      const json = await res.json();
      if (!json.success) {
        showToast('Please log in.');
        return;
      }
      renderRows(json.data || []);
    } catch (err) {
      console.error(err); showToast('Error fetching subscriptions');
    }
  }

  function renderRows(rows) {
    if (!tableBody) return;
    if (!rows.length) {
      tableBody.innerHTML = `<tr><td colspan="6" style="text-align:center;color:var(--muted);">No subscriptions yet.</td></tr>`;
      return;
    }
    tableBody.innerHTML = rows.map(r => {
      const amt = parseFloat(r.amount).toFixed(2);
      const daysLeft = calcDaysLeft(r.next_payment);
      const badgeClass = (daysLeft < 0) ? 'badge expired' : ((daysLeft <= 7) ? 'badge pending' : 'badge active');
      return `<tr data-id="${r.id}">
        <td>${escapeHtml(r.service_name)}</td>
        <td>${escapeHtml(r.start_date)}</td>
        <td>${escapeHtml(r.next_payment)}</td>
        <td>₹${amt}</td>
        <td><span class="${badgeClass}">${escapeHtml(r.status)}</span></td>
        <td>${daysLeft < 0 ? 'Overdue ' + Math.abs(daysLeft) + 'd' : daysLeft + 'd'}</td>
        <td>
          <div class="sub-actions">
            <button class="small-btn edit" data-action="edit" data-id="${r.id}">Edit</button>
            <button class="small-btn delete" data-action="delete" data-id="${r.id}">Delete</button>
          </div>
        </td>
      </tr>`;
    }).join('');
  }

  function calcDaysLeft(dateStr) {
    const today = new Date();
    const d = new Date(dateStr + 'T00:00:00');
    const diff = Math.floor((d - new Date(today.getFullYear(), today.getMonth(), today.getDate())) / (1000*60*60*24));
    return diff;
  }

  // escape
  function escapeHtml(s){ if(!s) return ''; return String(s).replace(/[&<>"']/g, (m)=> ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }

  // open modal
  function openModal(mode = 'add', data = {}) {
    editingId = (mode === 'edit' ? data.id : null);
    modalTitle.textContent = (mode === 'edit') ? 'Edit Subscription' : 'Add Subscription';
    modalForm.service_name.value = data.service_name || '';
    modalForm.start_date.value = data.start_date || new Date().toISOString().slice(0,10);
    modalForm.next_payment.value = data.next_payment || new Date().toISOString().slice(0,10);
    modalForm.amount.value = data.amount || '';
    modalForm.status.value = data.status || 'Active';
    modalBackdrop.classList.add('show');
  }

  // close modal
  function closeModal() {
    editingId = null;
    modalBackdrop.classList.remove('show');
    modalForm.reset();
  }

  // handle clicks for edit/delete
  document.addEventListener('click', async (e) => {
    const btn = e.target.closest('button[data-action]');
    if (!btn) return;
    const action = btn.dataset.action;
    const id = btn.dataset.id;
    if (action === 'edit') {
      // fetch single row from DOM or refetch full list and find item
      // easiest: call fetchSubs and find
      try {
        const res = await fetch('fetch_subs.php', { credentials: 'same-origin' });
        const json = await res.json();
        if (!json.success) return showToast('Could not fetch data');
        const item = json.data.find(x => String(x.id) === String(id));
        if (!item) return showToast('Item not found');
        openModal('edit', item);
      } catch(err){ console.error(err); showToast('Error'); }
    } else if (action === 'delete') {
      if (!confirm('Delete this subscription?')) return;
      try {
        const form = new FormData();
        form.append('id', id);
        const res = await fetch('delete_subscription.php', { method: 'POST', body: form, credentials: 'same-origin' });
        const json = await res.json();
        if (json.success) {
          showToast('Deleted');
          fetchSubs();
        } else {
          showToast(json.msg || 'Delete failed');
        }
      } catch (err) { console.error(err); showToast('Error deleting'); }
    }
  });

  // open add modal
  if (addBtn) addBtn.addEventListener('click', () => openModal('add'));

  // modal close when clicking backdrop outside modal
  modalBackdrop.addEventListener('click', (e) => {
    if (e.target === modalBackdrop) closeModal();
  });

  // submit form (add or edit)
  modalForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(modalForm);
    const url = editingId ? 'edit_subscription.php' : 'add_subscription.php';
    if (editingId) formData.append('id', editingId);
    try {
      const res = await fetch(url, { method: 'POST', body: formData, credentials: 'same-origin' });
      const json = await res.json();
      if (json.success) {
        showToast(editingId ? 'Updated' : 'Added');
        closeModal();
        fetchSubs();
      } else {
        if (json.errors) showToast(json.errors.join(' | '));
        else showToast(json.msg || 'Operation failed');
      }
    } catch (err) { console.error(err); showToast('Network error'); }
  });

  // initial load
  fetchSubs();
});
