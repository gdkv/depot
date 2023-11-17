<template>
    <h1> {{ transName }}!</h1>
</template>

<script setup>
  import { trans, MAIN_VUE_HELLO} from '../../translator';

    const transName = trans(MAIN_VUE_HELLO)

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
