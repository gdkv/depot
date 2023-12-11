<template>
  <section class="top">
    <div class="left">
      <h1>{{ header }}</h1>
      <p>{{ description }}</p>
    </div>
    <div class="right"></div>
  </section>

  <section v-for="depotSection in depotSections" key="depotSection.id">
    <div class="section">
      <div class="section-title">
        {{ depotSection.name }}
      </div>
      <div class="section-description">
        <p>{{ depotSection.info }}</p>
      </div>
    </div>
  </section>

</template>

<script setup>
  import {
    trans,
    MAIN_PAGES_DOWNLOAD_HEADER,
    MAIN_PAGES_DOWNLOAD_DESCRIPTION,
    MAIN_PAGES_DOWNLOAD_DEPOT_TOOL,
    MAIN_PAGES_DOWNLOAD_DEPOT_TOOL_INFO,
    MAIN_PAGES_DOWNLOAD_DEPOT_STANDALONE,
    MAIN_PAGES_DOWNLOAD_DEPOT_STANDALONE_INFO,
    MAIN_PAGES_DOWNLOAD_DEPOT_REST,
    MAIN_PAGES_DOWNLOAD_DEPOT_REST_INFO
  } from '../../translator';

  const header = trans(MAIN_PAGES_DOWNLOAD_HEADER)
  const description = trans(MAIN_PAGES_DOWNLOAD_DESCRIPTION)

  const depotSections = [
    { id: 'depotTool', name: trans(MAIN_PAGES_DOWNLOAD_DEPOT_TOOL), info: trans(MAIN_PAGES_DOWNLOAD_DEPOT_TOOL_INFO) },
    { id: 'depotStandalone', name: trans(MAIN_PAGES_DOWNLOAD_DEPOT_STANDALONE), info: trans(MAIN_PAGES_DOWNLOAD_DEPOT_STANDALONE_INFO) },
    { id: 'depotRest', name: trans(MAIN_PAGES_DOWNLOAD_DEPOT_REST), info: trans(MAIN_PAGES_DOWNLOAD_DEPOT_REST_INFO) },
  ];

</script>

<style lang="scss"></style>
