import { Chart, Legend, Title, Tooltip } from "chart.js";

Chart.register(Legend, Title, Tooltip)
Chart.defaults.color = "#1f2937"
Chart.defaults.borderColor = "#9ca3af"
Chart.defaults.font.size = 14
Chart.defaults.font.weight = 'bold'
Chart.defaults.font.lineHeight = 1.5
Chart.defaults.layout.padding = 16
Chart.defaults.plugins.legend.position = "bottom"