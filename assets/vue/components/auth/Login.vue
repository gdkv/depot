<template>
  <div class="form-wrapper" :class="$style.form_wrapper">
    <div class="form form-aside" :class="$style.form">
      <div class="form-header" v-text="trans(MAIN_FORM_LOGIN_HEADER)" />
      <div class="form-content">

        <div class="form-inner">
          <div class="form-row">
            <input id="email" type="email" :placeholder="trans(MAIN_FORM_LOGIN_EMAIL)"  name="email" value="" required autocomplete="email" autofocus>
          </div>
          <div class="form-row">
            <input :class="$style.password__input" id="password" :type="passwordInputType" :placeholder="trans(MAIN_FORM_LOGIN_PASSWORD)"  name="password" required autocomplete="current-password">
            <span class="input-badge input-badge_password" :class="passwordViewClass" @click="passwordViewToggle"></span>
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
  // import useCurrentUser from "../../store/user";
  import AuthService from "../../services/auth.service";
  import {ref} from "vue";

  // const {currentUser, token, auth} = useCurrentUser();
  const isPasswordView = ref(false);
  const passwordViewClass = ref('password-hide');
  const passwordInputType = ref('password');

  const loginSubmit = () => {
    AuthService
        .login('test@test.com', '1111')
        .then(token => {
          console.log(token);
        });
  };

  const passwordViewToggle = () => {
    isPasswordView.value = !isPasswordView.value;
    if (isPasswordView.value) {
      passwordViewClass.value = 'password-show';
      passwordInputType.value = 'text';
    } else {
      passwordViewClass.value = 'password-hide';
      passwordInputType.value = 'password';
    }
  };
</script>

<style scoped module lang="scss">
.form_wrapper {
  .form {
    .password__input {

      &::placeholder {
        font-family: 'Gilroy', sans-serif;
      }
    }
  }
}
</style>