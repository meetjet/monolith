<template>
  <AppLayout :title="$t('API Tokens')">
    <template #content>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <ApiTokenManager
          :tokens="tokens"
          :available-permissions="availablePermissions"
          :default-permissions="defaultPermissions"
        />
      </div>
    </template>
  </AppLayout>
</template>

<script setup>
import ApiTokenManager from "@/Pages/API/Partials/ApiTokenManager.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
  tokens: Array,
  availablePermissions: Array,
  defaultPermissions: Array,
});
</script>
