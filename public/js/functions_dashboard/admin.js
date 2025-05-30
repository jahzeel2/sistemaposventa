import {graphics_show} from "../export_funcion/graphics.js";
/* global Chart:false */
class adminuser{

}

class get_data extends adminuser{
    get_sales = async (ruta) => {
      try {
          // read our JSON
	        let response = await fetch(ruta);
	        let data = await response.json();
	        console.log(data)
          let show_total = document.querySelector(".show_total_today").textContent = data.sale_today;
          this.graphics(data);
      } catch (error) {
          console.log(error);
      }
    }

    graphics = (data) => {
      let get_today_total = data.sale_today;
      let today_date = data.today_date;
      let yesterday_date = data.yesterday_date;
      let get_yesterday_total = data.sale_yesterday;

      'use strict'

      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }

      var mode = 'index'
      var intersect = true

      var $salesChart = $('#sales-chart')
      // eslint-disable-next-line no-unused-vars
      var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
          labels: [today_date],
          datasets: [
            {
              label: 'ventas $',
              backgroundColor: '#81E386',
              borderColor: '#007bff',
              data: [get_today_total],
              barPercentage: 0.1,
            }
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
      });
      /************************************************* */
      let up_down_sales =document.querySelector("#up_down");
      let fas_estatus = document.querySelector("#fas_estatus");
      let span_estatus = document.querySelector("#span_estatus");
      let cant_today = parseFloat(get_today_total);
      let cant_yesterday = parseFloat(get_yesterday_total);
      if (cant_today > cant_yesterday) {  
          span_estatus.className = "text-success";
          fas_estatus.className = "fas fa-arrow-up";
          up_down_sales.textContent = "Mas ventas";
      }else{
          span_estatus.className = "text-danger";
          fas_estatus.className = "fas fa-arrow-down";
          up_down_sales.textContent = "Menos ventas";
      }
      //varibles globals for graphics two 
      let idgraphics = document.querySelector("#sales-chart-comparation");
      let labels = ["Ventas"]; 
      let type_graphics = "bar";
      let newdata1 = {
        label: today_date,
        backgroundColor: "#00FA9A",
        borderColor: "#007bff",
        data: [get_today_total],
      };
      let newdata2 = {
        label: yesterday_date,
        backgroundColor: "#8A2BE2",
        borderColor: "#ced4da",
        data: [get_yesterday_total],
      };
      /**Call the function*/
      graphics_show(idgraphics,labels,newdata1,newdata2,type_graphics);

    }
    
}

const getdata = new get_data();
let returndata = getdata.get_sales("/get-data-sales");
