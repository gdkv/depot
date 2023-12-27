<template>
  <sensors-nav />

  <sensors-dashboard />
</template>

<script setup>
import {onMounted} from "vue";
import useCurrentUser from "../../store/user";
import * as Turbo from "@hotwired/turbo";
import SensorsNav from "../../components/UI/sensor/nav.vue";
import SensorsDashboard from "../../components/UI/sensor/dashboard.vue";

const {currentUser, fetch} = useCurrentUser();

onMounted(async () => {
  await fetch();

  if (!currentUser.value) {
    Turbo.visit(`/`);
  }
});
</script>

<style lang="scss"></style>
