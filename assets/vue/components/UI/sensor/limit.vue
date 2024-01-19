<script setup>
const props = defineProps({
  'title': String,
  'name': String,
  'max': Number,
  'min': Number
});
</script>

<template>
  <div class="limit-block">
    <div class="limit-block_header" v-html="title" />
    <div class="limit-block_content">
      <div class="line">
        <div class="line_label max">max</div>
        <div class="line_input">
          <input type="text" :value="max">
        </div>
        <div class="line_clear">
          <div class="clear-button"></div>
        </div>
      </div>
      <div class="line">
        <div class="line_label">min</div>
        <div class="line_input">
          <input type="text" :value="min">
        </div>
        <div class="line_clear">
          <div class="clear-button"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>