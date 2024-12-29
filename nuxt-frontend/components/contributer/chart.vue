<template>
  <div ref="container" class="chart-container">
    <svg ref="chart"></svg>
  </div>
</template>

<script>
import * as d3 from 'd3';

export default {
  name: 'LineChartWithCurvatureAndGrid',
  props: {
    data: {
      type: Array,
      required: true,
    },
    height: {
      type: Number,
      default: 300
    },
    color: {
      type: String,
      default: 'steelblue' // Default line and gradient color
    },
    textColor: {
      type: String,
      default: '#000' // Default text color for axis labels
    },
    curvature: {
      type: Number,
      default: 0.5 // Default curvature radius
    }
  },
  data() {
    return {
      width: 0 // To hold the dynamic width
    };
  },
  methods: {
    drawChart() {
      const { data, height, width, color, textColor, curvature } = this;
      const padding = 40;

      if (width === 0) return; // Don't draw if width is not yet calculated

      // Parse date strings into JavaScript Date objects
      const parseTime = d3.timeParse("%Y-%m-%d %H:%M");
      const formattedData = data.map(d => ({
        date: parseTime(d.date),
        value: d.value
      }));

      // Clear previous chart content
      d3.select(this.$refs.chart).selectAll("*").remove();

      // Define the SVG and set its dimensions
      const svg = d3.select(this.$refs.chart)
        .attr("width", width)
        .attr("height", height);

      // Create and append a gradient for the area fill
      const defs = svg.append("defs");

      const gradient = defs.append("linearGradient")
        .attr("id", "area-gradient")
        .attr("x1", "0%")
        .attr("y1", "0%")
        .attr("x2", "0%")
        .attr("y2", "100%");

      gradient.append("stop")
        .attr("offset", "0%")
        .attr("stop-color", color)
        .attr("stop-opacity", 0.7); // Solid color at the top

      gradient.append("stop")
        .attr("offset", "100%")
        .attr("stop-color", color)
        .attr("stop-opacity", 0); // Transparent at the bottom

      // Create scales
      const xScale = d3.scaleTime()
        .domain(d3.extent(formattedData, d => d.date))
        .range([padding + 15, width - padding]);

      const yScale = d3.scaleLinear()
        .domain([0, d3.max(formattedData, d => d.value)])
        .range([height - padding, padding]);

      // Create the line generator with the specified curvature
      const line = d3.line()
        .curve(d3.curveCatmullRom.alpha(curvature)) // Use the curvature prop
        .x(d => xScale(d.date))
        .y(d => yScale(d.value));

      // Create the area generator
      const area = d3.area()
        .curve(d3.curveCatmullRom.alpha(curvature)) // Same curve as line
        .x(d => xScale(d.date))
        .y0(height - padding + 15) // Bottom of the area (at the bottom of the chart)
        .y1(d => yScale(d.value));

      // Append the area with the gradient fill
      svg.append("path")
        .datum(formattedData)
        .attr("fill", "url(#area-gradient)") // Apply the gradient
        .attr("d", area); // Draw the area

      // Append the path (the line) on top of the area
      svg.append("path")
        .datum(formattedData)
        .attr("fill", "none")
        .attr("stroke", color) // Use the color prop for the line
        .attr("stroke-width", 2)
        .attr("d", line);

      // Add grid lines on the Y-axis (dotted lines)
      svg.append("g")
        .attr("class", "grid")
        .attr("transform", `translate(${padding + 15}, 0)`)
        .call(d3.axisLeft(yScale)
          .ticks(5) // Set the number of ticks
          .tickSize(-width + padding * 2)
          .tickFormat(''))
        .selectAll("line")
        .attr("stroke", "gray")
        .attr("stroke-dasharray", "5,10"); // Dotted lines

      // Add x-axis (time)
      svg.append("g")
        .attr("transform", `translate(0, ${height - padding + 15})`)
        .call(d3.axisBottom(xScale)
          .ticks(d3.timeMinute.every(15)) // Scale by 15-minute intervals
          .tickFormat(d3.timeFormat("%H:%M")) // Format time as HH:MM
          .tickSize(0)) // Set tick size to 0 to hide the ticks

        .selectAll("text")
        .attr("fill", textColor) // Set text color from prop
        .style("margin", "5px"); // Add margin to text


      // Add y-axis (value)
      svg.append("g")
        .attr("transform", `translate(${padding}, 0)`)
        .call(d3.axisLeft(yScale).ticks(5).tickSize(0)) // Hide tick lines
        .selectAll("text")
        .attr("fill", textColor) // Set text color from prop
        .style("margin", "5px"); // Add margin to text

      // Remove axis lines
      svg.selectAll(".domain").remove();
    },
    updateChartSize() {
      const containerWidth = this.$refs.container.clientWidth;
      this.width = containerWidth;
      this.drawChart();
    }
  },
  mounted() {
    this.updateChartSize();
    window.addEventListener('resize', this.updateChartSize);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.updateChartSize);
  },
  watch: {
    data() {
      this.drawChart(); // Redraw chart if data changes
    },
    color() {
      this.drawChart(); // Redraw chart if color changes
    },
    textColor() {
      this.drawChart(); // Redraw chart if text color changes
    },
    curvature() {
      this.drawChart(); // Redraw chart if curvature changes
    }
  }
};
</script>

<style scoped>
.chart-container {
  width: 100%;
}
</style>
