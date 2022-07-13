<template>
  <app-layout :title="$t('Users')">
    <template #top-right>
      <inertia-link
        :href="route('users.create')"
        class="btn bg-indigo-500 hover:bg-indigo-600 text-white"
      >
        <v-icon name="ri-add-line" scale="1.25" />
        <span class="ml-2">{{ $t("Create") }}</span>
      </inertia-link>
    </template>
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
  inject: ["$dayjs"],
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
      return this.$dayjs(time).format("DD-MM-YYYY, HH:mm");
    },
  },
};
</script>

<style scoped></style>
