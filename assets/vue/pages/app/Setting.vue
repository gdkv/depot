<script setup>

import CustomSelect from "../../components/UI/customSelect.vue";
import {
  trans,
  MAIN_SETTINGS_TITLE
} from '../../../translator';
import {ref} from "vue";

const changeSelect = (event) => {
  console.log('select is change');
  console.log(event);
}

const selectedPlan = ref('free-plan-variants');

const planTypes = [
  {'title': 'Start', 'description': 'Free',  'suffix': '', 'isCurrent': true, "id": "free-plan-variants" },
  {'title': 'Pro', 'description': '$ 6', 'suffix': '/mo', 'isCurrent': false, "id": "pro-plan-variants" },
  {'title': 'Ultimate', 'description': '$ 16', 'suffix': '/mo',  'isCurrent': false,  "id": "ultimate-plan-variants" }
];

const planVariant = {
  freeType: [
    {'title': 'Select free subscription', 'price': '' },
  ],
  proType: [
    {'title': '1 month Pro subscription', 'price': '$ 6' },
    {'title': '3 month Pro subscription', 'price': '$ 16' },
    {'title': '6 month Pro subscription', 'price': '$ 32' },
    {'title': '1 year Pro subscription', 'price': '$ 66' }
  ],
  ultimateType: [
    {'title': '1 month Ultimate subscription', 'price': '$ 16' },
    {'title': '3 month Ultimate subscription', 'price': '$ 46' },
    {'title': '6 month Ultimate subscription', 'price': '$ 90' },
    {'title': '1 year Ultimate subscription', 'price': '$ 180' }
  ],
};

const selectPlan = (planId) => {
  selectedPlan.value = planId;
}
</script>

<template>
  <section class="dashboard">
    <h1>{{ trans(MAIN_SETTINGS_TITLE) }}</h1>

    <div class="setting-line">
      <div class="setting-section">
        <h3>Profile</h3>

        <div class="form-content">
          <div class="form-inner">
            <div class="form-row">
              <input class="input small" placeholder="Name" type="text" name="name" value="">

              <div class="input small">
                <input placeholder="Email" type="email" name="email" value=""  disabled>
                <div class="info-line">
                  You can’t change your register email, but you can set another for getting reports
                </div>
              </div>
            </div>

            <div class="form-row">
              <custom-select
                  :options="['go', 'python', 'rust', 'javascript']"
                  :default="'go'"
                  class="select"
                  @input="changeSelect($event)"
              />
            </div>

            <button type="submit" class="btn btn-blue">
              Edit
            </button>

          </div>

        </div>
      </div>

    </div>

    <div class="setting-line">
      <div class="setting-section">
        <h3>Change password</h3>

        <div class="form-content">
          <div class="form-inner">

            <input class="input" placeholder="New password" id="password" type="password"  name="password" required autocomplete="new-password">
            <input class="input" placeholder="Confirm new password" id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">

            <button type="submit" class="btn btn-blue">
              Set new password
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="setting-line">
      <div class="setting-section">
        <h3>Account type</h3>

        <div class="limit wrapper">
          <!--include('app.partials.plan', )-->
          <!--include('app.partials.plan', )-->
          <!--include('app.partials.plan', )-->

          <div class="plan item" v-for="plan in planTypes">
            <div class="room-block">
              <div class="room-block_header" v-text="plan.title" />
              <div class="room-block_content">
                {{ plan.description }}
                <span class="room-block_content__suffix">{{ plan.suffix }}</span>
              </div>

              <button class="btn btn-transparent current" v-if="plan.isCurrent">
                Current
              </button>
              <a href="#" @click="selectPlan(plan.id)" class="toogle btn btn-blue" v-else>
                Choose
              </a>

            </div>
          </div>

        </div>

        <div class="toogle-block variants" id="free-plan-variants">

          <div class="variant" v-for="variant in planVariant.freeType">
            <div class="">
              <div class="title" v-text="variant.title" />
              <div class="price" v-if="variant.price"  v-text="variant.price" />
            </div>
            <div class="button">
              <a v-if="variant.price" class="btn btn-red" href="https://securepay.tinkoff.ru/rest/Authorize/1B63Y1" target="_blank">
                Buy
              </a>
              <form v-else action="#" method="POST">
                <input type="hidden" name="plan" value="1" />
                <button type="submit" class="btn btn-red">
                  Change
                </button>
              </form>
            </div>
          </div>
        </div>

        <div class="toogle-block variants active" id="pro-plan-variants">
          <!--include('app.partials.plan_variants', )-->
          <!--include('app.partials.plan_variants', )-->
          <!--include('app.partials.plan_variants', )-->
          <!--include('app.partials.plan_variants', )-->
          <div class="variant" v-for="variant in planVariant.proType">
            <div class="">
              <div class="title" v-text="variant.title" />
              <div class="price" v-if="variant.price"  v-text="variant.price" />
            </div>
            <div class="button">
              <a v-if="variant.price" class="btn btn-red" href="https://securepay.tinkoff.ru/rest/Authorize/1B63Y1" target="_blank">
                Buy
              </a>
              <form v-else action="#" method="POST">
                <input type="hidden" name="plan" value="1" />
                <button type="submit" class="btn btn-red">
                  Change
                </button>
              </form>
            </div>
          </div>
        </div>

        <div class="toogle-block variants" id="ultimate-plan-variants">
          <!--include('app.partials.plan_variants', )-->
          <!--include('app.partials.plan_variants', )-->
          <!--include('app.partials.plan_variants', )-->
          <!--include('app.partials.plan_variants', )-->
          <div class="variant" v-for="variant in planVariant.ultimateType">
            <div class="">
              <div class="title" v-text="variant.title" />
              <div class="price" v-if="variant.price"  v-text="variant.price" />
            </div>
            <div class="button">
              <a v-if="variant.price" class="btn btn-red" href="https://securepay.tinkoff.ru/rest/Authorize/1B63Y1" target="_blank">
                Buy
              </a>
              <form v-else action="#" method="POST">
                <input type="hidden" name="plan" value="1" />
                <button type="submit" class="btn btn-red">
                  Change
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="setting-line">
      <div class="setting-section">
        <h3>Theme</h3>

        <div class="form-content">
          <div class="form-inner">

            <div class="theme-switcher">
              <label class="switch">
                <input type="hidden" name="theme" value="0" />
                <input type="checkbox" name="theme" value="1" checked />
                <span class="slider round"></span>
              </label>

              Dark mode
            </div>

            <div class="info-line">
              Only members with Pro or Ultimate accounts can choose
              Dark mode theme. You can try 2-weeks Pro trial, just send
              a letter to us support@welasensor.ru
            </div>

            <button type="submit" class="btn btn-blue">
              Save
            </button>
          </div>
        </div>
      </div>
    </div>

  </section>
</template>

<style scoped lang="scss">

</style>