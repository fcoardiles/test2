<template>
  <v-app
    v-bind:style="{
      width: '100%',
      margin: 0,
      height: '100%',
      backgroundImage: 'url(bk.png)',
      backgroundColor: 'white',
      backgroundPosition: 'center',
      backgroundRepeat: 'no-repeat',
      backgroundSize: 'cover',
    }"
  >
    <div
      v-bind:style="{
        height: '58px',
        backgroundColor: '#0A173D',
        zIndex: '10',
      }"
    >
      <div class="d-flex align-center pa-3">
        <div
          v-bind:style="{
            width: '180px',
            height: '35px',
          }"
        >
          <v-img src="logo.png" />
        </div>

        <span
          class="pl-2"
          v-bind:style="{
            fontFamily: 'Anton, sans-serif',
            fontSize: '1.2em',
            color: '#46536E',
            height: '100%',
            color: 'white',
            marginTop: '8px',
          }"
        >
          TMES
        </span>
        <div class="pt-2">
          <v-icon color="white">mdi-toolbox</v-icon>
          <v-icon
            small
            v-bind:style="{ position: 'absolute', top: '2em' }"
            color="white"
            >mdi-tools
          </v-icon>
        </div>
        <v-spacer></v-spacer>
      </div>
    </div>
    <v-main>
      <router-view class="ma-0 pa-0" :key="1 + $router.app.$route.name" />
    </v-main>

    <v-footer color="#38454C">
      <v-btn icon @click="helpDialog = true">
        <v-icon color="white">mdi-help-circle-outline</v-icon>
      </v-btn>
      <v-btn icon @click="reloadPage()">
        <v-icon color="white">mdi-reload</v-icon>
      </v-btn>
      <template v-if="user === 'admin'">
        <v-btn icon>
          <v-icon color="green">mdi-card-account-details-star</v-icon>
        </v-btn>
      </template>
      <v-spacer />
      <div class="mx-auto">
        <router-link
          :to="{ name: item.link }"
          v-for="item in items"
          :key="item.title"
          class="py-3"
          v-bind:style="{
            color: 'transparent',
            fontFamily: 'Oswald, sans-serif',
          }"
        >
          <v-btn
            text
            v-bind:style="[
              $router.app.$route.name === item.link
                ? { color: '#FFFFFF' }
                : { color: '#80898F' },
            ]"
          >
            {{ item.title }}
            <v-icon small>
              {{ item.icon }}
            </v-icon>
          </v-btn>
        </router-link>
      </div>
      <v-spacer />
      <div>
        <div
          v-bind:style="{
            fontFamily: 'Oswald, sans-serif',
            color: 'white',
            fontSize: '0.9em',
            textAlign: 'right',
          }"
        >
          {{ time }}
        </div>

        <div
          v-bind:style="{
            fontFamily: 'Oswald, sans-serif',
            color: 'white',
            fontSize: '0.9em',
            textAlign: 'right',
          }"
        >
          {{
            new Date()
              .toJSON()
              .slice(0, 10)
              .replace(/-/g, "/")
          }}
        </div>
      </div>
    </v-footer>

    <v-dialog v-model="helpDialog" width="500px">
      <v-card>
        <h3
          class="text-center pa-1"
          v-bind:style="{ backgroundColor: '#2D2D2D', color: 'white' }"
        >
          Súgó
          <v-btn
            v-bind:style="{ position: 'absolute', right: '0.5em' }"
            class="pb-2"
            icon
            @click="helpDialog = false"
          >
            <v-icon color="white">mdi-close </v-icon>
          </v-btn>
        </h3>
        <v-row class="ma-0 pa-1">
          <v-col cols="12" class="pa-0">
            <v-row class="ma-0 py-0">
              <v-col cols="12" class="ma-0 py-0">
                <v-row v-for="(item, i) in helpItem" class="ma-0" :key="i">
                  <v-col cols="2" class="py-2">
                    <v-icon color="#333333">{{ item.icon }}</v-icon>
                  </v-col>
                  <v-col cols="10" class="py-2">{{ item.name }}.</v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-col>

          <v-col cols="12">
            <span class="pt-1 px-3" v-bind:style="{ color: '#424242' }">
              Prioritás Szín
            </span>
            <v-row class="mt-0">
              <v-row class="ma-0">
                <v-col cols="12" class="ma-0">
                  <v-row
                    v-for="(item, i) in priorityText"
                    class="ma-0"
                    :key="i"
                  >
                    <v-col cols="2" class="py-1">
                      <v-icon :color="item.color">
                        mdi-rectangle
                      </v-icon>
                    </v-col>
                    <v-col cols="10" class="py-1"> {{ item.name }}.</v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-row>
          </v-col>

          <v-col cols="12">
            <span class="pt-1 px-3" v-bind:style="{ color: '#424242' }">
              Státusz
            </span>
            <v-row class="mt-0">
              <v-row class="ma-0">
                <v-col cols="12" class="ma-0">
                  <v-row class="ma-0">
                    <v-col cols="2" class="py-0">
                      <div
                        class="ml-1"
                        v-bind:style="{
                          backgroundColor: '#38454C',
                          width: '20px',
                          height: '18px',
                        }"
                      >
                        <v-container fluid fill-height class="my-0 py-0">
                          <v-row align="center" justify="center" class="pr-3">
                            <v-col cols="12">
                              <div class="loadingClock">
                                <div class="hourglass">
                                  <div class="hourglass-top">
                                    <div class="sand-top"></div>
                                  </div>
                                  <div class="hourglass-bottom">
                                    <div class="sand-bottom"></div>
                                  </div>
                                </div>
                              </div>
                            </v-col>
                          </v-row>
                        </v-container>
                      </div>
                    </v-col>
                    <v-col cols="10" class="py-1">Várakozik</v-col>
                  </v-row>
                  <v-row class="ma-0">
                    <v-col cols="2" class="py-1">
                      <div
                        class="ml-1"
                        v-bind:style="{
                          backgroundColor: '#38454C',
                          width: '20px',
                          height: '18px',
                        }"
                      >
                        <v-container fluid fill-height class="my-0 py-0 pl-0">
                          <v-row
                            align="center"
                            justify="center"
                            class="mx-0 ml-0 pa-0"
                          >
                            <v-col cols="6" class="my-0 pa-0">
                              <v-icon class="spin" size="12" dark>
                                mdi-cog
                              </v-icon>
                            </v-col>
                            <v-col cols="6" class="ma-0 pa-0">
                              <v-icon
                                v-bind:style="{ marginLeft: '.18em' }"
                                class="spin-back mb-1"
                                size="12"
                                dark
                                >mdi-cog
                              </v-icon>
                            </v-col>
                          </v-row>
                        </v-container>
                      </div>
                    </v-col>
                    <v-col cols="10" class="py-1">Megmunkálás alatt</v-col>
                  </v-row>
                  <v-row class="ma-0">
                    <v-col cols="2" class="py-1">
                      <div
                        class="ml-1"
                        v-bind:style="{
                          backgroundColor: '#B71C1C',
                          width: '20px',
                          height: '18px',
                        }"
                      >
                        <v-icon
                          class="ma-1"
                          v-bind:style="{ position: 'absolute' }"
                          color="white"
                          size="12"
                          >mdi-close
                        </v-icon>
                      </div>
                    </v-col>
                    <v-col cols="10" class="py-1">Megszakítva</v-col>
                  </v-row>
                  <v-row class="ma-0">
                    <v-col cols="2" class="py-1">
                      <div
                        class="ml-1"
                        v-bind:style="{
                          backgroundColor: '#388E3C',
                          width: '20px',
                          height: '18px',
                        }"
                      >
                        <v-icon
                          class="ma-1"
                          v-bind:style="{ position: 'absolute' }"
                          color="white"
                          size="12"
                          >mdi-check
                        </v-icon>
                      </div>
                    </v-col>
                    <v-col cols="10" class="py-1">Kész</v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-row>
          </v-col>
        </v-row>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
import axios from "axios";
const urlUser = "http://192.168.4.11/vaultbrowser/db/userCardTmes.php";
export default {
  name: "App",
  data() {
    return {
      items: [
        { title: "Alkatrészek", icon: "mdi-toolbox", link: "Home" },
        { title: "Javítás", icon: "mdi-tools", link: "Repair" },
        { title: "Összesítő", icon: "mdi-table", link: "TableTMES" },
      ],
      interval: null,
      time: null,
      helpDialog: false,
      priorityText: [
        { name: "Nagyon Magas", color: "#FF00FF" },
        { name: "Magas", color: "#FF0000" },
        { name: "Normál", color: "#FFE32A" },
        { name: "Alacsony", color: "#FFA500" },
        { name: "Nincs prioritás", color: "#263238" },
      ],
      helpItem: [
        { name: "Újra töltse", icon: "mdi-reload" },
        { name: "Részleteinek megtekintése", icon: "mdi-text-box" },
        { name: "Eltávolítsa", icon: "mdi-delete" },
      ],
      user: "",
    };
  },
  async created() {
    this.$options.sockets.onmessage = (data) => {
      const event = JSON.parse(data.data);
      //console.log(event);
      if (event !== null) {
        if (event.Message !== "" || event.Message !== null) {
          this.loginCard(event.Message);
        } else {
          this.user = "";
          localStorage.clear();
        }
      } else {
        this.user = "";
      }
    };
    this.interval = setInterval(() => {
      this.user = localStorage.user;
      this.time = Intl.DateTimeFormat(navigator.language, {
        hour: "numeric",
        minute: "numeric",
      }).format();
    }, 1000);
  },

  mounted() {
    let elHtml = document.getElementsByTagName("html")[0];
    elHtml.style.overflowY = "auto";
    this.noRightClick();
  },
  destroyed() {
    let elHtml = document.getElementsByTagName("html")[0];
    elHtml.style.overflowY = null;
    clearInterval(this.interval);
  },
  methods: {
    reloadPage() {
      window.location.reload();
    },
    noRightClick() {
      window.oncontextmenu = function() {
        return false;
      };
    },
    loginCard(value) {
      axios
        .post(
          urlUser,
          JSON.stringify({
            number: value,
            type: "login",
          })
        )
        .then((resp) => {
          //console.log(resp.data);
          if (resp.data === "admin") {
            localStorage.setItem("user", "admin");
            this.user = localStorage.user;
          } else {
            this.user = "";
            localStorage.clear();
          }
        });
    },
  },
};
</script>
