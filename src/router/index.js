import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Work.vue";
import Repair from "../views/Repair.vue";
import TableTMES from "../views/TableTMES.vue";
Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/repair",
    name: "Repair",
    component: Repair,
  },
  {
    path: "/table",
    name: "TableTMES",
    component: TableTMES,
  },
];

const router = new VueRouter({
  routes,
});

export default router;
