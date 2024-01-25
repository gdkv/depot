<script setup>
import {getCurrentInstance, onMounted, ref} from "vue";

const props = defineProps({
  options: {
    type: Array,
    required: true,
  },
  default: {
    type: String,
    required: false,
    default: null,
  },
  tabindex: {
    type: Number,
    required: false,
    default: 0,
  },
});

const selected = ref(props.default ? props.default : props.options[0]);
const open = ref(false);
const instance = getCurrentInstance();

onMounted(() => {
  instance.proxy.$emit('input', selected.value);
});
</script>

<template>
  <div class="custom-select small" :tabindex="tabindex" @blur="open = false">
    <div class="selected" :class="{ open: open }" @click="open = !open">
      {{ selected }}
    </div>
    <div class="select-items" :class="{ selectHide: !open }">
      <div
          v-for="(option, i) of options"
          :key="i"
          @click="
          selected = option;
          open = false;
          $emit('input', option);
        "
      >
        {{ option }}
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.custom-select {
  position: relative;
  font-family: Gilroy, sans-serif;
  font-size: 15px;

  .selected {
    border-radius: 10px;
    cursor: pointer;
    user-select: none;
    line-height: 35px;

    //&.open {
    //  border: 1px solid #ad8225;
    //  border-radius: 6px 6px 0px 0px;
    //}

    &:after {
      position: absolute;
      content: "";
      top: 16px;
      right: 1em;
      width: 0;
      height: 0;
      border: 5px solid transparent;
    }
  }

  .select-items {
    position: absolute;
    background-color: #ffffff;
    top: 101%;
    left: 0;
    right: 0;
    z-index: 99;
    border-radius: 10px;
    box-shadow: 0 7px 20px 15px rgba(0,0,0,.1);

    div {
      color: #2a2a2a;
      padding: 10px 22px;
      cursor: pointer;
      user-select: none;

      &:hover {
        color: #aeaeae;
      }
    }
  }
}
.selectHide {
  display: none;
}
</style>