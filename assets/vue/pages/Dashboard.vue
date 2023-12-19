<template>
    <section class="top">
      <div class="left">
        <h1>App</h1>

      </div>
      <div class="right">

      </div>
    </section>
</template>

<script setup>
  import {onMounted} from "vue";
  import useCurrentUser from "../store/user";

  onMounted(() => {
    console.log('NEED AUTH CHECK');
    // if ()
  });

</script>

<style lang="scss"></style>
