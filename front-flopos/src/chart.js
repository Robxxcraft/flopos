import { Chart, Legend, Title, Tooltip } from "chart.js";

Chart.register(Legend, Title, Tooltip)
Chart.defaults.color = "#374151"
Chart.defaults.borderColor = "#9ca3af"
Chart.defaults.font.family = "'Poppins', 'sans-serif'"
Chart.defaults.font.size = 12
Chart.defaults.font.weight = 'bold'
Chart.defaults.font.lineHeight = 1.5
Chart.defaults.layout.padding = 16
Chart.defaults.plugins.legend.position = "bottom"
Chart.defaults.plugins.title.display = true
Chart.defaults.plugins.title.padding = 16