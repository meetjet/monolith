<template>
  <div class="flex h-screen overflow-hidden bg-slate-100">
    <Head :title="title" />

    <!-- Sidebar -->
    <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />

    <!-- Content Area -->
    <div
      class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden"
    >
      <!-- Site Header -->
      <Header
        :sidebarOpen="sidebarOpen"
        @toggle-sidebar="sidebarOpen = !sidebarOpen"
      />

      <!-- Page Content -->
      <main>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <!-- Page Header -->
          <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Top Left Area -->
            <div>
              <breadcrumbs
                v-if="$page.props.breadcrumbs.length"
                :show_breadcrumbs="show_breadcrumbs"
              />
              <h1 v-else class="text-2xl md:text-3xl text-slate-800 font-bold">
                {{ title }}
              </h1>
            </div>

            <!-- Top Right Area -->
            <div>
              <slot name="top-right" />
            </div>
          </div>
          <!-- Page content -->
          <slot name="content" />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import Header from "@/Shared/Header.vue";
import Sidebar from "@/Shared/Sidebar.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import Breadcrumbs from "@/Shared/Breadcrumbs.vue";

defineProps({
  title: String,
  show_breadcrumbs: {
    type: Boolean,
    default: true,
  },
});

const showingNavigationDropdown = ref(false);

const sidebarOpen = ref(false);

const switchToTeam = (team) => {
  Inertia.put(
    route("current-team.update"),
    {
      team_id: team.id,
    },
    {
      preserveState: false,
    }
  );
};

const logout = () => {
  Inertia.post(route("logout"));
};
</script>
