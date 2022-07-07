<template>
  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6 mb-6">
    <div v-if="title" class="font-bold text-xl">{{ title }}</div>
    <slot name="top" />
    <slot />
  </div>
</template>

<script>
export default {
  name: "PageSection",
  props: {
    title: String,
  },
};
</script>

<style scoped></style>
