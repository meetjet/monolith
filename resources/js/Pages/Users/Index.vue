<template>
  <app-layout :title="$t('Users')">
    <template #content>
      <Table :resource="entities">
        <template #cell(created_at)="{ item: user }">
          {{ createdTime(user.created_at) }}
        </template>
        <template #cell(actions)="{ item: user }">
          <v-icon name="ri-pencil-line" class="mr-2" />
          <Link
            :href="`/users/${user.id}/edit`"
            class="text-indigo-600 hover:text-indigo-400 focus:text-indigo-500"
            >{{ $t("Edit") }}</Link
          >
        </template>
      </Table>
    </template>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PageSection from "@/Shared/PageSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";

export default {
  components: {
    AppLayout,
    PageSection,
    Link,
    Table,
  },
  props: {
    entities: Object,
  },
  methods: {
    createdTime(time) {
      return new Date(time).toLocaleTimeString("ru-Ru", {
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
      });
    },
  },
};
</script>

<style scoped></style>
