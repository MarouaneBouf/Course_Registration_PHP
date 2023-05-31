document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("info").addEventListener("click", () => {
    const circle = document.getElementById("circle");
    const welcome = document.getElementById("welcome_div");
    if (welcome.style.display === "none") {
      circle.style.backgroundColor = "#9aff1f";
      welcome.style.display = "block";
    } else {
      circle.style.backgroundColor = "#d0d4cf";
      welcome.style.display = "none";
    }
  });
});
