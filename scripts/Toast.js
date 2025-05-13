function showToast(message, type = "success") {
    const toast = document.createElement("div");
    const baseStyle = "px-5 py-3 rounded-lg shadow-md text-white text-sm flex items-center gap-3 transition-all duration-300";
    const colors = {
      success: "bg-green-600",
      error: "bg-red-600",
      warning: "bg-yellow-500 text-black"
    };
  
    toast.className = `${baseStyle} ${colors[type] || colors.success}`;
    toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-times-circle' : 'fa-exclamation-triangle'}"></i> ${message}`;
  
    const container = document.getElementById("toast-container");
    container.appendChild(toast);
  
    setTimeout(() => {
      toast.classList.add("opacity-0", "translate-y-2");
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }