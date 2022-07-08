import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { __, setLocale } from "matice";
import { hasRole, hasPermission } from "./plugins/role_permission_plugin";

const appName =
  window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    ),
  setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .mixin({ methods: { $t: __ } })
      .mixin({ methods: { $setLocale: setLocale } })
      .mixin({ methods: { $hasRole: hasRole } })
      .mixin({ methods: { $hasPermission: hasPermission } })
      .mount(el);
  },
});

InertiaProgress.init({ color: "#4B5563" });
