<template>
  <section class="dashboard">
    <div class="info-line">
      Последние данные: 10.01.2024 10:01:22
    </div>

    <div class="last-data" data-slideout-ignore>
      <a href="#" class="data active">
        <div class="data-graph">
          <img src="https://quickchart.io/chart?c={type:'line',data:{
            labels:[22,22,21,10,15,16,26,19,22,24,25,26],
            datasets:[
                {
                    label: false,
                    data: [22,22,21,10,15,16,26,19,22,24,25,26],
                    fill:false,
                    borderColor: 'rgba(252, 92, 125, 1)',
                    lineTension: 0.2,
                    borderJoinStyle: 'round'
                }
            ]
          },
          options: {
              elements: { point:{ radius: 0 } }, legend: { labels: { generateLabels: function(chart) { return ''; } } },
              scales: { yAxes: [{ gridLines : { display : false }, ticks: { display: false } }], xAxes: [{ gridLines : { display : false }, ticks: { display: false } }] }
          }}&w=250&h=200" width="250" height="200" alt="temperature data" />
        </div>


        <div class="is-limit">lim</div>

        <div class="data-info">
          <div class="name">
            Temperature
          </div>
          <div class="value">N/A</div>
        </div>

      </a>
      <a href="#" class="data active">

        <div class="data-graph">
          <img src="https://quickchart.io/chart?c={type:'line',data:{
            labels:[22,22,21,10,15,16,26,19,22,24,25,26],
            datasets:[
                {
                    label: false,
                    data: [82,82,81,80,75,86,86,89,82,74,85,96],
                    fill:false,
                    borderColor: 'rgba(255, 188, 66, 1)',
                    lineTension: 0.2,
                    borderJoinStyle: 'round'
                }
            ]
          },
          options: {
              elements: { point:{ radius: 0 } }, legend: { labels: { generateLabels: function(chart) { return ''; } } },
              scales: { yAxes: [{ gridLines : { display : false }, ticks: { display: false } }], xAxes: [{ gridLines : { display : false }, ticks: { display: false } }] }
          }}&w=250&h=200" width="250" height="200" alt="temperature data" />
        </div>

        <div class="is-limit"></div>

        <div class="data-info">
          <div class="name">
            Humidity
          </div>
          <div class="value">n/a</div>
        </div>

      </a>
      <a href="#" class="data">

        <div class="data-graph">
          <img src="https://quickchart.io/chart?c={type:'line',data:{
            labels:[22,22,21,10,15,16,26,19,22,24,25,26],
            datasets:[
                {
                    label: false,
                    data: [82,82,81,80,75,86,86,89,82,74,85,96],
                    fill:false,
                    borderColor: 'rgba(48, 169, 222, 1)',
                    lineTension: 0.2,
                    borderJoinStyle: 'round'
                }
            ]
          },
          options: {
              elements: { point:{ radius: 0 } }, legend: { labels: { generateLabels: function(chart) { return ''; } } },
              scales: { yAxes: [{ gridLines : { display : false }, ticks: { display: false } }], xAxes: [{ gridLines : { display : false }, ticks: { display: false } }] }
          }}&w=250&h=200" width="250" height="200" alt="temperature data" />
        </div>

        <div class="is-limit"></div>

        <div class="data-info">
          <div class="name">
            Lux
          </div>
          <div class="value">n/a</div>
        </div>

      </a>
      <a href="#" class="data">

        <div class="data-graph">
          <img src="https://quickchart.io/chart?c={type:'line',data:{
            labels:[22,22,21,10,15,16,26,19,22,24,25,26],
            datasets:[
                {
                    label: false,
                    data: [82,82,81,80,75,86,86,89,82,74,85,96],
                    fill:false,
                    borderColor: 'rgba(108, 73, 184, 1)',
                    lineTension: 0.2,
                    borderJoinStyle: 'round'
                }
            ]
          },
          options: {
              elements: { point:{ radius: 0 } }, legend: { labels: { generateLabels: function(chart) { return ''; } } },
              scales: { yAxes: [{ gridLines : { display : false }, ticks: { display: false } }], xAxes: [{ gridLines : { display : false }, ticks: { display: false } }] }
          }}&w=250&h=200" width="250" height="200" alt="temperature data" />
        </div>

        <div class="is-limit"></div>

        <div class="data-info">
          <div class="name">
            Noise
          </div>
          <div class="value">n/a</div>
        </div>
      </a>
      <a href="#" class="data">


        <div class="data-graph">
          <img src="https://quickchart.io/chart?c={type:'line',data:{
            labels:[22,22,21,10,15,16,26,19,22,24,25,26],
            datasets:[
                {
                    label: false,
                    data: [82,82,81,80,75,86,86,89,82,74,85,96],
                    fill:false,
                    borderColor: 'rgba(103, 213, 181, 1)',
                    lineTension: 0.2,
                    borderJoinStyle: 'round'
                }
            ]
          },
          options: {
              elements: { point:{ radius: 0 } }, legend: { labels: { generateLabels: function(chart) { return ''; } } },
              scales: { yAxes: [{ gridLines : { display : false }, ticks: { display: false } }], xAxes: [{ gridLines : { display : false }, ticks: { display: false } }] }
          }}&w=250&h=200" width="250" height="200" alt="temperature data" />
        </div>

        <div class="is-limit"></div>

        <div class="data-info">
          <div class="name">
            Pressure
          </div>
          <div class="value">n/a</div>
        </div>
      </a>
      <a href="#" class="data">
        <div class="data-graph"></div>

        <div class="is-limit"></div>

        <div class="data-info">
          <div class="name">
            CO<sub>2</sub>
          </div>
          <div class="value">n/a</div>
        </div>
      </a>

    </div>

    <h1>test</h1>

    <section class="full-chart" data-slideout-ignore>
      <canvas
          id="myChart"
          data-measures-file=""
          data-measure-color=""></canvas>
    </section>
  </section>
</template>

<script setup>
import {onMounted} from "vue";
import useSensor from "../../../store/sensor";

const {sensors, fetchAll} = useSensor();

onMounted(async () => {
  await fetchAll();
});
</script>

<style lang="scss"></style>
