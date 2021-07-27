<template>
  <div v-bind:style="{ width: '80vh' }">
    <v-container>
      <v-row
        class="py-1 pr-5 pl-1"
        v-bind:style="{ margin: 0, width: '100vw' }"
      >
        <v-col cols="2" class="pa-0">
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
              Alkatrészek

              <v-icon small color="white">
                mdi-puzzle
              </v-icon>
              <span
                class="py-2 pr-3"
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
              v-bind:style="{ height: PanelPartHeight }"
              class="overflow-y-auto pt-3"
              color="primary"
            >
              <v-container fluid fill-height class="px-0">
                <v-layout align-center justify-center>
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
                          v-for="element in visibleList"
                          :key="element.id"
                          v-bind:style="{
                            fontFamily: 'Oswald, sans-serif',
                            fontSize: '0.9em',
                            margin: '.6em 0.2em',
                            minHeight: '65px',
                            display: 'inline-block',
                            width: '7.5vw',
                          }"
                          class="px-3 py-1"
                        >
                          <v-row
                            v-bind:style="{
                              backgroundColor: '#38454C',
                              borderRadius: '0 0 .8em .8em',
                              color: '#FFFFFF',
                            }"
                          >
                            <v-col cols="2" class="pa-0">
                              <v-icon
                                v-bind:style="{
                                  display: 'block',
                                  padding: '1.1em 0.4em 1.1em 0.4em',
                                }"
                                @click="detail(element.id, element.name)"
                                color="#FFFFFF"
                                size="12"
                              >
                                mdi-text-box
                              </v-icon>
                            </v-col>
                            <v-col cols="10" class="pa-0">
                              <span
                                v-bind:style="{
                                  height: '40px',
                                  display: 'flex',
                                  justifyContent: 'center',
                                  alignItems: 'center',
                                  textAlign: 'center',
                                  fontSize: '0.8em',
                                }"
                              >
                                {{ element.name }}
                              </span>
                            </v-col>
                            <v-col
                              cols="12"
                              class="pa-0 ma-0"
                              v-bind:style="{
                                backgroundColor: '#38454C',
                                borderTop: '1px solid white',
                                maxHeight: '17px',
                                fontSize: '.7em',
                              }"
                            >
                              {{ element.equipmentText }}
                            </v-col>
                            <v-col cols="12" class="pa-0">
                              <v-row
                                v-bind:style="[
                                  element.priority === '#FFE32A'
                                    ? {
                                        fontSize: '0.6em',
                                        backgroundColor: element.priority,
                                        color: '#38454C',
                                        margin: 0,
                                        padding: '.3em 0',
                                        borderRadius: '0 0 .8em .8em',
                                      }
                                    : {
                                        fontSize: '0.6em',
                                        backgroundColor: element.priority,
                                        color: 'white',
                                        margin: 0,
                                        padding: '.3em 0',
                                        borderRadius: '0 0 .8em .8em',
                                      },
                                ]"
                              >
                                <v-col
                                  v-bind:style="{
                                    minWidth: '2vw',
                                    maxWidth: '2vw',
                                    padding: 0,
                                  }"
                                >
                                  {{ element.sapOrder }}
                                </v-col>
                                <v-col
                                  v-bind:style="{
                                    minWidth: '2.8vw',
                                    maxWidth: '2.8vw',
                                    padding: 0,
                                  }"
                                >
                                  {{ element.equipment }}
                                </v-col>
                                <v-col
                                  v-bind:style="{
                                    minWidth: '2.5vw',
                                    maxWidth: '2.5vw',
                                    padding: 0,
                                  }"
                                >
                                  {{ element.date }}
                                </v-col>
                              </v-row>
                            </v-col>
                          </v-row>
                        </v-list-item>
                      </draggable>
                    </template>
                    <template v-else>
                      <v-list-item
                        v-for="element in visibleList"
                        :key="element.id"
                        v-bind:style="{
                          fontFamily: 'Oswald, sans-serif',
                          fontSize: '0.9em',
                          margin: '.6em 0.2em',
                          minHeight: '65px',
                          display: 'inline-block',
                          width: '7.5vw',
                        }"
                        class="px-3 py-1"
                      >
                        <v-row
                          v-bind:style="{
                            backgroundColor: '#38454C',
                            borderRadius: '0 0 .8em .8em',
                            color: '#FFFFFF',
                          }"
                        >
                          <v-col cols="2" class="pa-0">
                            <v-icon
                              v-bind:style="{
                                display: 'block',
                                padding: '1.1em 0.4em 1.1em 0.4em',
                              }"
                              @click="detail(element.id, element.name)"
                              color="#FFFFFF"
                              size="12"
                            >
                              mdi-text-box
                            </v-icon>
                          </v-col>
                          <v-col cols="10" class="pa-0">
                            <span
                              v-bind:style="{
                                height: '40px',
                                display: 'flex',
                                justifyContent: 'center',
                                alignItems: 'center',
                                textAlign: 'center',
                                fontSize: '0.8em',
                              }"
                            >
                              {{ element.name }}
                            </span>
                          </v-col>
                          <v-col
                            cols="12"
                            class="pa-0 ma-0"
                            v-bind:style="{
                              backgroundColor: '#38454C',
                              borderTop: '1px solid white',
                              maxHeight: '17px',
                              fontSize: '.7em',
                            }"
                          >
                            {{ element.equipmentText }}
                          </v-col>

                          <v-col cols="12" class="pa-0">
                            <v-row
                              v-bind:style="[
                                element.priority === '#FFE32A'
                                  ? {
                                      fontSize: '0.6em',
                                      backgroundColor: element.priority,
                                      color: '#38454C',
                                      margin: 0,
                                      padding: '.3em 0',
                                      borderRadius: '0 0 .8em .8em',
                                    }
                                  : {
                                      fontSize: '0.6em',
                                      backgroundColor: element.priority,
                                      color: 'white',
                                      margin: 0,
                                      padding: '.3em 0',
                                      borderRadius: '0 0 .8em .8em',
                                    },
                              ]"
                            >
                              <v-col
                                v-bind:style="{
                                  minWidth: '2vw',
                                  maxWidth: '2vw',
                                  padding: 0,
                                }"
                              >
                                {{ element.sapOrder }}
                              </v-col>
                              <v-col
                                v-bind:style="{
                                  minWidth: '2.8vw',
                                  maxWidth: '2.8vw',
                                  padding: 0,
                                }"
                              >
                                {{ element.equipment }}
                              </v-col>
                              <v-col
                                v-bind:style="{
                                  minWidth: '2.5vw',
                                  maxWidth: '2.5vw',
                                  padding: 0,
                                }"
                              >
                                {{ element.date }}
                              </v-col>
                            </v-row>
                          </v-col>
                        </v-row>
                      </v-list-item>
                    </template>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-list-item-group>

            <v-pagination
              color="#E65100"
              class="customPagination py-0 my-0"
              v-model="page"
              :length="Math.ceil(list.length / perPage)"
            />
          </v-card>
        </v-col>
        <v-col cols="10" class="py-2 px-4">
          <v-row
            v-bind:style="{
              maxHeight: PanelMachineHeight,
            }"
            class="overflow-y-auto"
          >
            <v-col
              v-bind:style="[
                item.color !== '#1A237E'
                  ? {
                      backgroundColor: item.bk,
                      minWidth: '8.98vw',
                      maxWidth: '8.98vw',
                    }
                  : { minWidth: '8.98vw', maxWidth: '8.98vw' },
              ]"
              class="px-0"
              v-for="(item, i) in machine"
              :key="i"
            >
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
                      fontSize: '0.7em',
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
                      fontSize: '0.75em',
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
                      fontSize: '0.75em',
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
                  >
                    <v-list-item
                      v-for="element in item.list"
                      :key="element.id"
                      class="px-1 py-1"
                    >
                      <v-card
                        v-bind:style="{
                          width: '100%',
                          backgroundColor: 'white',
                          color: '#333333',
                          borderRadius: '0.5em',
                          fontFamily: 'Oswald, sans-serif',
                          fontSize: '0.9em',
                          margin: '0.2em',
                        }"
                      >
                        <v-row>
                          <v-col cols="2">
                            <v-icon
                              v-bind:style="{
                                display: 'block',
                                padding: '0.85em 0.2em',
                              }"
                              @click="detail(element.id, element.name)"
                              color="#333333"
                              size="12"
                            >
                              mdi-text-box
                            </v-icon>
                          </v-col>
                          <v-col cols="8">
                            <span
                              v-bind:style="{
                                fontSize: '0.7em',
                                height: '100%',
                                display: 'flex',
                                justifyContent: 'center',
                                alignItems: 'center',
                                textAlign: 'center',
                              }"
                            >
                              {{ element.name }}
                            </span>
                          </v-col>
                          <v-col cols="2" class="px-0">
                            <v-icon
                              v-bind:style="{
                                backgroundColor: '#FFFFFF',
                                display: 'block',
                                padding: '0.85em 0.2em',
                              }"
                              @click="jobDelete(element.idJob)"
                              color="#D40000"
                              size="12"
                            >
                              mdi-delete
                            </v-icon>
                          </v-col>
                        </v-row>

                        <v-row
                          class="py-0 ma-0"
                          v-bind:style="{ fontSize: '0.5em', height: '20px' }"
                        >
                          <v-col
                            cols="3"
                            class="pa-0"
                            v-bind:style="{
                              color: 'white',
                              backgroundColor: '#333333',
                              height: '20px',
                            }"
                          >
                            <span
                              v-bind:style="{
                                display: 'flex',
                                justifyContent: 'center',
                                alignItems: 'center',
                                textAlign: 'center',
                                margin: 0,
                                padding: 0,
                                height: '20px',
                              }"
                            >
                              {{ element.orderid }}
                            </span>
                          </v-col>
                          <v-col cols="9" class="ma-0 pb-0">
                            <v-row>
                              <v-col
                                cols="6"
                                class="pa-0"
                                v-bind:style="[
                                  element.color === '#FFE32A'
                                    ? {
                                        backgroundColor: element.color,
                                        color: '#38454C',
                                        minHeight: '20px',
                                      }
                                    : {
                                        backgroundColor: element.color,
                                        color: 'white',
                                        minHeight: '20px',
                                      },
                                ]"
                              >
                                <span
                                  v-bind:style="{
                                    display: 'flex',
                                    justifyContent: 'center',
                                    alignItems: 'center',
                                    textAlign: 'center',
                                    height: '20px',
                                  }"
                                >
                                  {{ element.equipment }}
                                </span>
                              </v-col>
                              <v-col
                                cols="4"
                                class="pa-0"
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
                              >
                                <span
                                  v-bind:style="{
                                    display: 'flex',
                                    justifyContent: 'center',
                                    alignItems: 'center',
                                    textAlign: 'center',
                                    height: '20px',
                                  }"
                                >
                                  {{ element.date }}
                                </span>
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
                                  <v-container
                                    fluid
                                    fill-height
                                    class="my-0 py-0"
                                  >
                                    <v-row
                                      align="center"
                                      justify="center"
                                      class="pr-3"
                                    >
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
                                    class="my-0 py-0 pl-0"
                                  >
                                    <v-row
                                      align="center"
                                      justify="center"
                                      class="mx-0 ml-0 pa-0"
                                    >
                                      <v-col cols="6" class="my-0 pa-0">
                                        <v-icon class="spin" size="11" dark>
                                          mdi-cog
                                        </v-icon>
                                      </v-col>
                                      <v-col cols="6" class="ma-0 pa-0">
                                        <v-icon
                                          v-bind:style="{ marginLeft: '.2em' }"
                                          class="spin-back mb-1"
                                          size="11"
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
                                  <v-container
                                    fluid
                                    fill-height
                                    class="my-0 py-0"
                                  >
                                    <v-row align="center" justify="center">
                                      <v-col cols="12" class="pr-8">
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
                                  <v-container
                                    fluid
                                    fill-height
                                    class="my-0 py-0"
                                  >
                                    <v-row align="center" justify="center">
                                      <v-col cols="12" class="pr-8">
                                        <v-icon color="white" size="15">
                                          mdi-check
                                        </v-icon>
                                      </v-col>
                                    </v-row>
                                  </v-container>
                                </v-col>
                              </template>
                            </v-row>
                          </v-col>
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
                    :key="element.id"
                    class="px-1 py-1"
                  >
                    <v-card
                      v-bind:style="{
                        width: '100%',
                        backgroundColor: 'white',
                        color: '#333333',
                        borderRadius: '0.5em',
                        fontFamily: 'Oswald, sans-serif',
                        fontSize: '0.9em',
                        margin: '0.2em',
                      }"
                    >
                      <v-row>
                        <v-col cols="2">
                          <v-icon
                            v-bind:style="{
                              display: 'block',
                              padding: '0.85em 0.2em',
                            }"
                            @click="detail(element.id, element.name)"
                            color="#333333"
                            size="12"
                          >
                            mdi-text-box
                          </v-icon>
                        </v-col>
                        <v-col cols="8">
                          <span
                            v-bind:style="{
                              fontSize: '0.7em',
                              height: '100%',
                              display: 'flex',
                              justifyContent: 'center',
                              alignItems: 'center',
                              textAlign: 'center',
                            }"
                          >
                            {{ element.name }}
                          </span>
                        </v-col>
                        <v-col cols="2" class="px-0">
                          <v-icon
                            v-bind:style="{
                              position: 'absolute',
                              display: 'block',
                              padding: '0.85em 0',
                            }"
                            color="#38454C"
                            size="12"
                          >
                            mdi-puzzle
                          </v-icon>
                        </v-col>
                      </v-row>

                      <v-row
                        class="py-0 ma-0"
                        v-bind:style="{ fontSize: '0.5em', height: '20px' }"
                      >
                        <v-col
                          cols="3"
                          class="pa-0"
                          v-bind:style="{
                            color: 'white',
                            backgroundColor: '#333333',
                            height: '20px',
                          }"
                        >
                          <span
                            v-bind:style="{
                              display: 'flex',
                              justifyContent: 'center',
                              alignItems: 'center',
                              textAlign: 'center',
                              margin: 0,
                              padding: 0,
                              height: '20px',
                            }"
                          >
                            {{ element.orderid }}
                          </span>
                        </v-col>
                        <v-col cols="9" class="ma-0 pb-0">
                          <v-row>
                            <v-col
                              cols="6"
                              class="pa-0"
                              v-bind:style="[
                                element.color === '#FFE32A'
                                  ? {
                                      backgroundColor: element.color,
                                      color: '#38454C',
                                      minHeight: '20px',
                                    }
                                  : {
                                      backgroundColor: element.color,
                                      color: 'white',
                                      minHeight: '20px',
                                    },
                              ]"
                            >
                              <span
                                v-bind:style="{
                                  display: 'flex',
                                  justifyContent: 'center',
                                  alignItems: 'center',
                                  textAlign: 'center',
                                  height: '20px',
                                }"
                              >
                                {{ element.equipment }}
                              </span>
                            </v-col>
                            <v-col
                              cols="4"
                              class="pa-0"
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
                            >
                              <span
                                v-bind:style="{
                                  display: 'flex',
                                  justifyContent: 'center',
                                  alignItems: 'center',
                                  textAlign: 'center',
                                  height: '20px',
                                }"
                              >
                                {{ element.date }}
                              </span>
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
                                <v-container
                                  fluid
                                  fill-height
                                  class="my-0 py-0"
                                >
                                  <v-row
                                    align="center"
                                    justify="center"
                                    class="pr-3"
                                  >
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
                                  class="my-0 py-0 pl-0"
                                >
                                  <v-row
                                    align="center"
                                    justify="center"
                                    class="mx-0 ml-0 pa-0"
                                  >
                                    <v-col cols="6" class="my-0 pa-0">
                                      <v-icon class="spin" size="11" dark>
                                        mdi-cog
                                      </v-icon>
                                    </v-col>
                                    <v-col cols="6" class="ma-0 pa-0">
                                      <v-icon
                                        v-bind:style="{ marginLeft: '.2em' }"
                                        class="spin-back mb-1"
                                        size="11"
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
                                <v-container
                                  fluid
                                  fill-height
                                  class="my-0 py-0"
                                >
                                  <v-row align="center" justify="center">
                                    <v-col cols="12" class="pr-8">
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
                                <v-container
                                  fluid
                                  fill-height
                                  class="my-0 py-0"
                                >
                                  <v-row align="center" justify="center">
                                    <v-col cols="12" class="pr-8">
                                      <v-icon color="white" size="15">
                                        mdi-check
                                      </v-icon>
                                    </v-col>
                                  </v-row>
                                </v-container>
                              </v-col>
                            </template>
                          </v-row>
                        </v-col>
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
      <v-card
        v-bind:style="{
          fontFamily: 'Oswald,sans-serif',
          backgroundColor: '#F0F0F0',
          position: 'absolute',
          width: '16.5vw',
          left: '.9vw',
          bottom: '1.7vh',
        }"
      >
        <v-card-text class="py-0 px-0 ">
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

          <v-row class="ma-0 pa-0">
            <v-col cols="12" class="px-1 py-0">
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
            <v-col cols="12" class="px-1 py-0">
              <v-select
                class="font-class-name my-1"
                @change="filterSearch()"
                v-model="filterValueFactory"
                :items="filterDataFactory"
                :disabled="disablefilter"
                label="Gyar"
                hide-details
                clearable
                multiple
                outlined
                dense
                chips
              />
            </v-col>
            <v-col cols="12" class="px-1 py-0">
              <v-select
                class="font-class-name my-1"
                @change="filterSearch()"
                v-model="filterValuePlace"
                :items="filterDataPlace"
                :disabled="disablefilter"
                label="Hely"
                hide-details
                clearable
                multiple
                outlined
                dense
                chips
              />
            </v-col>
            <v-col cols="12" class="px-1 py-0">
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
          </v-row>
        </v-card-text>
      </v-card>
    </v-container>

    <v-dialog v-model="modalDetail" width="97vw" persistent>
      <v-card>
        <v-btn
          icon
          dark
          class="ma-1"
          v-bind:style="[
            detailData.sapOrder !== null && detailData.sapOrder !== undefined
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
          @click="openModalHourWorks(detailData.sapOrder)"
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
                                v-bind:style="{
                                  fontSize: '1em',
                                  padding: 0,
                                  marginBottom: '.4em',
                                }"
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
                                v-bind:style="{
                                  fontSize: '1em',
                                  padding: 0,
                                  marginBottom: '.4em',
                                }"
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
              <v-col cols="12">
                <v-card class="pa-0 ma-0">
                  <v-row class="pt-2 ma-0">
                    <v-col cols="3" class="py-0 my-0">
                      <v-row class="ma-0 pa-0">
                        <v-col
                          cols="6"
                          class="ma-0 pa-0"
                          v-for="(item, i) in imageTMES"
                          :key="i"
                        >
                          <v-img
                            class="mx-1"
                            max-width="190"
                            @click="downloadImg(imageTMES, item.value)"
                            :src="'data:image/gif;base64,' + item.url"
                          />
                        </v-col>
                      </v-row>
                    </v-col>
                    <v-col cols="9">
                      <v-row>
                        <v-col
                          class="mx-0 px-0 pt-0"
                          v-for="(item, i) in detailData.detail"
                          :cols="orderDialogDetail(item.name)"
                          :key="i"
                        >
                          <template
                            v-if="item.name === 'Név' || item.name === 'Detail'"
                          >
                            <template v-if="item.name === 'Név'">
                              <h3
                                v-bind:style="{
                                  backgroundColor: '#4D4D4D',
                                  color: 'white',
                                  textAlign: 'center',
                                  padding: '0.5em 0',
                                }"
                              >
                                {{ item.value }}
                              </h3>
                            </template>
                            <template v-else>
                              <v-row class="mt-1 mx-1">
                                <v-col
                                  class="mx-0 px-0 pt-0"
                                  v-for="(itemDetail, i) in item.value"
                                  :cols="orderDialogDetail(itemDetail.name)"
                                  :key="i"
                                >
                                  <div class="mx-1">
                                    <template
                                      v-if="
                                        itemDetail.value !== '' &&
                                          itemDetail.value !== null &&
                                          itemDetail.value !== undefined
                                      "
                                    >
                                      <v-text-field
                                        v-bind:style="{
                                          fontSize: '1em',
                                          padding: 0,
                                        }"
                                        :label="itemDetail.name"
                                        :value="itemDetail.value"
                                        outlined
                                        hide-details
                                        readonly
                                        dense
                                        flat
                                      />
                                    </template>
                                    <template v-else>
                                      <v-text-field
                                        v-bind:style="{
                                          fontSize: '1em',
                                          padding: 0,
                                        }"
                                        :label="itemDetail.name"
                                        value=" "
                                        hide-details
                                        outlined
                                        readonly
                                        dense
                                      />
                                    </template>
                                  </div>
                                </v-col>
                              </v-row>
                            </template>
                          </template>
                          <template v-else-if="item.name !== 'image'">
                            <div class="mx-1">
                              <template
                                v-if="
                                  item.value !== '' &&
                                    item.value !== null &&
                                    item.value !== undefined
                                "
                              >
                                <v-text-field
                                  v-bind:style="{
                                    fontSize: '1em',
                                    padding: 0,
                                  }"
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
                                  v-bind:style="{
                                    fontSize: '1em',
                                    padding: 0,
                                  }"
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
                    </v-col>
                  </v-row>
                </v-card>
              </v-col>
            </v-row>
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
const jobUrl = "http://192.168.4.11/vaultbrowser/db/childWorkTMES.php";
const partsUrl = "http://192.168.4.11/vaultbrowser/db/partsData.php";
//const sapCreateUrl = "http://192.168.4.11/vaultbrowser/db/cOrderNotif.php";
const sapProp = "http://192.168.4.11/vaultbrowser/db/propertiesNotif.php";
const manageUrl = "http://192.168.4.79:20000/api/management/";
const filterUrl = "http://192.168.4.11/vaultbrowser/db/typeFilter.php";
const imageUrl = "http://192.168.4.11/vaultbrowser/db/imageUrl.php";
const urlDown = "http://192.168.4.11/vaultbrowser/db/imageDownload.php";
const testTableUrl = "http://192.168.4.11/vaultbrowser/db/testTable.php";
const headers = {
  "Content-Type": "application/json",
  Authorization:
    "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA",
};
import draggable from "vuedraggable";
export default {
  name: "Work",
  display: "Two Lists",
  order: 1,
  components: {
    draggable,
  },
  data() {
    return {
      selectedItem: "",
      PanelPartHeight: "58vh",
      PanelMachineHeight: "86vh",
      list: [],
      machine: [],
      listUsed: [],
      detailData: [],
      modalDetail: false,
      title: "",
      errorMessage: "",
      modalError: false,
      sapPropertiesModal: false,
      sapPropertiesnNumber: "",
      sapPropertiesPriority: "",
      sapPropertiesEndDate: "",
      sapPropertiesnWorkHour: 0,
      sapPropertiesnWorkMinutes: 0,
      time: new Date().toISOString().substr(11, 5),
      menu2: false,
      menu: false,
      date: new Date().toISOString().substr(0, 10),
      priorityList: ["Nagyon Magas", "Magas", "Normál", "Alacsony"],
      loadingDetail: "block",
      attrs: {},
      imageTMES: "",
      userState: "",
      page: 1,
      perPage: 14,
      priorityListFilter: [
        { name: "Nagyon Magas", value: "#FF00FF" },
        { name: "Magas", value: "#FF0000" },
        { name: "Normál", value: "#FFA500" },
        { name: "Alacsony", value: "#9ACD32" },
        { name: "Nincs", value: "#263238" },
      ],
      filterValuePriority: "",
      filterValueFactory: "",
      filterValuePlace: "",
      filterValueLastName: "",
      filterDataPriority: [],
      filterDataFactory: [],
      filterDataPlace: [],
      filterDataLastName: [],
      disablefilter: false,
      modalHourWorks: false,
      hourTestWorker: [],
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
    },
    userStatus() {
      this.userState = localStorage.user;
    },
    openModalHourWorks(value) {
      if (value !== null && value !== undefined) {
        this.modalHourWorks = true;
        this.dataModalHourWorks(value[9]);
        //console.log(value[0]);
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
    childWork() {
      axios.get(jobUrl).then((response) => {
        this.machine = response.data;
        //console.log(this.machine);
      });
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
            valuefactory: this.filterValueFactory,
            valueplace: this.filterValuePlace,
          })
        )
        .then((response) => {
          if (response.data !== null || response.data !== undefined) {
            this.filterDataPlace = response.data.deployPlace;
            this.filterDataFactory = response.data.deployFactory;
            this.filterDataLastName = response.data.lastName;
          }
        });
    },
    filterSearch() {
      this.listFilterPost();
      this.listFilterDisabled();
      axios
        .post(
          partsUrl,
          JSON.stringify({
            typeForm: "post",
            deployFactoryPost: this.filterValueFactory,
            deployPlacePost: this.filterValuePlace,
            priorityPost: this.filterValuePriority,
          })
        )
        .then((response) => {
          this.list = response.data;
          //console.log(this.list);
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
      this.imageTMES = "";
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
          if (
            this.detailData.detail !== null &&
            this.detailData.detail !== [] &&
            this.detailData.detail !== undefined
          ) {
            this.viewImage(this.detailData.detail);
          }
          // console.log(this.detailData);
        });
    },
    downloadImg(value, number) {
      var imgId = [];
      for (var i = 0; i < value.length; i++) {
        imgId.push(value[i].value);
      }
      //console.log(imgId);
      axios
        .post(urlDown, JSON.stringify({ image: imgId, number: number }))
        .then((resp) => {
          console.log(resp.data);
          for (var j = 0; j < resp.data.length; j++) {
            var a = document.createElement("a"); //Create <a>
            a.href = "data:application/document;base64," + resp.data[j].url;
            a.download = resp.data[j].name; //File name Here
            a.click();
          }
        });
    },
    viewImage(value) {
      var valueImage = [];
      if (value.length > 0) {
        for (var i = 0; i < value.length; i++) {
          if (value[i].name === "image") {
            valueImage.push(value[i].value1, value[i].value2);
          }
        }
      }
      axios
        .post(
          imageUrl,
          JSON.stringify({
            image: valueImage,
          })
        )
        .then((resp) => {
          this.imageTMES = resp.data;
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
          if (this.sapPropertiesPriorityNumber === 1) {
            this.sapPropertiesPriority = "Nagyon Magas";
          } else if (this.sapPropertiesPriorityNumber === 2) {
            this.sapPropertiesPriority = "Magas";
          } else if (this.sapPropertiesPriorityNumber === 3) {
            this.sapPropertiesPriority = "Normál";
          } else if (this.sapPropertiesPriorityNumber === 4) {
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

          //var jobID = response.data.terminalJob.id;
          //create Notification
          /*  if (notifNumberCreate !== undefined) {
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
          } */
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
    clonePart({ name, id, sapOrder, order, endDate }) {
      return {
        id: id,
        name: name,
        sapOrder: sapOrder,
        priority: order,
        endDate: endDate,
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
.v-skeleton-loader__image {
  height: 100%;
}
.customPagination {
  width: auto;
  margin-left: auto;
}
.customPagination .v-pagination__navigation {
  height: 24px !important;
  max-width: 24px !important;
}
.customPagination .v-pagination__item {
  height: 24px !important;
  max-width: 10px !important;
  font-size: 0.75rem !important;
  padding: 0 !important;
}
</style>
