document.addEventListener("DOMContentLoaded", () => {
    const userTab = document.getElementById("user-tab");
    const teacherTab = document.getElementById("teacher-tab");
    const userForm = document.getElementById("signup-form");
    const teacherForm = document.getElementById("teacher-form");
  
    userTab.addEventListener("click", () => {
      userTab.classList.add("bg-blue-600", "text-white");
      userTab.classList.remove("bg-gray-100", "text-gray-700");
      teacherTab.classList.remove("bg-blue-600", "text-white");
      teacherTab.classList.add("bg-gray-100", "text-gray-700");
  
      userForm.classList.remove("hidden", "opacity-0");
      teacherForm.classList.add("hidden", "opacity-0");
    });
  
    teacherTab.addEventListener("click", () => {
      teacherTab.classList.add("bg-blue-600", "text-white");
      teacherTab.classList.remove("bg-gray-100", "text-gray-700");
      userTab.classList.remove("bg-blue-600", "text-white");
      userTab.classList.add("bg-gray-100", "text-gray-700");
  
      teacherForm.classList.remove("hidden", "opacity-0");
      userForm.classList.add("hidden", "opacity-0");
    });
  });
  