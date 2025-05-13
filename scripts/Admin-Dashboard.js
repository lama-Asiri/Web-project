
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('input[placeholder="Search users..."]');

  function applyThemeStyles() {
    const isDark = document.documentElement.classList.contains('dark');
    document.querySelectorAll('.status-span').forEach(statusSpan => {
      const statusText = statusSpan.textContent.trim().toLowerCase();
      statusSpan.className = 'status-span px-2 py-1 rounded-full text-sm';

      if (statusText === 'approved') {
        statusSpan.classList.add(isDark ? 'bg-green-700' : 'bg-green-100', 'text-green-600');
      } else {
        statusSpan.classList.add(isDark ? 'bg-red-700' : 'bg-red-100', 'text-red-600');
      }
    });
  }

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
      const userText = row.textContent.toLowerCase();
      row.style.display = userText.includes(query) ? '' : 'none';
    });
  });

  let currentRow = null;

  function openStudentModal(row) {
    currentRow = row;
    document.getElementById('studentName').value = row.querySelector('p.font-medium')?.childNodes[0]?.textContent.trim();
    document.getElementById('studentEmail').value = row.querySelector('p.text-sm')?.textContent.trim();
    document.getElementById('studentModal').classList.remove('hidden');
  }

  window.closeStudentModal = () => document.getElementById('studentModal').classList.add('hidden');

  document.getElementById('studentForm')?.addEventListener('submit', function (e) {
    e.preventDefault();
    const name = document.getElementById('studentName').value;
    const email = document.getElementById('studentEmail').value;
    const userId = currentRow.dataset.id;

    fetch('../php/get_full_dashboard_data.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=update_user_info&user_id=${userId}&username=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}`
    })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        currentRow.querySelector('p.font-medium').childNodes[0].textContent = name + ' ';
        currentRow.querySelector('p.text-sm').textContent = email;
        closeStudentModal();
      } else {
        alert('❌ Update failed: ' + response.error);
      }
    })
    .catch(() => {
      alert('❌ An error occurred while saving changes.');
    });
  });

  const themeToggle = document.getElementById('theme-toggle');
  const themeIcon = document.getElementById('theme-icon');
  const darkTheme = document.getElementById('dark-theme');

  if (themeToggle && themeIcon && darkTheme) {
    themeToggle.addEventListener('click', () => {
      const isDark = document.documentElement.classList.contains('dark');
      document.documentElement.classList.toggle('dark', !isDark);
      darkTheme.disabled = isDark;
      themeIcon.classList.toggle('fa-sun', !isDark);
      themeIcon.classList.toggle('fa-moon', isDark);
      applyThemeStyles();
    });
  }

  document.getElementById('addAdminBtn')?.addEventListener('click', () => {
    document.getElementById('adminModal').classList.remove('hidden');
  });

  window.closeAdminModal = function () {
    document.getElementById('adminModal').classList.add('hidden');
  };

  document.getElementById('adminForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const name = document.getElementById('newAdminName').value;
    const email = document.getElementById('newAdminEmail').value;
    const password = document.getElementById('newAdminPassword').value;
    const status = document.getElementById('newAdminStatus').value;

    fetch('../php/get_full_dashboard_data.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=add_admin&username=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&status=${status}`
    })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        alert('✅ Admin added successfully.');
        closeAdminModal();
        location.reload();
      } else {
        alert('❌ Failed to add admin: ' + response.error);
      }
    })
    .catch(() => {
      alert('❌ An error occurred while sending the request.');
    });
  });

  applyThemeStyles();

  fetch('../php/get_full_dashboard_data.php')
    .then(res => res.json())
    .then(data => {
      document.getElementById('total-users').textContent = data.stats.total_users;
      document.getElementById('total-students').textContent = data.stats.total_students;
      document.getElementById('total-teachers').textContent = data.stats.total_teachers;
      document.getElementById('pending-materials').textContent = data.stats.pending_materials;
      document.getElementById('active-materials').textContent = data.stats.active_materials;

      const studentTable = document.querySelector('table[data-type="student"] tbody');
      const teacherTable = document.querySelector('table[data-type="teacher"] tbody');
      const adminTable = document.querySelector('table[data-type="admin"] tbody');
      studentTable.innerHTML = "";
      teacherTable.innerHTML = "";
      adminTable.innerHTML = "";

      data.students.forEach(user => renderRow(user, studentTable));
      data.teachers.forEach(user => renderRow(user, teacherTable));
      data.admins.forEach(user => renderRow(user, adminTable));

      function renderRow(user, table) {
        const statusClass = user.status.toLowerCase() === 'approved'
          ? 'bg-green-100 text-green-600'
          : 'bg-red-100 text-red-600';
      
        const row = document.createElement('tr');
        row.dataset.id = user.id;
        row.className = 'border-b';
      
        // ✅ Fix begins here
        const fileName = user.profile_image ? user.profile_image.split('/').pop() : null;
        const imgPath = fileName ? `../php/uploads_users_image/${fileName}` : '../images/avtar.png';
        // ✅ Fix ends here
      
        row.innerHTML = `
          <td class="py-3">
            <div class="flex items-center">
              <img src="${imgPath}" class="w-8 h-8 rounded-full mr-3 object-cover" alt="User image">
              <div>
                <p class="font-medium">${user.username}</p>
                <p class="text-sm text-gray-500">${user.email ?? ''}</p>
              </div>
            </div>
          </td>
          <td class="py-3">
            <span class="status-span px-2 py-1 rounded-full text-sm ${statusClass}">
              <span>${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</span>
            </span>
          </td>
          <td class="py-3 space-x-2">
            <button class="text-gray-600 hover:text-blue-600 edit-btn">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
            <button class="text-gray-600 hover:text-red-600 action-btn">
              <i class="fa-solid ${user.status === 'approved' ? 'fa-ban' : 'fa-rotate-left'}"></i>
            </button>
            <button class="text-gray-600 hover:text-red-600 delete-btn">
              <i class="fa-solid fa-trash"></i>
            </button>
          </td>
        `;
      
        table.appendChild(row);
      }
      

      document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const row = btn.closest('tr');
          currentRow = row;
          const name = row.querySelector('p.font-medium')?.childNodes[0]?.textContent.trim();
          const email = row.querySelector('p.text-sm')?.textContent.trim();
          document.getElementById('studentName').value = name;
          document.getElementById('studentEmail').value = email;
          document.getElementById('studentModal').classList.remove('hidden');
        });
      });

      document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const row = btn.closest('tr');
          const statusSpan = row.querySelector('.status-span');
          const icon = btn.querySelector('i');
          const currentStatus = statusSpan.textContent.trim().toLowerCase();
          const newStatus = currentStatus === 'approved' ? 'pending' : 'approved';

          const confirmChange = confirm(`Are you sure you want to change status to "${newStatus}"?`);
          if (!confirmChange) return;

          statusSpan.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
          icon.classList.toggle('fa-ban', newStatus === 'approved');
          icon.classList.toggle('fa-rotate-left', newStatus === 'pending');

          const isDark = document.documentElement.classList.contains('dark');
          statusSpan.className = 'status-span px-2 py-1 rounded-full text-sm';
          statusSpan.classList.add(
            newStatus === 'approved'
              ? (isDark ? 'bg-green-700' : 'bg-green-100')
              : (isDark ? 'bg-red-700' : 'bg-red-100'),
            newStatus === 'approved' ? 'text-green-600' : 'text-red-600'
          );

          const userId = row.dataset.id;
          fetch('../php/get_full_dashboard_data.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=update_status&user_id=${userId}&status=${newStatus}`
          })
          .then(res => res.json())
          .then(response => {
            if (!response.success) {
              alert("❌ Failed to update status in the database.");
            }
          })
          .catch(() => {
            alert("❌ An error occurred while sending the request.");
          });
        });
      });

      document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const row = btn.closest('tr');
          const userId = row.dataset.id;
          const confirmDelete = confirm("Are you sure you want to delete this account?");
          if (!confirmDelete) return;

          fetch('../php/get_full_dashboard_data.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=delete_user&user_id=${userId}`
          })
          .then(res => res.json())
          .then(response => {
            if (response.success) {
              row.remove();
              alert("✅ Account deleted successfully.");
            } else {
              alert("❌ Failed to delete the account: " + response.error);
            }
          })
          .catch(() => {
            alert("❌ An error occurred while sending the request.");
          });
        });
      });

      applyThemeStyles();
      updateActionButtonThemes();

    });
});

// Style approve/reject buttons based on theme
function updateActionButtonThemes() {
  const isDark = document.body.classList.contains('dark');

  document.querySelectorAll('.btn-approve').forEach(btn => {
    btn.style.backgroundColor = isDark ? '#166534' : '#d1fae5';
    btn.style.color = isDark ? '#bbf7d0' : '#065f46';
  });

  document.querySelectorAll('.btn-reject').forEach(btn => {
    btn.style.backgroundColor = isDark ? '#991b1b' : '#fee2e2';
    btn.style.color = isDark ? '#fecaca' : '#7f1d1d';
  });
}
