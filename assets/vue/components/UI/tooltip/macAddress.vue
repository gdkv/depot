<template>
  <div :class="$style.tooltip_wrapper">
    <p v-text="trans(MAIN_PAGES_SENSOR_TOOLTIP)" />
  </div>
</template>
<script setup>
import {
  trans,
  MAIN_PAGES_SENSOR_TOOLTIP
} from '../../../../translator';
</script>
<style scoped lang="scss" module>
.tooltip_wrapper p {
  padding: 14px 0;
}
</style>