import ApexCharts from "apexcharts";

export function initializePieCategoryChart() {
  const data = window.categoryUsageData;

  if (!data || !data.labels || data.labels.length === 0) {
    return;
  }

  const colors = [
    '#E0E7FF',
    '#A5B4FC',
    '#3B82F6',
    '#1E3A8A',
    '#0F172A',
    '#6366F1',
    '#4F46E5',
    '#4338CA',
  ];

  const options = {
    series: data.values,
    labels: data.labels,
    chart: {
      type: 'pie',
      width: '100%',
      height: 300,
      fontFamily: 'inherit',
      toolbar: {
        show: false,
      },
      animations: {
        enabled: true,
      },
      redrawOnParentResize: true,
      parentHeightOffset: 0,
    },
    colors: colors.slice(0, data.labels.length),
    dataLabels: {
      enabled: true,
      formatter: (val, opts) => {
        const globals = opts?.w?.globals;
        const percent = globals?.seriesPercent?.[opts.seriesIndex]?.[opts.dataPointIndex];
        if (typeof percent === 'number') {
          return `${percent.toFixed(1)}%`;
        }
        return `${Number(val).toFixed(1)}%`;
      },
      style: {
        fontSize: '13px',
        fontWeight: '600',
        colors: ['#ffffff'],
      },
      dropShadow: {
        enabled: false,
      },
    },
    stroke: {
      width: 2,
      colors: ['#fff'],
    },
    plotOptions: {
      pie: {
        expandOnClick: true,
        offsetY: 10,
        customScale: 1,
        startAngle: 0,
        endAngle: 360,
      },
    },
    legend: {
      position: 'bottom',
      horizontalAlign: 'center',
      fontSize: '13px',
      fontWeight: '500',
      itemMargin: {
        horizontal: 10,
        vertical: 4,
      },
      markers: {
        radius: 12,
        width: 10,
        height: 10,
      },
    },
    responsive: [
      {
        breakpoint: 1536,
        options: {
          chart: {
            width: '100%',
          },
          legend: {
            position: 'bottom',
          },
        },
      },
    ],
  };

  const chartElement = document.getElementById('chartPieCategory');
  if (chartElement) {
    const chart = new ApexCharts(chartElement, options);
    chart.render();

    if (!window.charts) {
      window.charts = {};
    }
    window.charts.pieCategory = chart;
  }
}
