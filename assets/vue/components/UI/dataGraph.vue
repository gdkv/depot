<template>
  <div :class="{
    'data_graph': true,
    'loaded': isLoaded
  }" v-html="svgImage" />
</template>
<style lang="scss">
  .data_graph {
    transform: scale(0);
    transition: all .5s;
    position: absolute;

    &.loaded {
      transform: scale(1);
    }

    svg {
      width: 250px;
      height: 200px;
    }
  }
</style>
<script setup>
  import {onMounted, ref} from "vue";

  const isLoaded = ref(false);
  const svgImage = ref('');
  const props = defineProps({
    measure: Array,
    color: String,
    type: String
  });

  onMounted(async () => {
    await fetch("https://quickchart.io/chart", {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      method: "POST",
      body: JSON.stringify({
        "version": 2,
        "height": 200,
        "width": 250,
        "backgroundColor": 'transparent',
        "format": 'svg',
        "chart": {
          "type": 'line',
          "data": {
            "labels": props.measure,
            "datasets": [
              {
                "borderJoinStyle": 'round',
                "label": false,
                "data": props.measure,
                "borderColor": props.color,
                "fill": false,
                "lineTension": 0.2
              }
            ]
          },
          "options": {
            "scales": {
              "yAxes": [
                {
                  "gridLines": {
                    "display": false
                  },
                  "ticks": {
                    "display": false
                  }
                }
              ],
              "xAxes": [
                {
                  "gridLines": {
                    "display": false
                  },
                  "ticks": {
                    "display": false
                  }
                }
              ]
            },
            "legend": {
              "labels": {
                "generateLabels": "function(chart) { return ''; }"
              }
            },
            "elements": {
              "point": {
                "radius": 0
              }
            }
          }
        }
      })
    })
        .then(async (res) => {
          svgImage.value = await res.text();
          isLoaded.value = true;
          console.log(isLoaded.value);
        })
        .catch(console.error.bind(console));
  });
</script>
<style lang="scss" module>
.data_graph {
  position: absolute;
  z-index: 1;
  width: 100%;
  top: -10px;
  left: -15px;
}
</style>