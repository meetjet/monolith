<template>
  <AppLayout :title="$t('Dashboard')">
    <template #content>
      <Welcome />
    </template>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
</script>
