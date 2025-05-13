// Get DOM elements
const gradeFilter = document.getElementById('grade-filter');
const searchInput = document.getElementById('search-input');
const materialsList = document.getElementById('materials-list');
const themeToggle = document.getElementById('theme-toggle');
const themeIcon = document.getElementById('theme-icon');
const categoryButtons = document.querySelectorAll(".category-btn");

if (!gradeFilter || !searchInput || !materialsList || !themeToggle || !themeIcon) {
  console.warn("[DEBUG] One or more DOM elements are missing. Check your HTML.");
}

let currentSubject = "All";

// Fetch pending materials from the server
function fetchMaterials() {
  console.log("[DEBUG] Fetching pending materials...");

  fetch('../php/material-approval2.php', {
    method: 'GET',
  })
    .then(response => {
      if (!response.ok) {
        throw new Error(`[DEBUG] Server returned status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      console.log("[DEBUG] Received data:", data);

      if (Array.isArray(data) && data.length > 0) {
        materialsList.innerHTML = '';  // Clear existing

        data.forEach(material => {
          if (!material.material_id || !material.title) {
            console.warn("[DEBUG] Material is missing expected properties:", material);
            return;
          }

          const materialItem = document.createElement('div');
          materialItem.setAttribute('data-id', material.material_id);
          materialItem.classList.add('bg-white', 'rounded-lg', 'shadow-sm', 'p-6', 'flex', 'items-center', 'justify-between', 'material-item');
          materialItem.setAttribute('data-subject', material.subject);
          materialItem.setAttribute('data-grade', material.grade);
          materialItem.setAttribute('data-status', material.status);

          materialItem.innerHTML = `
            <div class="flex items-center space-x-4">
              <div class="bg-blue-100 p-3 rounded-lg icon-wrapper-pdf">
                <i class="fa-solid fa-file-pdf text-blue-600 text-2xl icon-pdf"></i>
              </div>
              <div>
                <h3 class="text-lg font-semibold">${material.title}</h3>
                <div class="text-sm text-gray-600 mt-1">
                  <span>PDF</span> • <span>${material.subject}</span> • <span>${material.grade}</span>
                </div>
              </div>
            </div>

            <div class="flex items-center space-x-4">
              <button onclick="handleAction(this, 'approve')" class="flex flex-wrap px-4 py-2 rounded-lg btn-approve">
                <i class="fa-solid fa-check mr-2"></i>Approve
              </button>
              <button onclick="handleAction(this, 'reject')" class="px-4 py-2 rounded-lg btn-reject">
                <i class="fa-solid fa-xmark mr-2"></i>Reject
              </button>
            </div>
          `;

          materialsList.appendChild(materialItem);
          updateActionButtonThemes();

        });
      } else {
        console.log('[DEBUG] No pending materials found.');
        materialsList.innerHTML = '<p class="text-gray-500 text-center w-full">No pending materials.</p>';
      }
    })
    .catch(error => {
      console.error('[ERROR] Failed to fetch materials:', error);
    });
}

// Filter by subject, grade, and search input
function filterMaterials() {
  const grade = gradeFilter.value.toLowerCase();
  const search = searchInput.value.toLowerCase();

  console.log(`[DEBUG] Filtering by subject: ${currentSubject}, grade: ${grade}, search: ${search}`);

  const materials = document.querySelectorAll('.material-item');

  materials.forEach(material => {
    const mSubject = material.dataset.subject?.toLowerCase() || '';
    const mGrade = material.dataset.grade?.toLowerCase() || '';
    const title = material.querySelector('h3')?.textContent.toLowerCase() || '';

    const matchSubject = currentSubject.toLowerCase() === "all" || mSubject === currentSubject.toLowerCase();
    const matchGrade = grade === 'all grades' || grade === mGrade;
    const matchSearch = title.includes(search);

    material.style.display = (matchSubject && matchGrade && matchSearch) ? 'flex' : 'none';
  });
}

// Handle subject category button click
categoryButtons.forEach((button) => {
  button.addEventListener("click", function () {
    currentSubject = this.textContent.trim();
    console.log("[DEBUG] Category selected:", currentSubject);
    updateCategoryButtons(currentSubject);
    filterMaterials();
  });
});

// Update category styles
function updateCategoryButtons(activeCategory) {
  categoryButtons.forEach((btn) => {
    const btnLabel = btn.textContent.trim();
    if (btnLabel === activeCategory) {
      btn.classList.add("bg-blue-600", "text-white", "ring-2", "ring-offset-2", "ring-blue-500");
    } else {
      btn.classList.remove("bg-blue-600", "text-white", "ring-2", "ring-offset-2", "ring-blue-500");
    }
  });
}

// Approve or reject a material
function handleAction(button, type) {
  const material = button.closest('.material-item');
  const materialId = material.dataset.id;

  console.log(`[DEBUG] ${type.toUpperCase()} action on material_id: ${materialId}`);

  if (!materialId) {
    console.warn("[DEBUG] Material ID is missing in DOM.");
    return;
  }

  const confirmed = confirm(`Are you sure you want to ${type} this item?`);

  if (confirmed) {
    fetch('../php/material-approval2.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        material_id: materialId,
        action: type,
      }),
    })
      .then(response => {
        if (!response.ok) {
          throw new Error(`[DEBUG] Server returned status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        console.log("[DEBUG] Action response:", data);
        if (data.success) {
          material.remove();
          alert(`Item has been ${type}d successfully.`);
        } else {
          alert(`Failed to ${type} the item.`);
        }
      })
      .catch(error => {
        console.error(`[ERROR] Failed to ${type} material:`, error);
      });
  }
}

// Theme switch toggle
themeToggle.addEventListener('click', () => {
  const darkTheme = document.getElementById('dark-theme');
  darkTheme.disabled = !darkTheme.disabled;
  document.body.classList.toggle('dark');
  themeIcon.classList.toggle('fa-moon');
  themeIcon.classList.toggle('fa-sun');
  updateActionButtonThemes();
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

// Initial setup
document.addEventListener('DOMContentLoaded', () => {
  // Apply saved theme on load
const savedTheme = localStorage.getItem("theme");
const darkTheme = document.getElementById("dark-theme");

if (savedTheme === "dark") {
  darkTheme.disabled = false;
  document.body.classList.add("dark");
  if (themeIcon) {
    themeIcon.classList.replace("fa-moon", "fa-sun");
  }
}

  console.log("[DEBUG] DOM fully loaded. Initializing...");
  updateActionButtonThemes();
  fetchMaterials();
  filterMaterials();
});

// Filter on change
gradeFilter.addEventListener('change', filterMaterials);
searchInput.addEventListener('input', filterMaterials);
