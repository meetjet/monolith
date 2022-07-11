<template>
  <app-layout :title="$t('Platform users')">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("Platform users") }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <page-section>
          <template #top>
            <div class="mb-8 mt-2">
              <!-- Create link -->
              <Link
                class="rounded-md shadow-sm bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-3 px-6 focus:outline-none focus:shadow-outline"
                :href="route('users.create')"
              >
                {{ $t("Create user") }}
              </Link>
            </div>
          </template>
          <!-- User list -->
          <Table
            :filters="queryBuilderProps.filters"
            :search="queryBuilderProps.search"
            :columns="queryBuilderProps.columns"
            :on-update="setQueryBuilder"
            :meta="entities"
          >
            <template #head>
              <tr>
                <header-cell :cell="sortableHeader('id')">{{
                  $t("ID")
                }}</header-cell>
                <header-cell :cell="sortableHeader('name')">{{
                  $t("Name")
                }}</header-cell>
                <header-cell :cell="sortableHeader('email')">{{
                  $t("Email")
                }}</header-cell>
                <header-cell :cell="sortableHeader('created_at')">{{
                  $t("Created")
                }}</header-cell>
              </tr>
            </template>

            <template #body>
              <tr v-for="user in entities.data" :key="user.id">
                <td>{{ user.id }}</td>
                <!-- Name -->
                <td>
                  <Link
                    :href="route('users.edit', user.id)"
                    class="text-indigo-600 hover:text-indigo-400 focus:text-indigo-500"
                    >{{ user.name }}
                  </Link>
                </td>
                <!-- Email -->
                <td>{{ user.email }}</td>
                <!-- Created -->
                <td>
                  {{ createdTime(user.created_at) }}
                </td>
              </tr>
            </template>
          </Table>
        </page-section>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PageSection from "@/Shared/PageSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import {
  InteractsWithQueryBuilder,
  Tailwind2,
  Components,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";

export default {
  mixins: [InteractsWithQueryBuilder],
  components: {
    AppLayout,
    PageSection,
    Link,
    Table: Tailwind2.Table,
    HeaderCell: Tailwind2.HeaderCell,
  },
  props: {
    entities: Object,
  },
  mounted() {
    Components.Pagination.setTranslations({
      no_results_found: this.$t("Nothing found"),
      previous: this.$t("Prev"),
      next: this.$t("Next"),
      to: this.$t("to"),
      of: this.$t("of"),
      results: "",
    });
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
