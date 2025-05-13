document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll("nav a");
  const currentPage = window.location.pathname.replace(/^\//, '').toLowerCase().replace(/\s/g, "");

  console.log("Current page:", currentPage);

  navLinks.forEach(link => {
    const linkHref = link.getAttribute("href")?.toLowerCase().replace(/\s/g, "");
    console.log("Link href:", linkHref);

    if (linkHref && currentPage === linkHref) {
      console.log("Match found!");
      link.classList.add("text-blue-600", "font-semibold");
      link.classList.remove("text-gray-600");
    }
  });
});