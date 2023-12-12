<template>
  <div class="form-wrapper">
    <div class="form form-aside">
      <div class="form-header" v-text="trans(MAIN_FORM_LOGIN_HEADER)" />
      <div class="form-content">

        <div class="form-inner">
          <div class="form-row">
            <input id="email" type="email" :placeholder="trans(MAIN_FORM_LOGIN_EMAIL)"  class="" name="email" value="" required autocomplete="email" autofocus>
          </div>
          <div class="form-row">
            <input id="password" type="password" :placeholder="trans(MAIN_FORM_LOGIN_PASSWORD)"  class="" name="password" required autocomplete="current-password">
            <span class="input-badge input-badge_password password-hide"></span>
          </div>
          <button @click="loginSubmit" v-text="trans(MAIN_FORM_LOGIN_SUBMIT)" />
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
  import {
    trans,
    MAIN_FORM_LOGIN_HEADER,
    MAIN_FORM_LOGIN_EMAIL,
    MAIN_FORM_LOGIN_PASSWORD,
    MAIN_FORM_LOGIN_SUBMIT
  } from '../../../translator';
  import useCurrentUser from "../../store/user";
  const {currentUser, token, auth} = useCurrentUser();

  const loginSubmit = () => {
    auth('test@test.com', '1111')
        .then(() => {
          console.log(token);
        });
  };


</script>