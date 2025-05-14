document.addEventListener("DOMContentLoaded", () => {
  fetch("includes/chart_data.php")
    .then(res => res.json())
    .then(data => {
      // 1. BMI Chart
      new Chart(document.getElementById("bmiChart"), {
        type: "bar",
        data: {
          labels: ["Underweight", "Normal", "Overweight", "Obese"],
          datasets: [{
            label: "Users",
            data: data.bmi_distribution,
            backgroundColor: ["#66bb6a", "#42a5f5", "#ffa726", "#ef5350"]
          }]
        }
      });

      // 2. Nutrition by Food Group
      new Chart(document.getElementById("nutritionChart"), {
        type: "bar",
        data: {
          labels: Object.keys(data.nutrition_intake),
          datasets: [{
            label: "Calories",
            data: Object.values(data.nutrition_intake),
            backgroundColor: "#42a5f5"
          }]
        }
      });

      // 3. Macronutrient Pie
      new Chart(document.getElementById("macroChart"), {
        type: "pie",
        data: {
          labels: ["Protein", "Carbs", "Fat"],
          datasets: [{
            data: [data.macros.protein, data.macros.carbs, data.macros.fat],
            backgroundColor: ["#66bb6a", "#ffca28", "#ef5350"]
          }]
        }
      });

      // 4. Progress Over Time (Line)
      new Chart(document.getElementById("progressChart"), {
        type: "line",
        data: {
          labels: data.progress.dates,
          datasets: [{
            label: "Weight (kg)",
            data: data.progress.weights,
            borderColor: "#42a5f5",
            fill: false
          }]
        }
      });
    })
    .catch(err => console.error("Chart data load error:", err));
});
