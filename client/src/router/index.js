import { createWebHistory, createRouter } from "vue-router";

import home from "../components/home.vue";
import ManagerPlayer from "../components/ManagerPlayer.vue";
import svlog from "../components/svlog.vue";
import PlayerOnline from "../components/PlayerOnline.vue";

const routes = [
   {
    path: "/",
    name: "Home",
    component: home,
  },
  {
    path: "/manament",
    name: "ManagerPlayer",
    component: ManagerPlayer,
  },
  {
    path: "/log",
    name: "svlog",
    component: svlog,
  },
  {
    path: "/online",
    name: "PlayerOnline",
    component: PlayerOnline,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;