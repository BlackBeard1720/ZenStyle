import ApexCharts from "apexcharts";


// ===== chartThree - Revenue Chart
const chart03 = () => {
  // Lấy dữ liệu từ window object (được set từ Blade view)
  
  const data = window.revenueChartData || {
    
    labels: [
      "Jan", "Feb", "Mar", "Apr", "May", "Jun",
      "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
    ],
    values: [40, 30, 50, 40, 55, 40, 70, 100, 110, 120, 150, 140],
    totalRevenue: 1000000,
    year: 2026,
  };

  const chartThreeOptions = {
    series: [
      {
        name: "Revenue",
        data: data.values,
      },
    ],
    legend: {
      show: false,
      position: "top",
      horizontalAlign: "left",
    },
    colors: ["#465FFF"],
    chart: {
      fontFamily: "Outfit, sans-serif",
      height: 310,
      type: "area",
      toolbar: {
        show: false,
      },
    },
    fill: {
      gradient: {
        enabled: true,
        opacityFrom: 0.55,
        opacityTo: 0,
      },
    },
    stroke: {
      curve: "straight",
      width: 2,
    },
    markers: {
      size: 0,
    },
    labels: {
      show: false,
      position: "top",
    },
    grid: {
      xaxis: {
        lines: {
          show: false,
        },
      },
      yaxis: {
        lines: {
          show: true,
        },
      },
    },
    dataLabels: {
      enabled: false,
    },
    tooltip: {
      x: {
        format: "MMM",
      },
      y: {
        formatter: function (value) {
          return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            maximumFractionDigits: 0,
          }).format(value);
        },
        title: {
          formatter: () => "Revenue",
        }
      },
    },
    xaxis: {
      type: "category",
      categories: data.labels,
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      tooltip: false,
    },
    yaxis: {
      title: {
        style: {
          fontSize: "0px",
        },
      },
    },
  };

  const chartSelector = document.querySelectorAll("#chartThree");

  if (chartSelector.length) {
    const chartThree = new ApexCharts(
      document.querySelector("#chartThree"),
      chartThreeOptions,
    );
    chartThree.render();    window.charts = window.charts || {};
    window.charts.revenueChart = chartThree;  }
};

export default chart03;