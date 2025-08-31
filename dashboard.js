document.addEventListener('DOMContentLoaded', () => {
  const search = document.getElementById('searchSub');
  const sort = document.getElementById('sortSub');
  const tbody = document.querySelector('#subsTable tbody');

  function filterRows() {
    const q = (search.value || '').trim().toLowerCase();
    const rows = tbody.querySelectorAll('tr');
    rows.forEach(row => {
      const service = row.dataset.service || '';
      if (service.includes(q)) row.style.display = '';
      else row.style.display = 'none';
    });
  }

  function sortRows() {
    const opt = sort.value;
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const compare = (a,b,fn) => fn(a) - fn(b);

    rows.sort((a,b) => {
      if (opt === 'next_asc') return a.dataset.next.localeCompare(b.dataset.next);
      if (opt === 'next_desc') return b.dataset.next.localeCompare(a.dataset.next);
      if (opt === 'amount_asc') return parseFloat(a.dataset.amount) - parseFloat(b.dataset.amount);
      if (opt === 'amount_desc') return parseFloat(b.dataset.amount) - parseFloat(a.dataset.amount);
      if (opt === 'service_asc') return a.dataset.service.localeCompare(b.dataset.service);
      if (opt === 'service_desc') return b.dataset.service.localeCompare(a.dataset.service);
      return 0;
    });

    rows.forEach(r => tbody.appendChild(r));
  }

  if (search) search.addEventListener('input', filterRows);
  if (sort) sort.addEventListener('change', sortRows);
});
