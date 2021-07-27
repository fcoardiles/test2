import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import vuetify from "./plugins/vuetify";
import VueNativeSock from "vue-native-websocket";

import "@mdi/font/css/materialdesignicons.css"; // Ensure you are using css-loader
import Vuetify from "vuetify/lib";
Vue.use(Vuetify);
export default new Vuetify({
  icons: {
    iconfont: "mdi", // default - only for display purposes
  },
});
Vue.config.productionTip = false;

Vue.use(VueNativeSock, "ws://localhost:5100/ws", {
  format: "json",
  reconnection: true, // (Boolean) whether to reconnect automatically (false)
  reconnectionAttempts: 5, // (Number) number of reconnection attempts before giving up (Infinity),
  reconnectionDelay: 3000, // (Number) how long to initially wait before attempting a new (1000)
});
new Vue({
  router,
  vuetify,
  render: (h) => h(App),
}).$mount("#app");


