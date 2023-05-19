<template>
    <h1>Hello {{ name }}!</h1>
</template>

<script setup>
    defineProps({
        name: String
    });
</script>

<style lang="scss">
  h1 {
    color: #dbeafe;
    font-size: 36px;
  }

</style>
