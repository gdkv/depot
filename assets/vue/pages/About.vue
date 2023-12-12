<template>
  <section class="top">
    <div class="left">
      <h1 v-text="header" />
      <p v-text="description" />
    </div>
    <div class="right"></div>
  </section>

  <section class="accordion">
    <div class="questions">
      <div class="question" v-for="question in questions" key="question.id">
        <a href="#" class="toogle question-title">{{ question.question }}</a>
        <div class="toogle-block answer active" id="{{ question.id }}">
          <p>{{ question.answer }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>

  import { trans, MAIN_PAGES_ABOUT_HEADER, MAIN_PAGES_ABOUT_DESCRIPTION} from '../../translator';

  const header = trans(MAIN_PAGES_ABOUT_HEADER)
  const description = trans(MAIN_PAGES_ABOUT_DESCRIPTION)

  const questions = [
    {
      id: 'answer-4',
      question: 'I don\'t get any data to my cloud app, but sensor is added and it is active',
      answer: 'Get the latest version of WSTools.exe, connect sensor to your computer USB hub, then push mini button with clip, then you see Depot settings.'
    },
    {
      id: 'answer-3',
      question: 'How to get reports to my email address',
      answer: 'Get the latest version of WSTools.exe, connect sensor to your computer USB hub, then push mini button with clip, then you see Welasensor settings.'
    },
    {
      id: 'answer-2',
      question: 'How to add my Welasensor to my cloud app account',
      answer: 'Get the latest version of WSTools.exe, connect sensor to your computer USB hub, then push mini button with clip, then you see Welasensor settings.'
    },
    {
      id: 'answer-1',
      question: 'How to connect my Welasensor to my Wi-Fi',
      answer: 'Get the latest version of WSTools.exe, connect sensor to your computer USB hub, then push mini button with clip, then you see Welasensor settings.'
    },
  ];
</script>

<style lang="scss"></style>
