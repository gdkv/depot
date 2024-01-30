<script setup>
import {ref} from "vue";

const periodicity = [
  {'title': 'All', 'description': 'Monthly',  'suffix': '', 'isCurrent': true, "id": "free-plan-periodicity" },
  {'title': 'Pro, Ultimate', 'description': 'Biweekly', 'suffix': '', 'isCurrent': false, "id": "pro-plan-periodicity" },
  {'title': 'Ultimate only', 'description': 'Weekly', 'suffix': '',  'isCurrent': false,  "id": "ultimate-plan-periodicity" }
];

const format = [
  {'title': 'All', 'description': 'CSV',  'suffix': '', 'isCurrent': true, "id": "free-format-variants" },
  {'title': 'Pro, Ultimate', 'description': 'XLS', 'suffix': '', 'isCurrent': false, "id": "pro-format-variants" },
  {'title': 'Ultimate only', 'description': 'PDF', 'suffix': '',  'isCurrent': false,  "id": "ultimate-format-variants" }
];

const selectedPeriodicity = ref('free-plan-periodicity');
const selectedFormat = ref('free-format-variants');

const selectPeriodicity = (periodicityId) => {
  selectedPeriodicity.value = periodicityId;
}

const selectFormat = (fomatId) => {
  selectedFormat.value = fomatId;
}

</script>

<template>
  <section class="dashboard">
    <h1>
      Reports
      <span class="info-line">
        Turn reports on/off or change report email you can on <a href="#">notify settings page</a>
      </span>
    </h1>

    <div class="setting-line">
      <div class="setting-section">
        <h3>
          Periodicity
          <span class="tag">soon</span>
        </h3>

        <div class="limit wrapper">

          <!--include('app.partials.plan', ['title' => 'All', 'description' => 'Monthly',  'suffix' => '', 'isCurrent' => true ])-->
          <!--include('app.partials.plan', ['title' => 'Pro, Ultimate', 'description' => 'Biweekly',  'suffix' => '', 'isCurrent' => false ])-->
          <!--include('app.partials.plan', ['title' => 'Ultimate only', 'description' => 'Weekly',  'suffix' => '', 'isCurrent' => false ])-->

          <div class="plan item" v-for="plan in periodicity">
            <div class="room-block">
              <div class="room-block_header" v-text="plan.title" />
              <div class="room-block_content">
                {{ plan.description }}
                <span class="room-block_content__suffix">{{ plan.suffix }}</span>
              </div>

              <button class="btn btn-transparent current" v-if="plan.isCurrent">
                Current
              </button>
              <a href="#" @click="selectPeriodicity(plan.id)" class="toogle btn btn-blue" v-else>
                Choose
              </a>

            </div>
          </div>

        </div>
      </div>

    </div>

    <div class="setting-line">
      <div class="setting-section">
        <h3>
          Format
          <span class="tag">soon</span>
        </h3>

        <div class="limit wrapper">
          <!--include('app.partials.plan', ['title' => 'All', 'description' => 'CSV',  'suffix' => '', 'isCurrent' => true ])-->
          <!--include('app.partials.plan', ['title' => 'Pro, Ultimate', 'description' => 'XLS',  'suffix' => '', 'isCurrent' => false ])-->
          <!--include('app.partials.plan', ['title' => 'Ultimate only', 'description' => 'PDF',  'suffix' => '', 'isCurrent' => false ])-->

          <div class="plan item" v-for="plan in format">
            <div class="room-block">
              <div class="room-block_header" v-text="plan.title" />
              <div class="room-block_content">
                {{ plan.description }}
                <span class="room-block_content__suffix">{{ plan.suffix }}</span>
              </div>

              <button class="btn btn-transparent current" v-if="plan.isCurrent">
                Current
              </button>
              <a href="#" @click="selectFormat(plan.id)" class="toogle btn btn-blue" v-else>
                Choose
              </a>

            </div>
          </div>
        </div>
      </div>
    </div>


  </section>
</template>

<style scoped lang="scss">

</style>