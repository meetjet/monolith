<template>
  <app-layout :title="$t('Platform users')">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("Platform users") }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-8">
          <div class="mb-8">
            <!-- Create link -->
            <Link
              class="px-6 py-3 rounded bg-indigo-600 text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-orange-400 focus:bg-orange-400"
              :href="route('users.create')"
            >
              {{ $t("Create user") }}
            </Link>
          </div>

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
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
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
