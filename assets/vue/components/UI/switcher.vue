<script setup>
import {getCurrentInstance} from "vue";

const props = defineProps({
  switchers: Array
});

const instance = getCurrentInstance();

const switcherClick = (switcher) => {
  instance.proxy.$emit('switcherClick', switcher);
};
</script>

<template>
  <div :class="$style.switchers">
    <div @click="switcherClick(switcher)" :class="{
      [$style.switcher]: true,
      [$style.active]: switcher.active
    }" v-for="switcher in switchers">
        <div :class="$style.text">{{ switcher.text }}</div>
        <div :class="$style.date">{{ switcher.info }}</div>
      </div>
  </div>
</template>

<style scoped lang="scss" module>
.switchers {
  display: flex;
  justify-content: flex-start;
}
.switcher {
  height: 46px;
  border-radius: 8px;
  background-color: #F5F5F5;
  line-height: 46px;
  padding: 0 20px;
  cursor: pointer;
  gap: 25px;

  .text {
    //font-family: '', Arial, sans-serif;
    font-weight: 300;
    font-size: 18px;
    color: #000000;
  }

  .date {
    //font-family: 'rubik', Arial, sans-serif;
    font-weight: 300;
    font-size: 14px;
    color: #FFFFFF;
    border-radius: 8px;
    background-color: #EF476F;
    line-height: 21px;
    padding: 0 15px;
  }

  &.active {
    background-color: #06D6A0;

    .date {
      color: #000000;
      background-color: #FFFFFF;
    }
  }
}
</style>