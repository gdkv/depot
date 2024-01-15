<template>
  <div :class="$style.tooltip_wrapper">
    <p>MAC address is a unique string number of your sensor device. It consist of 6 pairs of chars separate by dashes. Ex: A9-B8-C7-D6-E5-F4</p>
  </div>
</template>

<style scoped lang="scss" module>
.tooltip_wrapper p {
  margin-bottom: 14px;
}
</style>