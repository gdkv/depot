<template>
    <section class="top">
      <div class="left">
        <h1>{{ header }}</h1>
        <p>{{ description }}</p>
      </div>
      <div class="right">

        <div class="welasensor">
          <div class="corpus">
            <div class="indicator"></div>
          </div>
          <div class="plug"></div>
        </div>

      </div>
    </section>
</template>

<script setup>

  import { trans, MAIN_PAGES_INDEX_HEADER, MAIN_PAGES_INDEX_DESCRIPTION} from '../../translator';

  const header = trans(MAIN_PAGES_INDEX_HEADER)
  const description = trans(MAIN_PAGES_INDEX_DESCRIPTION)
</script>

<style lang="scss"></style>
