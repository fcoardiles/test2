<template>
  <div v-bind:style="{ width: '80vh' }">
    <v-container>
      <v-row
        class="py-2 pr-5 pl-2"
        v-bind:style="{ margin: 0, width: '100vw' }"
      >
        <v-col cols="6" class="px-0">
          <v-card
            elevation="9"
            class="rounded-b-lg"
            v-bind:style="{
              minHeight: '80px',
              textAlign: 'center',
              backgroundColor: '#F1F1F1',
            }"
          >
            <h3
              class="pa-1"
              v-bind:style="{ backgroundColor: '#38454C', color: 'white' }"
            >
              Javítás
              <v-icon small color="white">
                mdi-puzzle
              </v-icon>
              <span
                class="py-2 pr-6"
                v-bind:style="{
                  position: 'absolute',
                  right: 0,
                  fontFamily: 'Anton,sans-serif',
                  fontWeight: 100,
                  fontSize: '.6em',
                }"
              >
                ELEMEK: {{ list.length }}
              </span>
            </h3>
            <v-list-item-group
              v-bind:style="{ height: '57vh' }"
              class="overflow-y-auto"
              color="primary"
            >
              <v-container fluid fill-height class="pa-0">
                <v-layout align-center justify-center class="pa-0">
                  <v-flex>
                    <template v-if="userState === 'admin'">
                      <draggable
                        class="dragArea list-group"
                        :list="visibleList"
                        :group="{ name: 'part', put: false }"
                        :clone="clonePart"
                        :sort="false"
                        v-bind:style="{ cursor: 'pointer' }"
                      >
                        <v-list-item
                          v-bind:style="{
                            display: 'inline-block',
                            width: '12.2vw',
                          }"
                          v-for="element in visibleList"
                          :key="element.id"
                          class="px-3 py-1 my-3"
                        >
                          <v-card
                            v-bind:style="{
                              width: '100%',
                              backgroundColor: '#38454C',
                              color: '#FFFFFF',
                              borderRadius: '0.5em',
                              fontFamily: 'Oswald, sans-serif',
                              fontSize: '0.8em',
                              margin: '0 0.2em',
                            }"
                          >
                            <v-row class="pa-0">
                              <v-col cols="2">
                                <v-icon
                                  @click="detail(element.id, element.name)"
                                  class="ml-1"
                                  color="#FFFFFF"
                                  size="25"
                                >
                                  mdi-text-box
                                </v-icon>
                              </v-col>
                              <v-col cols="8" class="pt-0">
                                <span
                                  class="mx-auto my-0"
                                  v-bind:style="{
                                    fontWeight: 300,
                                    height: '50px',
                                    display: 'flex',
                                    justifyContent: 'center',
                                    alignItems: 'center',
                                    textAlign: 'center',
                                    fontSize: '0.95em',
                                    width: '150px',
                                  }"
                                >
                                  {{ element.name }}
                                </span>
                              </v-col>
                              <v-col cols="2" class="pl-0">
                                <v-icon color="white" size="12" class="mt-1">
                                  mdi-puzzle
                                </v-icon>
                              </v-col>
                            </v-row>

                            <v-row
                              class="py-0 my-0"
                              v-bind:style="[
                                element.priority === '#FFE32A'
                                  ? {
                                      fontSize: '0.75em',
                                      backgroundColor: element.priority,
                                      color: '#38454C',
                                      margin: '0',
                                    }
                                  : {
                                      fontSize: '0.75em',
                                      backgroundColor: element.priority,
                                      color: 'white',
                                      margin: '0',
                                    },
                              ]"
                            >
                              <v-col
                                cols="12"
                                class="pa-0 ma-0"
                                v-bind:style="{
                                  backgroundColor: '#38454C',
                                  borderTop: '1px solid white',
                                  maxHeight: '17px',
                                }"
                              >
                                {{ element.equipmentText }}
                              </v-col>
                              <v-col cols="7" class="text-left py-1 px-1">
                                {{ element.sapOrder }} - {{ element.equipment }}
                              </v-col>
                              <v-col cols="5" class="py-1 px-1">
                                <v-row class="ma-0 pa-0">
                                  <v-col cols="2" class="text-left ma-0 pa-0">
                                    {{ element.type }}
                                  </v-col>
                                  <v-col class="text-right ma-0 pa-0">
                                    {{ element.date }}
                                  </v-col>
                                </v-row>
                              </v-col>
                            </v-row>
                          </v-card>
                        </v-list-item>
                      </draggable>
                    </template>
                    <template v-else>
                      <v-list-item
                        v-bind:style="{
                          display: 'inline-block',
                          width: '12.2vw',
                        }"
                        v-for="element in visibleList"
                        :key="element.id"
                        class="px-3 py-1 my-3"
                      >
                        <v-card
                          v-bind:style="{
                            width: '100%',
                            backgroundColor: '#38454C',
                            color: '#FFFFFF',
                            borderRadius: '0.5em',
                            fontFamily: 'Oswald, sans-serif',
                            fontSize: '0.8em',
                            margin: '0 0.2em',
                          }"
                        >
                          <v-row class="pa-0">
                            <v-col cols="2">
                              <v-icon
                                @click="detail(element.id, element.name)"
                                class="ml-1"
                                color="#FFFFFF"
                                size="25"
                              >
                                mdi-text-box
                              </v-icon>
                            </v-col>
                            <v-col cols="8" class="pt-0">
                              <span
                                class="mx-auto my-0"
                                v-bind:style="{
                                  fontWeight: 300,
                                  height: '50px',
                                  display: 'flex',
                                  justifyContent: 'center',
                                  alignItems: 'center',
                                  textAlign: 'center',
                                  fontSize: '0.95em',
                                  width: '150px',
                                }"
                              >
                                {{ element.name }}
                              </span>
                            </v-col>
                            <v-col cols="2" class="pl-0">
                              <v-icon color="white" size="12" class="mt-1">
                                mdi-puzzle
                              </v-icon>
                            </v-col>
                          </v-row>
                          <v-row
                            class="py-0 my-0"
                            v-bind:style="[
                              element.priority === '#FFE32A'
                                ? {
                                    fontSize: '0.75em',
                                    backgroundColor: element.priority,
                                    color: '#38454C',
                                    margin: '0',
                                  }
                                : {
                                    fontSize: '0.75em',
                                    backgroundColor: element.priority,
                                    color: 'white',
                                    margin: '0',
                                  },
                            ]"
                          >
                            <v-col
                              cols="12"
                              class="pa-0 ma-0"
                              v-bind:style="{
                                backgroundColor: '#38454C',
                                borderTop: '1px solid white',
                                maxHeight: '17px',
                              }"
                            >
                              {{ element.equipmentText }}
                            </v-col>

                            <v-col cols="7" class="text-left py-1 px-1">
                              {{ element.sapOrder }} - {{ element.equipment }}
                            </v-col>
                            <v-col cols="5" class="py-1 px-1">
                              <v-row class="ma-0 pa-0">
                                <v-col cols="2" class="text-left ma-0 pa-0">
                                  {{ element.type }}
                                </v-col>
                                <v-col class="text-right ma-0 pa-0">
                                  {{ element.date }}
                                </v-col>
                              </v-row>
                            </v-col>
                          </v-row>
                        </v-card>
                      </v-list-item>
                    </template>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-list-item-group>
            <v-row class="px-5">
              <v-col>
                <v-pagination
                  color="#E65100"
                  v-model="page"
                  :length="Math.ceil(list.length / perPage)"
                />
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="6" class="py-2 px-4">
          <v-row
            v-bind:style="{
              maxHeight: PanelMachineHeight,
            }"
            class="overflow-y-auto"
          >
            <v-col cols="3" class="px-0" v-for="(item, i) in machine" :key="i">
              <v-card
                elevation="0"
                class="rounded-b-lg"
                v-bind:style="{
                  minHeight: '100px',
                  textAlign: 'center',
                  backgroundColor: 'transparent',
                }"
              >
                <template v-if="item.user !== null">
                  <div
                    class="pa-1 mx-2 rounded-t-lg"
                    v-bind:style="{
                      backgroundColor: '#38454C',
                      color: 'white',
                      fontFamily: 'Oswald, sans-serif',
                      height: '25px',
                      display: 'flex',
                      justifyContent: 'center',
                      alignItems: 'center',
                      textAlign: 'center',
                      fontSize: '0.75em',
                    }"
                  >
                    <v-icon small color="white" class="mr-2"
                      >mdi-account</v-icon
                    >
                    {{ item.user }}
                  </div>
                  <div
                    class="pa-1 mx-2"
                    v-bind:style="{
                      backgroundColor: item.color,
                      color: 'white',
                      fontFamily: 'Oswald, sans-serif',
                      height: '50px',
                      display: 'flex',
                      justifyContent: 'center',
                      alignItems: 'center',
                      textAlign: 'center',
                      fontSize: '0.85em',
                    }"
                  >
                    {{ item.name }}
                  </div>
                </template>
                <template v-else>
                  <div
                    class="pa-1 mx-2"
                    v-bind:style="{
                      backgroundColor: item.color,
                      color: 'white',
                      fontFamily: 'Oswald, sans-serif',
                      height: '75px',
                      display: 'flex',
                      justifyContent: 'center',
                      alignItems: 'center',
                      textAlign: 'center',
                      fontSize: '0.85em',
                    }"
                  >
                    {{ item.name }}
                  </div>
                </template>
                <template v-if="userState === 'admin'">
                  <draggable
                    class="dragArea list-group"
                    :list="item.list"
                    :group="{ name: 'part' }"
                    @add="addItem(item)"
                    :sort="false"
                    v-bind:style="{ cursor: 'pointer' }"
                  >
                    <v-list-item
                      v-for="element in item.list"
                      :key="element.id + test"
                      class="px-1 py-1"
                    >
                      <v-card
                        v-bind:style="{
                          width: '100%',
                          backgroundColor: 'white',
                          color: '#333333',
                          borderRadius: '0.5em',
                          fontFamily: 'Oswald, sans-serif',
                          fontSize: '0.8em',
                          margin: '0 0.2em',
                        }"
                      >
                        <v-row class="pt-2">
                          <v-col cols="2">
                            <v-btn
                              class="pa-4"
                              icon
                              @click="detail(element.id, element.name)"
                            >
                              <v-icon color="#333333" size="25">
                                mdi-text-box
                              </v-icon>
                            </v-btn>
                          </v-col>
                          <v-col cols="8" class="py-1">
                            <span
                              class="mx-auto my-0"
                              v-bind:style="{
                                fontWeight: 300,
                                height: '58px',
                                display: 'flex',
                                justifyContent: 'center',
                                alignItems: 'center',
                                textAlign: 'center',
                                fontSize: '0.95em',
                                width: '155px',
                              }"
                            >
                              {{ element.name }}
                            </span>
                          </v-col>
                          <v-col cols="2" class="pl-0">
                            <v-btn icon @click="jobDelete(element.idJob)">
                              <v-icon color="#38454C" size="25">
                                mdi-delete
                              </v-icon>
                            </v-btn>
                          </v-col>
                        </v-row>

                        <v-row
                          class="py-0 my-0"
                          v-bind:style="[
                            element.color === '#FFE32A'
                              ? {
                                  fontSize: '0.75em',
                                  backgroundColor: element.color,
                                  color: '#38454C',
                                  margin: '0',
                                }
                              : {
                                  fontSize: '0.75em',
                                  backgroundColor: element.color,
                                  color: 'white',
                                  margin: '0',
                                },
                          ]"
                        >
                          <v-col cols="6" class="text-left py-1 px-1">
                            {{ element.orderid }} - {{ element.equipment }}
                          </v-col>
                          <v-col
                            cols="4"
                            v-bind:style="[
                              element.priorityProp === '#FFE32A'
                                ? {
                                    backgroundColor: element.priorityProp,
                                    color: '#38454C',
                                  }
                                : {
                                    backgroundColor: element.priorityProp,
                                    color: 'white',
                                  },
                            ]"
                            class="text-right py-1 px-1"
                          >
                            <v-row class="ma-0 pa-0">
                              <v-col cols="2" class="text-left ma-0 pa-0"
                                >{{ element.type }}
                              </v-col>
                              <v-col class="text-right ma-0 pa-0"
                                >{{ element.date }}
                              </v-col>
                            </v-row>
                          </v-col>
                          <template v-if="element.jobStatus === 0">
                            <v-col
                              cols="2"
                              class="ma-0 px-0 py-1"
                              v-bind:style="{
                                backgroundColor: '#38454C',
                                width: '100%',
                              }"
                            >
                              <v-container fluid fill-height class="my-0 py-0">
                                <v-row align="center" justify="center">
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
                            </v-col>
                          </template>
                          <template v-if="element.jobStatus === 1">
                            <v-col
                              cols="2"
                              class="ma-0 px-0 py-1"
                              v-bind:style="{
                                backgroundColor: '#38454C',
                                width: '100%',
                              }"
                            >
                              <v-container
                                fluid
                                fill-height
                                class="my-0 py-0 pl-1"
                              >
                                <v-row
                                  align="center"
                                  justify="center"
                                  class="mx-0 ml-0 pa-0"
                                >
                                  <v-col cols="6" class="my-0 pa-0">
                                    <v-icon class="spin" size="14" dark>
                                      mdi-cog
                                    </v-icon>
                                  </v-col>
                                  <v-col cols="6" class="ma-0 pa-0">
                                    <v-icon
                                      v-bind:style="{ marginLeft: '.1em' }"
                                      class="spin-back mb-1"
                                      size="14"
                                      dark
                                      >mdi-cog
                                    </v-icon>
                                  </v-col>
                                </v-row>
                              </v-container>
                            </v-col>
                          </template>
                          <template v-if="element.jobStatus === -1">
                            <v-col
                              cols="2"
                              class="ma-0 px-0 py-1"
                              v-bind:style="{
                                backgroundColor: '#B71C1C',
                                width: '100%',
                              }"
                            >
                              <v-container fluid fill-height class="my-0 py-0">
                                <v-row align="center" justify="center">
                                  <v-col cols="12">
                                    <v-icon color="white" size="15"
                                      >mdi-close
                                    </v-icon>
                                  </v-col>
                                </v-row>
                              </v-container>
                            </v-col>
                          </template>
                          <template v-if="element.jobStatus === 2">
                            <v-col
                              cols="2"
                              class="ma-0 px-0 py-1"
                              v-bind:style="{
                                backgroundColor: '#388E3C',
                                width: '100%',
                              }"
                            >
                              <v-container fluid fill-height class="my-0 py-0">
                                <v-row align="center" justify="center">
                                  <v-col cols="12">
                                    <v-icon color="white" size="15"
                                      >mdi-check
                                    </v-icon>
                                  </v-col>
                                </v-row>
                              </v-container>
                            </v-col>
                          </template>
                          <v-col
                            cols="12"
                            class="ma-0 pa-0"
                            v-bind:style="{
                              backgroundColor: '#38454C',
                              color: 'white',
                              maxHeight: '17px',
                            }"
                          >
                            {{ element.equipmentText }}
                          </v-col>
                        </v-row>
                      </v-card>
                    </v-list-item>
                  </draggable>
                </template>
                <template v-else>
                  <v-list-item
                    v-for="element in item.list"
                    :key="element.id + test"
                    class="px-1 py-1"
                  >
                    <v-card
                      v-bind:style="{
                        width: '100%',
                        backgroundColor: 'white',
                        color: '#333333',
                        borderRadius: '0.5em',
                        fontFamily: 'Oswald, sans-serif',
                        fontSize: '0.8em',
                        margin: '0 0.2em',
                      }"
                    >
                      <v-row class="pt-2">
                        <v-col cols="2">
                          <v-btn
                            class="pa-4"
                            icon
                            @click="detail(element.id, element.name)"
                          >
                            <v-icon color="#333333" size="25">
                              mdi-text-box
                            </v-icon>
                          </v-btn>
                        </v-col>
                        <v-col cols="8" class="py-1">
                          <span
                            class="mx-auto my-0"
                            v-bind:style="{
                              fontWeight: 300,
                              height: '58px',
                              display: 'flex',
                              justifyContent: 'center',
                              alignItems: 'center',
                              textAlign: 'center',
                              fontSize: '0.95em',
                              width: '155px',
                            }"
                          >
                            {{ element.name }}
                          </span>
                        </v-col>
                        <v-col cols="2" class="pl-0 pt-5">
                          <v-icon color="#38454C" size="15">
                            mdi-puzzle
                          </v-icon>
                        </v-col>
                      </v-row>

                      <v-row
                        class="py-0 my-0"
                        v-bind:style="[
                          element.color === '#FFE32A'
                            ? {
                                fontSize: '0.75em',
                                backgroundColor: element.color,
                                color: '#38454C',
                                margin: '0',
                              }
                            : {
                                fontSize: '0.75em',
                                backgroundColor: element.color,
                                color: 'white',
                                margin: '0',
                              },
                        ]"
                      >
                        <v-col cols="6" class="text-left py-1 px-1">
                          {{ element.orderid }} - {{ element.equipment }}
                        </v-col>
                        <v-col
                          cols="4"
                          v-bind:style="[
                            element.priorityProp === '#FFE32A'
                              ? {
                                  backgroundColor: element.priorityProp,
                                  color: '#38454C',
                                }
                              : {
                                  backgroundColor: element.priorityProp,
                                  color: 'white',
                                },
                          ]"
                          class="text-right py-1 px-1"
                        >
                          <v-row class="ma-0">
                            <v-col cols="3" class="text-left pa-0"
                              >{{ element.type }}
                            </v-col>
                            <v-col cols="9" class="text-right  pa-0"
                              >{{ element.date }}
                            </v-col>
                          </v-row>
                        </v-col>
                        <template v-if="element.jobStatus === 0">
                          <v-col
                            cols="2"
                            class="ma-0 px-0 py-1"
                            v-bind:style="{
                              backgroundColor: '#38454C',
                              width: '100%',
                            }"
                          >
                            <v-container fluid fill-height class="my-0 py-0">
                              <v-row align="center" justify="center">
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
                          </v-col>
                        </template>
                        <template v-if="element.jobStatus === 1">
                          <v-col
                            cols="2"
                            class="ma-0 px-0 py-1"
                            v-bind:style="{
                              backgroundColor: '#38454C',
                              width: '100%',
                            }"
                          >
                            <v-container
                              fluid
                              fill-height
                              class="my-0 py-0 pl-1"
                            >
                              <v-row
                                align="center"
                                justify="center"
                                class="mx-0 ml-0 pa-0"
                              >
                                <v-col cols="6" class="my-0 pa-0">
                                  <v-icon class="spin" size="14" dark>
                                    mdi-cog
                                  </v-icon>
                                </v-col>
                                <v-col cols="6" class="ma-0 pa-0">
                                  <v-icon
                                    v-bind:style="{ marginLeft: '.1em' }"
                                    class="spin-back mb-1"
                                    size="14"
                                    dark
                                    >mdi-cog
                                  </v-icon>
                                </v-col>
                              </v-row>
                            </v-container>
                          </v-col>
                        </template>
                        <template v-if="element.jobStatus === -1">
                          <v-col
                            cols="2"
                            class="ma-0 px-0 py-1"
                            v-bind:style="{
                              backgroundColor: '#B71C1C',
                              width: '100%',
                            }"
                          >
                            <v-container fluid fill-height class="my-0 py-0">
                              <v-row align="center" justify="center">
                                <v-col cols="12">
                                  <v-icon color="white" size="15"
                                    >mdi-close
                                  </v-icon>
                                </v-col>
                              </v-row>
                            </v-container>
                          </v-col>
                        </template>
                        <template v-if="element.jobStatus === 2">
                          <v-col
                            cols="2"
                            class="ma-0 px-0 py-1"
                            v-bind:style="{
                              backgroundColor: '#388E3C',
                              width: '100%',
                            }"
                          >
                            <v-container fluid fill-height class="my-0 py-0">
                              <v-row align="center" justify="center">
                                <v-col cols="12">
                                  <v-icon color="white" size="15"
                                    >mdi-check
                                  </v-icon>
                                </v-col>
                              </v-row>
                            </v-container>
                          </v-col>
                        </template>
                        <v-col
                          cols="12"
                          class="ma-0 pa-0"
                          v-bind:style="{
                            backgroundColor: '#38454C',
                            color: 'white',
                            maxHeight: '17px',
                          }"
                        >
                          {{ element.equipmentText }}
                        </v-col>
                      </v-row>
                    </v-card>
                  </v-list-item>
                </template>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>

    <v-card
      class="pb-1"
      v-bind:style="{
        fontFamily: 'Oswald,sans-serif',
        backgroundColor: '#F0F0F0',
        position: 'absolute',
        left: '1.3vw',
        width: '49vw',
        top: '72vh',
      }"
    >
      <v-card-text class="pa-0 ">
        <div
          class="py-1"
          v-bind:style="{
            textAlign: 'center',
            backgroundColor: '#E65100',
            color: 'white',
          }"
        >
          Szűrő
          <v-icon small color="white">mdi-filter</v-icon>
        </div>
        <v-row class="px-3 py-2">
          <v-col cols="2" class="px-1 py-1">
            <v-select
              class="font-class-name my-1"
              @change="filterSearch()"
              v-model="filterValue"
              :items="filterDataNotif"
              label="Jelentés Típusa"
              hide-details
              :disabled="disablefilter"
              clearable
              multiple
              outlined
              dense
              chips
            />
          </v-col>
          <v-col cols="2" class="px-1 py-1">
            <v-select
              class="font-class-name my-1"
              @change="filterSearch()"
              v-model="filterValueFactory"
              :items="filterDataFactory"
              label="Telepítési Gyár"
              hide-details
              :disabled="disablefilter"
              clearable
              multiple
              outlined
              dense
              chips
            />
          </v-col>
          <v-col cols="2" class="px-1 py-1">
            <v-select
              class="font-class-name my-1"
              @change="filterSearch()"
              v-model="filterValuePlace"
              :items="filterDataPlace"
              label="Telepítési Hely"
              hide-details
              :disabled="disablefilter"
              clearable
              multiple
              outlined
              dense
              chips
            />
          </v-col>
          <v-col cols="6" class="px-1 py-1">
            <v-select
              class="font-class-name my-1"
              @change="filterSearch()"
              v-model="filterValueLastName"
              :items="filterDataLastName"
              label="Jelentő"
              hide-details
              clearable
              multiple
              outlined
              dense
              chips
            />
          </v-col>
          <v-col cols="3" class="px-1 pt-0">
            <v-select
              class="font-class-name my-1"
              @change="filterSearch()"
              v-model="filterValuePriority"
              item-text="name"
              item-value="value"
              :items="priorityListFilter"
              label="Prioritás"
              hide-details
              clearable
              multiple
              outlined
              dense
              chips
            />
          </v-col>
          <v-col cols="9" class="pt-1">
            <v-row>
              <v-col cols="6" class="px-1">
                <v-menu
                  ref="menuDateStart"
                  v-model="menuDateStart"
                  :close-on-content-click="false"
                  :return-value.sync="date"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      class="font-class-name"
                      v-model="filterValueDateStart"
                      label="Indításí Határidő"
                      prepend-icon="mdi-calendar"
                      hide-details
                      v-bind="attrs"
                      v-on="on"
                      outlined
                      clearable
                      readonly
                      dense
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="filterValueDateStart"
                    locale="hu-HU"
                    range
                    no-title
                    scrollable
                  >
                    <v-spacer></v-spacer>
                    <v-btn text color="#38454C" @click="menuDateStart = false">
                      Mégse
                    </v-btn>
                    <v-btn
                      class="white--text"
                      color="green"
                      @click="
                        $refs.menuDateStart.save(filterValueDateStart),
                          filterSearch()
                      "
                    >
                      Kuld
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="6" class="px-1">
                <v-menu
                  ref="menuDateEnd"
                  v-model="menuDateEnd"
                  :close-on-content-click="false"
                  :return-value.sync="date"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      class="font-class-name "
                      v-model="filterValueDateEnd"
                      label="Befejezési Határidő"
                      prepend-icon="mdi-calendar"
                      hide-details
                      v-bind="attrs"
                      v-on="on"
                      outlined
                      clearable
                      readonly
                      dense
                    />
                  </template>
                  <v-date-picker
                    v-model="filterValueDateEnd"
                    locale="hu-HU"
                    range
                    no-title
                    scrollable
                  >
                    <v-spacer></v-spacer>
                    <v-btn text color="#38454C" @click="menuDateEnd = false">
                      Mégse
                    </v-btn>
                    <v-btn
                      class="white--text"
                      color="green"
                      @click="
                        $refs.menuDateEnd.save(filterValueDateEnd),
                          filterSearch()
                      "
                    >
                      Kuld
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <v-dialog v-model="modalDetail" width="90vw" persistent>
      <v-card>
        <v-btn
          icon
          dark
          class="ma-1"
          v-bind:style="[
            detailData.sapNumber !== null && detailData.sapNumber !== undefined
              ? { position: 'absolute', left: 0, top: 0 }
              : {
                  cursor: 'not-allowed',
                  pointerEvents: 'none',
                  position: 'absolute',
                  color: '#38454C',
                  left: 0,
                  top: 0,
                },
          ]"
          @click="openModalHourWorks(detailData.sapNumber)"
          ><v-icon>mdi-account-clock</v-icon></v-btn
        >
        <h3
          class="py-2"
          v-bind:style="{
            backgroundColor: '#0A173D',
            fontFamily: 'Oswald,sans-serif',
            color: 'white',
            textAlign: 'center',
          }"
        >
          {{ title }}
          <v-btn
            icon
            @click="closeModalDetail()"
            v-bind:style="{ position: 'absolute', right: 0, top: 0 }"
          >
            <v-icon color="white">mdi-close</v-icon>
          </v-btn>
        </h3>
        <!-----   Loading   ------->
        <v-card-text class="pt-3" v-bind:style="{ display: loadingDetail }">
          <v-row>
            <v-col cols="6">
              <v-skeleton-loader
                class="rounded-0"
                v-bind="attrs"
                type="image"
              />
              <v-skeleton-loader
                class="rounded-0"
                v-bind="attrs"
                type="image"
              />
            </v-col>
            <v-col cols="6">
              <v-skeleton-loader
                class="rounded-0"
                v-bind="attrs"
                type="image"
              />
              <v-skeleton-loader
                class="rounded-0"
                v-bind="attrs"
                type="image"
              />
            </v-col>
            <v-col cols="12">
              <v-skeleton-loader v-bind="attrs" type="image" />
            </v-col>
          </v-row>
        </v-card-text>
        <!-----   Data   ------->
        <v-card-text class="pt-3">
          <template v-if="detailData !== null">
            <v-row>
              <v-col cols="6">
                <v-card>
                  <v-row class="mt-1 mx-0">
                    <v-col
                      class="mx-0 px-0 pt-0"
                      v-for="(item, i) in detailData.sapNumber"
                      :cols="orderDialogNumber(item.name)"
                      :key="i"
                    >
                      <template
                        v-if="
                          item.name === 'Jelentés Száma' ||
                            item.name === 'Hosszú szöveg'
                        "
                      >
                        <template v-if="item.name === 'Jelentés Száma'">
                          <h3
                            v-bind:style="{
                              backgroundColor: '#E65100',
                              color: 'white',
                              textAlign: 'center',
                              padding: '0.5em 0',
                            }"
                          >
                            {{ item.name }} {{ item.value }}
                          </h3>
                        </template>
                        <template v-else>
                          <div class="mx-1">
                            <template
                              v-if="
                                item.value !== '' &&
                                  item.value !== null &&
                                  item.value !== undefined
                              "
                            >
                              <v-textarea
                                v-bind:style="{ fontSize: '1em', padding: 0 }"
                                :label="item.name"
                                :value="item.value"
                                row-height="15"
                                rows="3"
                                hide-details
                                outlined
                                readonly
                                dense
                                flat
                              />
                            </template>
                            <template v-else>
                              <v-textarea
                                v-bind:style="{ fontSize: '1em', padding: 0 }"
                                :label="item.name"
                                value=" "
                                row-height="15"
                                rows="3"
                                hide-details
                                outlined
                                readonly
                                dense
                                flat
                              />
                            </template>
                          </div>
                        </template>
                      </template>
                      <template v-else>
                        <div class="mx-1">
                          <template
                            v-if="
                              item.value !== '' &&
                                item.value !== null &&
                                item.value !== undefined
                            "
                          >
                            <v-text-field
                              v-bind:style="{ fontSize: '1em', padding: 0 }"
                              :label="item.name"
                              :value="item.value"
                              outlined
                              hide-details
                              readonly
                              dense
                              flat
                            />
                          </template>
                          <template v-else>
                            <v-text-field
                              v-bind:style="{ fontSize: '1em', padding: 0 }"
                              :label="item.name"
                              value=" "
                              hide-details
                              outlined
                              readonly
                              dense
                            />
                          </template>
                        </div>
                      </template>
                    </v-col>
                  </v-row>
                </v-card>
              </v-col>
              <v-col cols="6">
                <v-card>
                  <v-row class="mt-1 mx-0">
                    <v-col
                      class="mx-0 px-0 pt-0"
                      v-for="(item, i) in detailData.sapOrder"
                      :cols="orderDialogSAP(item.name)"
                      :key="i"
                    >
                      <template
                        v-if="
                          item.name === 'SAP Rendelés' ||
                            item.name === 'Hosszú szöveg'
                        "
                      >
                        <template v-if="item.name === 'SAP Rendelés'">
                          <h3
                            v-bind:style="{
                              backgroundColor: '#0D47A1',
                              color: 'white',
                              textAlign: 'center',
                              padding: '0.5em 0',
                            }"
                          >
                            {{ item.name }} {{ item.value }}
                          </h3>
                        </template>
                        <template v-else>
                          <div class="mx-1">
                            <template
                              v-if="
                                item.value !== '' &&
                                  item.value !== null &&
                                  item.value !== undefined
                              "
                            >
                              <v-textarea
                                v-bind:style="{ fontSize: '1em', padding: 0 }"
                                :label="item.name"
                                :value="item.value"
                                row-height="15"
                                rows="5"
                                hide-details
                                outlined
                                readonly
                                dense
                                flat
                              />
                            </template>
                            <template v-else>
                              <v-textarea
                                v-bind:style="{ fontSize: '1em', padding: 0 }"
                                :label="item.name"
                                value=" "
                                row-height="15"
                                rows="5"
                                hide-details
                                outlined
                                readonly
                                dense
                                flat
                              />
                            </template>
                          </div>
                        </template>
                      </template>
                      <template v-else>
                        <div class="mx-1">
                          <template
                            v-if="
                              item.value !== '' &&
                                item.value !== null &&
                                item.value !== undefined
                            "
                          >
                            <v-text-field
                              v-bind:style="{ fontSize: '1em', padding: 0 }"
                              :label="item.name"
                              :value="item.value"
                              outlined
                              hide-details
                              readonly
                              dense
                              flat
                            />
                          </template>
                          <template v-else>
                            <v-text-field
                              v-bind:style="{ fontSize: '1em', padding: 0 }"
                              :label="item.name"
                              value=" "
                              hide-details
                              outlined
                              readonly
                              dense
                            />
                          </template>
                        </div>
                      </template>
                    </v-col>
                  </v-row>
                </v-card>
              </v-col>
            </v-row>
          </template>
          <template v-else>
            No data
          </template>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="modalError" width="30vw">
      <v-card
        v-bind:style="{
          textAlign: 'center',
          backgroundColor: '#D50000',
          color: 'white',
        }"
        class="py-4"
      >
        <v-btn
          icon
          @click="modalError = false"
          v-bind:style="{ position: 'absolute', right: 0, top: 0 }"
        >
          <v-icon color="white">mdi-close</v-icon>
        </v-btn>
        {{ messageView(errorMessage) }}
      </v-card>
    </v-dialog>
    <v-dialog v-model="sapPropertiesModal" persistent width="30vw">
      <v-card>
        <h3
          class="pa-2 text-center white--text"
          v-bind:style="{ backgroundColor: '#E65100', width: '100%' }"
        >
          Belső Prioritás Megadása
        </h3>
        <v-row class="ma-0">
          <v-col cols="12">
            <v-text-field
              v-model="sapPropertiesnNumber"
              label="Jelentés Szám"
              hide-details
              readonly
              outlined
            />
          </v-col>
          <v-col cols="12">
            <v-select
              label="Prioritás"
              :items="priorityList"
              v-model="sapPropertiesPriority"
              hide-details
              outlined
            />
          </v-col>
          <v-col cols="12" class="px-6 mb-3">
            <v-row v-bind:style="{ border: '1px solid #9E9E9E' }">
              <v-col cols="12">
                <span class="text-center" style="color:#757575;font-size:0.9em">
                  Tervezett Munkaóra
                </span>
                <v-row class="mt-1">
                  <v-col cols="12">
                    <v-text-field
                      v-model="sapPropertiesnWorkHour"
                      hide-details
                      type="number"
                      label="Óra"
                      outlined
                    />
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-col>

          <v-col cols="12" class="px-6">
            <v-row v-bind:style="{ border: '1px solid #9E9E9E' }">
              <v-col cols="12">
                <span class="text-center" style="color:#757575;font-size:0.9em">
                  Tervezett Átadási Határidő
                </span>
                <v-row>
                  <v-col cols="6">
                    <v-menu
                      v-model="menu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="date"
                          label="Datum"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="date"
                        @input="menu = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="6">
                    <v-menu
                      ref="menu"
                      v-model="menu2"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      :return-value.sync="time"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="time"
                          label="Óra"
                          prepend-icon="mdi-clock-time-four-outline"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        v-if="menu2"
                        v-model="time"
                        full-width
                        @click:minute="$refs.menu.save(time)"
                      ></v-time-picker>
                    </v-menu>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-col>
          <v-col cols="12">
            <v-btn
              @click="putProperties()"
              v-bind:style="{ fontFamily: 'Oswald,sans-serif' }"
              class="white--text"
              color="#0A173D"
              block
              >Módosít
            </v-btn>
          </v-col>
        </v-row>
      </v-card>
    </v-dialog>
    <v-dialog v-model="modalHourWorks" width="30vw" persistent>
      <v-card>
        <h3
          class="py-2"
          v-bind:style="{
            backgroundColor: '#1E1E1E',
            fontFamily: 'Oswald,sans-serif',
            color: 'white',
            textAlign: 'center',
          }"
        >
          Visszajeletések
          <v-btn
            icon
            @click="closeModalHourWorks"
            v-bind:style="{ position: 'absolute', right: 0, top: 0 }"
          >
            <v-icon color="white">mdi-close</v-icon>
          </v-btn>
        </h3>
        <v-data-table
          dark
          center
          fixed-header
          height="300px"
          :headers="headers"
          class="elevation-1"
          :items="hourTestWorker"
          :footer-props="{
            'items-per-page-options': [itemPerPage],
          }"
        />
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from "axios";
const detailUrl = "http://192.168.4.11/vaultbrowser/db/detailSAP.php";
const jobUrl = "http://192.168.4.11/vaultbrowser/db/childWorkTMESrepair.php";
const partsUrl = "http://192.168.4.11/vaultbrowser/db/partsDatarepair.php";
//const sapCreateUrl = "http://192.168.4.11/vaultbrowser/db/cOrderNotif.php";
const sapProp = "http://192.168.4.11/vaultbrowser/db/propertiesNotif.php";
const manageUrl = "http://192.168.4.79:20000/api/management/";
const filterUrl = "http://192.168.4.11/vaultbrowser/db/typeFilterRepair.php";
const testTableUrl = "http://192.168.4.11/vaultbrowser/db/testTable.php";
const headers = {
  "Content-Type": "application/json",
  Authorization:
    "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA",
};
import draggable from "vuedraggable";
export default {
  name: "Repair",
  display: "Two Lists",
  order: 1,
  components: {
    draggable,
  },
  data() {
    return {
      selectedItem: "",
      PanelMachineHeight: "80vh",
      list: [],
      machine: [],
      listUsed: [],
      detailData: [],
      modalDetail: false,
      title: "",
      test: 1,
      errorMessage: "",
      modalError: false,
      sapPropertiesModal: false,
      sapPropertiesnNumber: "",
      sapPropertiesPriority: "",
      sapPropertiesEndDate: "",
      sapPropertiesnWorkHour: 0,
      sapPropertiesnWorkMinutes: 0,
      time: null,
      menu2: false,
      menu: false,
      date: new Date().toISOString().substr(0, 10),
      priorityList: ["Nagyon Magas", "Magas", "Normál", "Alacsony", "Nincs"],
      loadingDetail: "block",
      attrs: {},
      userState: "",
      page: 1,
      perPage: 20,
      filterDataNotif: [],
      filterDataFactory: [],
      filterDataPlace: [],
      filterDataLastName: [],
      priorityListFilter: [
        { name: "Nagyon Magas", value: "#FF00FF" },
        { name: "Magas", value: "#FF0000" },
        { name: "Normál", value: "#FFA500" },
        { name: "Alacsony", value: "#9ACD32" },
        { name: "Nincs", value: "#263238" },
      ],
      filterValue: ["JG"],
      filterValueFactory: "",
      filterValuePlace: "",
      filterValueLastName: "",
      filterValuePriority: "",
      filterValueDateStart: [],
      filterValueDateEnd: [],
      statusListPost: "default",
      menuDateStart: false,
      menuDateEnd: false,
      disablefilter: false,
      modalHourWorks: false,
      hourTestWorker: new Array(),
      headers: [
        { text: "Dolgozó", value: "name", class: "orange darken-4" },
        { text: "Megnevezés", value: "text", class: "orange darken-4" },
        { text: "Dátum", value: "date", class: "orange darken-4" },
        { text: "Óra", value: "time", class: "orange darken-4" },
      ],
      itemPerPage: 5,
    };
  },
  mounted() {
    this.update();
    setInterval(this.update, 5000);
  },
  computed: {
    visibleList() {
      if (this.page === 1) {
        return this.list.slice(0, this.perPage);
      } else {
        return this.list.slice(
          this.page * this.perPage - this.perPage,
          this.page * this.perPage
        );
      }
    },
  },

  methods: {
    update() {
      this.filterSearch();
      this.userStatus();
      this.childWork();
      //this.listFilter();
    },
    userStatus() {
      this.userState = localStorage.user;
    },
    openModalHourWorks(value) {
      if (value !== null && value !== undefined) {
        this.modalHourWorks = true;
        this.dataModalHourWorks(value[9]);
        //load data table
      }
    },
    dataModalHourWorks(data) {
      axios
        .post(testTableUrl, JSON.stringify({ equipmentNumber: data }))
        .then((resp) => {
          if (resp.data == null || resp.data == "") {
            this.hourTestWorker = [];
          } else {
            this.hourTestWorker = resp.data;
          }
        });
    },
    closeModalHourWorks() {
      this.modalHourWorks = false;
      this.hourTestWorker = [];
      //clean table
    },
    listFilterDisabled() {
      if (this.filterValueLastName.length > 0) {
        this.disablefilter = true;
      } else {
        this.disablefilter = false;
      }
    },
    listFilterPost() {
      axios
        .post(
          filterUrl,
          JSON.stringify({
            typeForm: "Post",
            notificationPost: this.filterValue,
            deployFactoryPost: this.filterValueFactory,
            deployPlacePost: this.filterValuePlace,
          })
        )
        .then((response) => {
          //console.log(response.data);
          if (response.data !== null || response.data !== undefined) {
            this.filterDataNotif = response.data.notification;
            this.filterDataFactory = response.data.deployFactory;
            this.filterDataPlace = response.data.deployPlace;
            this.filterDataLastName = response.data.lastName;
          }
        });
    },
    filterSearch() {
      this.listFilterDisabled();
      this.listFilterPost();
      axios
        .post(
          partsUrl,
          JSON.stringify({
            typeForm: "post",
            typePost: this.filterValue,
            deployFactoryPost: this.filterValueFactory,
            deployPlacePost: this.filterValuePlace,
            lastNamePost: this.filterValueLastName,
            priorityPost: this.filterValuePriority,
            dateStartPost: this.filterValueDateStart,
            dateEndPost: this.filterValueDateEnd,
          })
        )
        .then((response) => {
          this.list = response.data;
          //console.log(JSON.stringify(this.list));
        });
    },

    listParts() {
      axios
        .post(partsUrl, JSON.stringify({ typeForm: "default" }))
        .then((response) => {
          this.list = response.data;
          //console.log(this.list);
        });
    },
    childWork() {
      axios.get(jobUrl).then((response) => {
        this.machine = response.data;
        //console.log(this.machine);
      });
    },
    orderDialogSAP(value) {
      if (value === "SAP Rendelés" || value === "Hosszú szöveg") {
        return "12";
      } else if (
        value === "Tervező Csoport" ||
        value === "Forendeles Szam" ||
        value === "Berendezés"
      ) {
        return "4";
      } else if (
        value === "Eszköz Megnevezése" ||
        value === "Berendezés Megnevezés" ||
        value === "Rövid Szöveg"
      ) {
        return "6";
      } else if (
        value === "Prioritás" ||
        value === "Rendelés Típusa" ||
        value === "Eszköz Szám" ||
        value === "Eszköz Alszám" ||
        value === "Telepitesi Gyár" ||
        value === "Telepítési Hely" ||
        value === "Vállalat Kódja" ||
        value === "Jelentes szam" ||
        value === "Berendezés Típusa"
      ) {
        return "2";
      } else if (value === "Létrehozás Dátuma" || value === "Munkahely") {
        return "3";
      } else if (value === "Gyar Kod") {
        return "1";
      } else if (value === "Muszaki Hely") {
        return "5";
      }
    },
    orderDialogNumber(value) {
      if (value === "Jelentés Száma") {
        return "12";
      } else if (
        value === "Indításí Határidő" ||
        value === "Várható befejezési Határidő" ||
        value === "Jelentő" ||
        value === "Jelentő Törzsszáma" ||
        value === "Berendezés száma"
      ) {
        return "4";
      } else if (
        value === "Érintett Berendezés" ||
        value === "Érintett Műszaki" ||
        value === "Felelős Munkahely"
      ) {
        return "3";
      } else if (
        value === "Rövid Szöveg" ||
        value === "Műszaki Hely" ||
        value === "Berendezés Megnevezés" ||
        value === "Eszköz Megnevezése"
      ) {
        return "6";
      } else if (
        value === "Jelentés Típusa" ||
        value === "Telepítési Gyár" ||
        value === "Telepítési Hely" ||
        value === "Eszköz Szám" ||
        value === "Eszköz Alszám" ||
        value === "Vállalat Kódja" ||
        value === "Prioritás" ||
        value === "PP gép" ||
        value === "Berendezés Típusa"
      ) {
        return "2";
      } else if (value === "Gyár") {
        return "1";
      }
    },
    orderDialogDetail(value) {
      if (value === "Név") {
        return "12";
      } else if (
        value === "FileLfCyc" ||
        value === "Comm" ||
        value === "CheckedOut" ||
        value === "Datum" ||
        value === "Anyag"
      ) {
        return "3";
      } else if (value === "Detail") {
        return "12";
      } else if (value === "Rajzszám" || value === "Projekt") {
        return "4";
      } else if (value === "Darabszám") {
        return "1";
      }
    },
    closeModalDetail() {
      this.modalDetail = false;
      this.detailData = [];
      this.loadingDetail = "block";
    },
    detail(value, name) {
      this.modalDetail = true;
      this.title = name;
      axios
        .post(
          detailUrl,
          JSON.stringify({
            id: value,
          })
        )
        .then((response) => {
          this.loadingDetail = "none";
          this.detailData = response.data;
          console.log(this.detailData);
        });
    },
    addItem(value) {
      //console.log(value);
      let itemInList = [];
      let idInList = [];
      for (var i = 0; i < value.list.length; i++) {
        itemInList.push(value.list[i].idJob);
        if (value.list[i].idJob !== null && value.list[i].idJob !== undefined) {
          idInList.push(value.list[i].id);
        }
      }
      if (itemInList.indexOf(undefined) === -1) {
        //Change between list

        for (var k = 0; k < value.list.length; k++) {
          if (value.id !== value.list[k].idchild) {
            var deleteJob = value.list[k].idJob;
            var notifNumberChange = value.list[k].id;
          }
        }

        axios
          .delete(manageUrl + "Job/" + deleteJob, {
            headers,
          })
          .then((res) => {
            console.log(res.data);
            var postJobchange = {
              parentTerminalId: parseInt(value.idParent),
              childTerminalId: parseInt(value.id),
              notificationNumber: parseInt(notifNumberChange),
            };
            axios
              .post(manageUrl + "Job", postJobchange, { headers })
              .then((response) => {
                console.log(response.data);
                console.clear();
                this.update();
              });
          });
      } else {
        //New item

        /*
        for (var j = 0; j < value.list.length; j++) {
          if (idInList.indexOf(value.list[j].id) === -1) {
            var notifNumber = value.list[j].id;

            //PUT SAP Properties
            var priorityPUT = value.list[j].priority;
            var endDatePUT = value.list[j].endDate;
          }
          if (value.list[j].id === value.list[j].sapOrder) {
            var notifNumberCreate = value.list[j].id;

            //PUT SAP Properties
            var notifNumberPUTc = value.list[j].id;
            var priorityPUTc = value.list[j].priority;
            var endDatePUTc = value.list[j].endDate;
          }
        }
                //Value Default value SAP Propierties
        if (notifNumberCreate !== undefined) {
          this.sapPropertiesnNumber = notifNumberPUTc;
          this.sapPropertiesPriorityNumber = priorityPUTc;
          this.sapPropertiesEndDate = endDatePUTc;
        } else {
          this.sapPropertiesnNumber = notifNumber;
          this.sapPropertiesPriorityNumber = priorityPUT;
          this.sapPropertiesEndDate = endDatePUT;
        }
*/

        for (var j = 0; j < value.list.length; j++) {
          if (idInList.indexOf(value.list[j].id) === -1) {
            this.sapPropertiesnNumber = value.list[j].id;
            this.sapPropertiesPriorityNumber = value.list[j].priority;
            this.sapPropertiesEndDate = value.list[j].endDate;
          }
        }
        if (
          this.sapPropertiesEndDate !== "" &&
          this.sapPropertiesEndDate !== null &&
          this.sapPropertiesEndDate !== undefined
        ) {
          this.date = this.sapPropertiesEndDate.substr(0, 10);
          this.time = this.sapPropertiesEndDate.substr(11, 5);
        }
        console.log(this.sapPropertiesPriorityNumber);
        if (
          this.sapPropertiesPriorityNumber !== "" &&
          this.sapPropertiesPriorityNumber !== null
        ) {
          if (this.sapPropertiesPriorityNumber === "#FF00FF") {
            this.sapPropertiesPriority = "Nagyon Magas";
          } else if (this.sapPropertiesPriorityNumber === "#FF0000") {
            this.sapPropertiesPriority = "Magas";
          } else if (this.sapPropertiesPriorityNumber === "#FFA500") {
            this.sapPropertiesPriority = "Normál";
          } else if (this.sapPropertiesPriorityNumber === "#9ACD32") {
            this.sapPropertiesPriority = "Alacsony";
          } else {
            this.sapPropertiesPriority = "Nincs";
          }
        } else {
          this.sapPropertiesPriority = "Nincs";
        }

        //Value POST JOB
        var postJob = {
          parentTerminalId: parseInt(value.idParent),
          childTerminalId: parseInt(value.id),
          //notificationNumber: parseInt(notifNumber),
          notificationNumber: parseInt(this.sapPropertiesnNumber),
        };

        axios.post(manageUrl + "Job", postJob, { headers }).then((response) => {
          console.log(response.data);
          // var jobID = response.data.terminalJob.id;
          //create Notification
          /* if (notifNumberCreate !== undefined) {
            console.log("create notification");
            axios
              .post(
                sapCreateUrl,
                JSON.stringify({
                  notificationNumber: notifNumberCreate,
                })
              )
              .then((resp) => {
                if (resp.data.length > 50) {
                  this.errorMessage = resp.data;
                  this.modalError = true;
                  axios
                    .delete(manageUrl + "Job/" + jobID, { headers })
                    .then((response) => {
                      console.log(response.data);
                      //console.clear();
                      this.update();
                    });
                } else {
                  //Modal PUT SAP Propierties
                  this.sapPropertiesModal = true;
                  this.update();
                }
              });


            this.sapPropertiesModal = true;
            this.update();
          } else {
            //Modal PUT SAP Propierties
            this.sapPropertiesModal = true;
          }*/

          this.sapPropertiesModal = true;
        });
      }
    },

    jobDelete(value) {
      const idDelete = manageUrl + "Job/" + value;
      confirm("Biztos hogy törölni akarja az alkatrészet?") &&
        axios.delete(idDelete, { headers }).then((response) => {
          console.log(response.data);
          console.clear();
          this.update();
        });
    },
    putProperties() {
      axios
        .post(
          sapProp,
          JSON.stringify({
            notificationNumber: this.sapPropertiesnNumber,
            priority: this.sapPropertiesPriority,
            endDate: this.date + "T" + this.time + ":00.000Z",
            workTimeH: this.sapPropertiesnWorkHour,
            workTimeM: this.sapPropertiesnWorkMinutes,
          })
        )
        .then((resp) => {
          console.log(resp.data);
          console.clear();
        });
      this.sapPropertiesModal = false;
      this.sapPropertiesnWorkHour = 0;
      this.sapPropertiesnWorkMinutes = 0;
    },
    clonePart({ name, id, sapOrder, endDate, priority }) {
      return {
        id: id,
        name: name,
        sapOrder: sapOrder,
        endDate: endDate,
        priority: priority,
      };
    },
    messageView(value) {
      if (value !== undefined) {
        var messageFormat = value.split("-");
        return messageFormat[1];
      }
    },
  },
};
</script>
<style>
@media only screen and (min-device-width: 700px) {
  ::-webkit-scrollbar {
    width: 5px;
  }
  ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px #d9d9d9;
    border-radius: 5px;
  }
  ::-webkit-scrollbar-thumb {
    background: #d1d1d1;
    border-radius: 10px;
  }
}
.font-class-name * {
  font-size: 12px;
}
.font-class-work * {
  font-size: 9px;
}

.loadingClock {
  width: 10px;
  height: 12px;
  z-index: 10;
  left: 0;
  right: 0;
  margin: auto;
  border-top: 0.1em solid rgba(255, 255, 255, 0);
}
.hourglass-top {
  border-top: 6px solid #ffffff;
}
.hourglass-bottom {
  border-bottom: 6px solid #ffffff;
}
.hourglass-top,
.hourglass-bottom {
  position: relative;
  border-left: 4.5px solid transparent;
  border-right: 4.5px solid transparent;
}
.sand-top,
.sand-bottom {
  position: absolute;
  border-left: 4.5px solid transparent;
  border-right: 4.5px solid transparent;
  right: 50%;
}
.sand-top,
.sand-bottom,
.loadingClock {
  animation-timing-function: linear;
  animation-duration: 1.8s;
  animation-iteration-count: infinite;
}
.sand-top {
  animation-name: topsand;
  border-top: 4.5px solid #38454c;
  transform: translate(50%, -100%);
}
.sand-bottom {
  animation-name: bottomsand;
  border-bottom: 4.5px solid #38454c;
  transform: translate(50%, 0);
}
.loadingClock {
  animation-name: hgrotate;
}
@keyframes bottomsand {
  0% {
    clip: rect(4.5px, 20px, 25px, 0);
  }
  70% {
    clip: rect(0, 20px, 25px, 0);
  }
  100% {
    clip: rect(0, 20px, 25px, 0);
  }
}
@keyframes topsand {
  0% {
    clip: rect(0, 20px, 25px, 0);
  }
  70% {
    clip: rect(4.5px, 20px, 25px, 0);
  }
  100% {
    clip: rect(4.5px, 20px, 25px, 0);
  }
}
@keyframes hgrotate {
  80% {
    -ms-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(180deg);
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }
}
.spin {
  -webkit-animation: spin 4s linear infinite;
  -moz-animation: spin 4s linear infinite;
  animation: spin 4s linear infinite;
}
.spin-back {
  -webkit-animation: spin-back 4s linear infinite;
  -moz-animation: spin-back 4s linear infinite;
  animation: spin-back 4s linear infinite;
}
@-moz-keyframes spin {
  100% {
    -moz-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  100% {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@-moz-keyframes spin-back {
  100% {
    -moz-transform: rotate(-360deg);
  }
}

@-webkit-keyframes spin-back {
  100% {
    -webkit-transform: rotate(-360deg);
  }
}

@keyframes spin-back {
  100% {
    -webkit-transform: rotate(-360deg);
    transform: rotate(-360deg);
  }
}
</style>
