document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("mealForm");
  const msg = document.getElementById("mealMsg");

  form.addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch('save_meal.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      if (data.trim() === "success") {
        msg.textContent = "✅ Meal saved successfully!";
        msg.className = "text-success";
        form.reset();
      } else {
        msg.textContent = "❌ Error saving meal: " + data;
        msg.className = "text-danger";
      }
    })
    .catch(err => {
      msg.textContent = "❌ Network error";
      msg.className = "text-danger";
      console.error(err);
    });
  });
});
