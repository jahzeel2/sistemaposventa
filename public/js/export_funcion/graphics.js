export function graphics_show(idgraphics,labels,newdata1,newdata2,type_graphics) {
  "use strict";

  var ticksStyle = {
    fontColor: "#495057",
    fontStyle: "bold",
  };

  var mode = "index";
  var intersect = true;

  var $salesChartcomparation = $(idgraphics);
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChartcomparation, {
    type: type_graphics,
    data: {
      labels: labels,
      datasets: [
        {
          label: newdata1.label,
          backgroundColor: newdata1.backgroundColor,
          borderColor: newdata1.borderColor,
          data: newdata1.data,
          barPercentage: 0.2,
        },
        {
          label: newdata2.label,
          backgroundColor: newdata2.backgroundColor,
          borderColor: newdata2.borderColor,
          data: newdata2.data,
          barPercentage: 0.2,
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect,
      },
      hover: {
        mode: mode,
        intersect: intersect,
      },
      legend: {
        display: false,
      },
      scales: {
        yAxes: [
          {
            // display: false,
            gridLines: {
              display: true,
              lineWidth: "4px",
              color: "rgba(0, 0, 0, .2)",
              zeroLineColor: "transparent",
            },
            ticks: $.extend(
              {
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                  if (value >= 1000) {
                    value /= 1000;
                    value += "k";
                  }

                  return "$" + value;
                },
              },
              ticksStyle
            ),
          },
        ],
        xAxes: [
          {
            display: true,
            gridLines: {
              display: false,
            },
            ticks: ticksStyle,
          },
        ],
      },
    },
  });
}

export function graphics_show1(idgraphics, labels, newdata1, type_graphics){
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $(idgraphics)
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: type_graphics,
    data: {
      labels: labels,
      datasets: [
        {
          label: newdata1.label,
          borderColor: newdata1.borderColor,
          backgroundColor: newdata1.backgroundColor,
          data: newdata1.data,
          //barPercentage: 0.2,
        },
        /*{
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
        }*/
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
}
