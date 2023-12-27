<script setup>
import {onMounted, ref} from "vue";
  import {
    trans,
    MAIN_COOKIE_INFO,
    MAIN_COOKIE_LINK
  } from '../../../translator';

  const cookieInfo = trans(MAIN_COOKIE_INFO);
  const cookieLink = trans(MAIN_COOKIE_LINK);
  const isView = ref(true);

  const cookieHide = () => {
    localStorage.setItem('isCookieHide', '1');
    isView.value = false;
  };

  onMounted(() => {
    if(localStorage.getItem('isCookieHide')){
      isView.value = false;
    }
  });
</script>

<template>
  <div class="cookie" v-if="isView">
    <div class="cookie-icon">
      <img src="/build/images/cookie.png" alt="" />
    </div>
    <div class="cookie-text">
      {{ cookieInfo }} <a href="">{{ cookieLink }}</a>
    </div>
    <div class="cookie-close" @click="cookieHide">
      <img src="/build/images/cross.svg" alt="" />
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>