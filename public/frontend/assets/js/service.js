const tabs = document.querySelectorAll(".nav-link");
const tabContent = document.querySelectorAll(".tab-pane");

tabs.forEach((tab) => {
  tab.addEventListener("mouseover", () => {
    tabs.forEach((t) => t.classList.remove("active"));
    tabContent.forEach((content) => {
      content.classList.remove("show", "active");
    });

    tab.classList.add("active");
    const target = document.querySelector(tab.getAttribute("href"));
    target.classList.add("show", "active");
  });
});
