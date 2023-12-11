<template>
    <section class="top">
      <div class="left">
        <h1 v-html="header" />
        <p v-text="description" />
      </div>
      <div class="right"></div>
    </section>

    <div class="items">
      <div class="item" :class="{'item-2x': sensor.isBig}" v-for="sensor in sensorType" key="sensor.id">
        <div class="item-title" v-text="sensor.name" />
        <div class="item-text" v-html="sensor.description" />
        <div class="item-price" v-text="sensor.price" />
      </div>
    </div>
</template>

<script setup>

  import { trans, MAIN_PAGES_BUY_HEADER, MAIN_PAGES_BUY_DESCRIPTION} from '../../translator';

  const header = trans(MAIN_PAGES_BUY_HEADER)
  const description = trans(MAIN_PAGES_BUY_DESCRIPTION)

  const sensorType = [
    {
      id: 'base',
      name: "Basic",
      description: "<p>A small Depot sensor the size of a matchbox, which can be connected anywhere in the house where there is a charger, and it is also compatible with work from powerbank.</p><p>Get temperature, humidity,  pressure, luminosity, noise level</p><p>You can choose corpuse material from plastic or wood</p><p>Free cloud web application</p>",
      price: 39,
      isBig: true
    },
    {
      id: 'co2',
      name: "CO2",
      description: "<p class='red'>All in basic</p> <p>Get CO2 level</p> <p>You can choose corpus material from plastic, wood and waterproof metal for outside use</p>",
      price: 49,
      isBig: false
    }
  ];
</script>

<style lang="scss"></style>
