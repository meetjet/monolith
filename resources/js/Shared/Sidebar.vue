<template>
  <div>
    <!-- Sidebar backdrop (mobile only) -->
    <div
      class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
      aria-hidden="true"
    ></div>

    <!-- Sidebar -->
    <div
      id="sidebar"
      ref="sidebar"
      class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 transform h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'"
    >
      <!-- Sidebar header -->
      <div class="flex justify-between mb-10 pr-3 sm:px-2">
        <!-- Close button -->
        <button
          ref="trigger"
          class="lg:hidden text-slate-500 hover:text-slate-400"
          @click.stop="$emit('close-sidebar')"
          aria-controls="sidebar"
          :aria-expanded="sidebarOpen"
        >
          <span class="sr-only">Close sidebar</span>
          <svg
            class="w-6 h-6 fill-current"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z"
            />
          </svg>
        </button>
        <!-- Logo -->
        <Link class="block" to="/">
          <svg width="32" height="32" viewBox="0 0 32 32">
            <defs>
              <linearGradient
                x1="28.538%"
                y1="20.229%"
                x2="100%"
                y2="108.156%"
                id="logo-a"
              >
                <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                <stop stop-color="#A5B4FC" offset="100%" />
              </linearGradient>
              <linearGradient
                x1="88.638%"
                y1="29.267%"
                x2="22.42%"
                y2="100%"
                id="logo-b"
              >
                <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                <stop stop-color="#38BDF8" offset="100%" />
              </linearGradient>
            </defs>
            <rect fill="#6366F1" width="32" height="32" rx="16" />
            <path
              d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z"
              fill="#4F46E5"
            />
            <path
              d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z"
              fill="url(#logo-a)"
            />
            <path
              d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z"
              fill="url(#logo-b)"
            />
          </svg>
        </Link>
      </div>

      <ul class="mt-3">
        <template v-for="(item, key) in menuItems" :key="key">
          <SidebarLinkGroup :activeCondition="activeCondition(item)">
            <template v-if="item.children && item.children.length">
              <a
                @click.prevent="item.opened = !item.opened"
                href="#"
                class="block text-slate-200 hover:text-white truncate transition duration-150"
              >
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <v-icon width="25" height="25" :name="item.icon" />
                    <span
                      class="text-sm font-medium ml-3 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                      >{{ $t(item.title) }}</span
                    >
                  </div>
                  <!--Icon-->
                  <div class="flex shrink-0 ml-2">
                    <svg
                      :class="{
                        'w-3 h-3 shrink-0 ml-1 fill-current text-slate-400': true,
                        'transform rotate-180': item.opened,
                      }"
                      viewBox="0 0 12 12"
                    >
                      <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                    </svg>
                  </div>
                </div>
              </a>
              <div
                class="lg:sidebar-expanded:block 2xl:block"
                v-if="item.opened"
              >
                <ul class="pl-9 mt-1">
                  <template
                    v-for="(path, path_key) in item.children"
                    :key="path_key"
                  >
                    <li class="mb-1 last:mb-0">
                      <Link
                        :class="{
                          '!text-indigo-500': activeCondition(path),
                          'block text-slate-400 hover:text-slate-200 transition duration-150 truncate': true,
                        }"
                        :href="route(path.route_name)"
                        :active="activeCondition(path)"
                      >
                        <span
                          class="text-sm font-medium lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                          >{{ $t(path.title) }}</span
                        >
                      </Link>
                    </li>
                  </template>
                </ul>
              </div>
            </template>
            <template v-else>
              <Link
                :href="route(item.route_name)"
                class="block text-slate-200 hover:text-white truncate transition duration-150"
              >
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <v-icon width="25" height="25" :name="item.icon" />
                    <span
                      class="text-sm font-medium ml-3 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                      >{{ $t(item.title) }}</span
                    >
                  </div>
                </div>
              </Link>
            </template>
          </SidebarLinkGroup>
        </template>
      </ul>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted, computed, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import SidebarLinkGroup from "./SidebarLinkGroup.vue";
import menu from "../../../menu.json";

export default {
  name: "Sidebar",
  props: ["user", "sidebarOpen"],
  components: {
    Link,
    SidebarLinkGroup,
  },
  setup(props, { emit }) {
    const $route = window.route;
    const user = computed(() => usePage().props.value.user);
    const trigger = ref(null);
    const sidebar = ref(null);

    const storedSidebarExpanded = localStorage.getItem("sidebar-expanded");
    const sidebarExpanded = ref(
      storedSidebarExpanded === null ? false : storedSidebarExpanded === "true"
    );

    // close on click outside
    const clickHandler = ({ target }) => {
      if (!sidebar.value || !trigger.value) return;
      if (
        !props.sidebarOpen ||
        sidebar.value.contains(target) ||
        trigger.value.contains(target)
      )
        return;
      emit("close-sidebar");
    };

    // close if the esc key is pressed
    const keyHandler = ({ keyCode }) => {
      if (!props.sidebarOpen || keyCode !== 27) return;
      emit("close-sidebar");
    };

    const activeCondition = (module) => {
      let result = false;
      if (module.route_active) {
        result = $route().current(module.route_active);
        if (module.excludes) {
          module.excludes.forEach((item) => {
            if ($route().current(item)) {
              result = false;
            }
          });
        }
      }
      if (module.route_name && !result) {
        result = $route().current(module.route_name);
      }
      if (module.children) {
        module.children.forEach((item) => {
          if (activeCondition(item)) {
            result = true;
            return;
          }
        });
      }
      return result;
    };

    for (const [key, item] of Object.entries(menu)) {
      item.opened = activeCondition(item);
      if (item.opened) {
        break;
      }
    }

    const menuItems = ref(menu);

    onMounted(() => {
      document.addEventListener("click", clickHandler);
      document.addEventListener("keydown", keyHandler);
    });

    onUnmounted(() => {
      document.removeEventListener("click", clickHandler);
      document.removeEventListener("keydown", keyHandler);
    });

    watch(sidebarExpanded, () => {
      localStorage.setItem("sidebar-expanded", sidebarExpanded.value);
      if (sidebarExpanded.value) {
        document.querySelector("body").classList.add("sidebar-expanded");
      } else {
        document.querySelector("body").classList.remove("sidebar-expanded");
      }
    });

    return {
      user,
      trigger,
      sidebar,
      sidebarExpanded,
      activeCondition,
      menuItems,
    };
  },
};
</script>
