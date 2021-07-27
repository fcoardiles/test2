<template>
  <v-row class="pt-3">
    <v-col>
      <v-data-table
        fixed-header
        height="80vh"
        :headers="headers"
        :items="dataFilter"
        center
        :footer-props="{
          'items-per-page-options': [itemPerPage],
        }"
      >
        <template v-slot:[`header.part`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="10" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="2" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12" :color="dataPart ? 'primary' : ''">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-text-field
                    v-model="dataPart"
                    label="Enter the search term"
                    class="pa-4"
                    type="text"
                    clearable
                    outlined
                    hide-details
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.number`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="9" class="pa-0">
              <span class="text--white ma-0 pa-0">{{ header.text }}</span>
            </v-col>
            <v-col cols="3" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-1" icon v-bind="attrs" v-on="on">
                    <v-icon size="12" :color="dataNumber ? 'primary' : ''">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-text-field
                    v-model="dataNumber"
                    label="Enter the search term"
                    class="pa-4"
                    type="text"
                    clearable
                    outlined
                    hide-details
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.numberSap`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="9" class="pa-0">
              <span class="text--white text-center">{{ header.text }}</span>
            </v-col>
            <v-col cols="3" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-1" icon v-bind="attrs" v-on="on">
                    <v-icon size="12" :color="dataSapNumber ? 'primary' : ''">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-text-field
                    v-model="dataSapNumber"
                    label="Enter the search term"
                    class="pa-4"
                    type="number"
                    clearable
                    outlined
                    hide-details
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.txtpart`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="9" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="3" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12" :color="dataNamePart ? 'primary' : ''">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-text-field
                    v-model="dataNamePart"
                    label="Enter the search term"
                    class="pa-4"
                    clearable
                    outlined
                    hide-details
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.machine`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="9" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="3" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-select
                    v-model="dMachineL"
                    @change="filterSearchMachine()"
                    :items="list"
                    label="Jelentés Típusa"
                    hide-details
                    multiple
                    outlined
                    dense
                    chips
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.type`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="8" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="4" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-select
                    v-model="dTypeL"
                    class="pa-2"
                    @change="filterSearchType()"
                    :items="listType"
                    label="Jelentés Típusa"
                    hide-details
                    multiple
                    outlined
                    chips
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.date`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="11" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}
              </span>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.startOfMalfunction`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="11" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}
              </span>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.priority`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="8" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="4" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-select
                    v-model="dPriorityL"
                    class="pa-2"
                    @change="filterSearchPriority()"
                    :items="listPriority"
                    label="Gyár"
                    hide-details
                    multiple
                    outlined
                    chips
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>

        <template v-slot:[`header.propPriority`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="8" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="4" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-select
                    v-model="dPropPriorityL"
                    class="pa-2"
                    @change="filterSearchPropPriority()"
                    :items="listPropPriority"
                    label="Gyár"
                    hide-details
                    multiple
                    outlined
                    chips
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>

        <template v-slot:[`header.jobstatus`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="11" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}
              </span>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.plannedWorkTimeMin`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="11" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}
              </span>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.endDate`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="11" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}
              </span>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.deployFactory`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="8" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="4" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-select
                    v-model="dFactoryL"
                    class="pa-2"
                    @change="filterSearchFactory()"
                    :items="listFactory"
                    label="Gyár"
                    hide-details
                    multiple
                    outlined
                    chips
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.deployPlace`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="8" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="4" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-select
                    v-model="dPlaceL"
                    class="pa-2"
                    @change="filterSearchPlace()"
                    :items="listPlace"
                    label="Gyár"
                    hide-details
                    multiple
                    outlined
                    chips
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>
        <template v-slot:[`header.plannerGroupTitle`]="{ header }">
          <v-row class="pt-3 pl-3">
            <v-col cols="8" class="pa-0">
              <span
                v-bind:style="{
                  display: 'flex',
                  justifyContent: 'center',
                  alignItems: 'center',
                  textAlign: 'center',
                  margin: 0,
                  padding: 0,
                  height: '50px',
                }"
                >{{ header.text }}</span
              >
            </v-col>
            <v-col cols="4" class="pa-0">
              <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-2" icon v-bind="attrs" v-on="on">
                    <v-icon size="12">
                      mdi-filter
                    </v-icon>
                  </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                  <v-select
                    v-model="dPlannerL"
                    class="pa-2"
                    @change="filterSearchPlanner()"
                    :items="listPlanner"
                    label="Gyár"
                    hide-details
                    multiple
                    outlined
                    chips
                  />
                </div>
              </v-menu>
            </v-col>
          </v-row>
        </template>

        <template v-slot:[`header.actions`]>
          <template v-if="userState === 'admin'">
            <v-icon class="mb-1" small color="white">mdi-cog</v-icon>
          </template>
        </template>
        <!-------------------------------   Data Column    ------------------------------->
        <template v-slot:[`item.part`]="{ item }">
          <div>
            <v-row class="ma-0 pa-0">
              <v-col cols="11" class="ma-0 px-0 pt-2">
                {{ item.part }}
              </v-col>
              <v-col cols="1" class="ma-0 pa-0">
                <template
                  v-if="
                    item.childs !== null &&
                      item.childs !== undefined &&
                      item.childs.length > 0
                  "
                >
                  <template v-if="panelChild === item.number">
                    <v-btn icon @click="childsPanelOff()">
                      <v-icon small>mdi-minus</v-icon>
                    </v-btn>
                  </template>
                  <template v-else>
                    <v-btn icon @click="childsPanel(item.number)">
                      <v-icon small>mdi-plus</v-icon>
                    </v-btn>
                  </template>
                </template>
              </v-col>
            </v-row>
          </div>
          <template v-if="panelChild === item.number">
            <div v-for="child in item.childs" :key="child.number" class="my-2">
              <v-icon small>mdi-subdirectory-arrow-right</v-icon>
              {{ child.part }}
            </div>
          </template>
        </template>
        <template v-slot:[`item.type`]="{ item }">
          <!--------------->
          <div class="py-2">{{ item.type }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="child in item.childs" :key="child.number" class="my-2">
              {{ child.type }}
            </div>
          </template>
          <!--------------->
        </template>
        <template v-slot:[`item.number`]="{ item }">
          <div class="py-2">{{ item.number }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="child in item.childs" :key="child.number" class="my-2">
              {{ child.number }}
            </div>
          </template>
        </template>
        <template v-slot:[`item.numberSap`]="{ item }">
          <div class="py-2">{{ item.numberSap }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="child in item.childs" :key="child.number" class="my-2">
              {{ child.numberSap }}
            </div>
          </template>
        </template>
        <template v-slot:[`item.txtpart`]="{ item }">
          <div class="py-2">{{ item.txtpart }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="child in item.childs" :key="child.number" class="my-2">
              {{ child.txtpart }}
            </div>
          </template>
        </template>
        <template v-slot:[`item.date`]="{ item }">
          <div class="py-2">{{ item.date }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="child in item.childs" :key="child.number" class="my-2">
              {{ child.date }}
            </div>
          </template>
        </template>
        <template v-slot:[`item.startOfMalfunction`]="{ item }">
          <div class="py-2">{{ item.startOfMalfunction }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="(child, i) in item.childs" :key="i" class="my-2">
              {{ child.startOfMalfunction }}
            </div>
          </template>
        </template>
        <template v-slot:[`item.priority`]="{ item }">
          <template v-if="item.priority === 1">
            <v-icon :color="priorityName(item.priority)">
              mdi-signal-cellular-3
            </v-icon>
          </template>
          <template v-else-if="item.priority === 2">
            <v-icon :color="priorityName(item.priority)">
              mdi-signal-cellular-2
            </v-icon>
          </template>
          <template v-else-if="item.priority === 3">
            <v-icon :color="priorityName(item.priority)">
              mdi-signal-cellular-1
            </v-icon>
          </template>
          <template v-else-if="item.priority === 4">
            <v-icon :color="priorityName(item.priority)">
              mdi-signal-cellular-outline
            </v-icon>
          </template>

          <template v-if="panelChild === item.number">
            <div v-for="(child, i) in item.childs" :key="i" class="my-2">
              <template v-if="child.priority === 1">
                <v-icon :color="priorityName(child.priority)">
                  mdi-signal-cellular-3
                </v-icon>
              </template>
              <template v-else-if="child.priority === 2">
                <v-icon :color="priorityName(child.priority)">
                  mdi-signal-cellular-2
                </v-icon>
              </template>
              <template v-else-if="child.priority === 3">
                <v-icon :color="priorityName(child.priority)">
                  mdi-signal-cellular-1
                </v-icon>
              </template>
              <template v-else-if="child.priority === 4">
                <v-icon :color="priorityName(child.priority)">
                  mdi-signal-cellular-outline
                </v-icon>
              </template>
            </div>
          </template>
        </template>
        <template v-slot:[`item.propPriority`]="{ item }">
          <div class="py-2">
            <template v-if="item.propPriority === 1">
              <v-icon :color="priorityName(item.propPriority)">
                mdi-signal-cellular-3
              </v-icon>
            </template>
            <template v-else-if="item.propPriority === 2">
              <v-icon :color="priorityName(item.propPriority)">
                mdi-signal-cellular-2
              </v-icon>
            </template>
            <template v-else-if="item.propPriority === 3">
              <v-icon :color="priorityName(item.propPriority)">
                mdi-signal-cellular-1
              </v-icon>
            </template>
            <template v-else-if="item.propPriority === 4">
              <v-icon :color="priorityName(item.propPriority)">
                mdi-signal-cellular-outline
              </v-icon>
            </template>
          </div>
          <template v-if="panelChild === item.number">
            <div
              v-for="child in item.childs"
              :key="child.propPriority"
              class="my-2"
            >
              <template v-if="child.propPriority === 1">
                <v-icon :color="priorityName(child.propPriority)">
                  mdi-signal-cellular-3
                </v-icon>
              </template>
              <template v-else-if="child.propPriority === 2">
                <v-icon :color="priorityName(child.propPriority)">
                  mdi-signal-cellular-2
                </v-icon>
              </template>
              <template v-else-if="child.propPriority === 3">
                <v-icon :color="priorityName(child.propPriority)">
                  mdi-signal-cellular-1
                </v-icon>
              </template>
              <template v-else-if="child.propPriority === 4">
                <v-icon :color="priorityName(child.propPriority)">
                  mdi-signal-cellular-outline
                </v-icon>
              </template>
            </div>
          </template>
        </template>

        <template v-slot:[`item.jobstatus`]="{ item }">
          <div class="py-2">{{ jobStatusName(item.childs) }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="(child, i) in item.childs" :key="i" class="my-2">
              {{ jobStatusChild(child.jobstatus) }}
            </div>
          </template>
        </template>

        <template v-slot:[`item.plannedWorkTimeMin`]="{ item }">
          <div class="py-2">{{ item.plannedWorkTimeMin }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="(child, i) in item.childs" :key="i" class="my-2">
              {{ child.plannedWorkTimeMin }}
            </div>
          </template>
        </template>

        <template v-slot:[`item.endDate`]="{ item }">
          <div class="py-2">{{ item.endDate }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="(child, i) in item.childs" :key="i" class="my-2">
              {{ child.endDate }}
            </div>
          </template>
        </template>

        <template v-slot:[`item.deployFactory`]="{ item }">
          <div class="py-2">{{ item.deployFactory }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="(child, i) in item.childs" :key="i" class="my-2">
              {{ child.deployFactory }}
            </div>
          </template>
        </template>

        <template v-slot:[`item.deployPlace`]="{ item }">
          <div class="py-2">{{ item.deployPlace }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="(child, i) in item.childs" :key="i" class="my-2">
              {{ child.deployPlace }}
            </div>
          </template>
        </template>

        <template v-slot:[`item.plannerGroupTitle`]="{ item }">
          <div class="py-2">{{ item.plannerGroupTitle }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="(child, i) in item.childs" :key="i" class="my-2">
              {{ child.plannerGroupTitle }}
            </div>
          </template>
        </template>

        <template v-slot:[`item.machine`]="{ item }">
          <div class="py-2">{{ item.machine }}</div>
          <template v-if="panelChild === item.number">
            <div v-for="child in item.childs" :key="child.number" class="my-2">
              {{ child.machine }}
            </div>
          </template>
        </template>
        <template v-slot:[`item.actions`]="{ item }">
          <template v-if="userState === 'admin'">
            <div class="py-2">
              <template v-if="item.job > 0">
                <v-icon
                  @click="deleteItem(item.job)"
                  color="red accent-4"
                  small
                  icon
                >
                  mdi-trash-can
                </v-icon>
              </template>
            </div>
            <template v-if="panelChild === item.number">
              <div
                v-for="child in item.childs"
                :key="child.number"
                class="my-2"
              >
                <template v-if="child.job > 0">
                  <v-icon
                    @click="deleteItem(child.job)"
                    color="red accent-4"
                    small
                    icon
                  >
                    mdi-trash-can
                  </v-icon>
                </template>
                <template v-else>
                  <v-icon color="white" small icon>
                    mdi-check
                  </v-icon>
                </template>
              </div>
            </template>
          </template>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>
<script>
const urlData = "http://192.168.4.11/vaultbrowser/db/tableTMES.php";
const urlList = "http://192.168.4.11/vaultbrowser/db/filterTMES.php";
const manageUrl = "http://192.168.4.79:20000/api/management/";
const headers = {
  "Content-Type": "application/json",
  Authorization:
    "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA",
};
import axios from "axios";
export default {
  name: "TableTMES",
  data() {
    return {
      itemPerPage: 16,
      headers: [
        {
          text: "Alkatrész",
          value: "part",
          align: "start",
          width: "280",
          class: "orange darken-4",
        },
        {
          text: "Jelentés Típusa",
          value: "type",
          align: "center",
          width: "80",
          class: "orange darken-4",
        },
        {
          text: "Jelentés Száma",
          value: "number",
          align: "center",
          width: "100",
          class: "orange darken-4",
        },
        {
          text: "SAP Rendelés",
          value: "numberSap",
          align: "center",
          width: "100",
          class: "orange darken-4",
        },
        {
          text: "Berendezés Száma",
          value: "txtpart",
          align: "center",
          width: "150",
          class: "orange darken-4",
        },
        {
          text: "Befejezési Határidő",
          value: "date",
          align: "center",
          width: "110",
          class: "orange darken-4",
        },
        {
          text: "Igénnylés Dátuma",
          value: "startOfMalfunction",
          align: "center",
          width: "110",
          class: "orange darken-4",
        },
        {
          text: "Külső Prioritás",
          value: "priority",
          align: "center",
          width: "80",
          class: "orange darken-4",
        },
        {
          text: "Belső Prioritás",
          value: "propPriority",
          align: "center",
          width: "80",
          class: "orange darken-4",
        },
        {
          text: "Státusz",
          value: "jobstatus",
          align: "center",
          width: "50",
          class: "orange darken-4",
        },
        {
          text: "Munkaóra",
          value: "plannedWorkTimeMin",
          align: "center",
          class: "orange darken-4",
        },
        {
          text: "Átadási Határidő",
          value: "endDate",
          align: "center",
          width: "110",
          class: "orange darken-4",
        },
        {
          text: "Gyár",
          value: "deployFactory",
          align: "center",
          width: "100",
          class: "orange darken-4",
        },
        {
          text: "Hely",
          value: "deployPlace",
          align: "center",
          width: "80",
          class: "orange darken-4",
        },
        {
          text: "Szerszámtervező",
          value: "plannerGroupTitle",
          align: "center",
          class: "orange darken-4",
        },
        {
          text: "Gép",
          value: "machine",
          align: "center",
          width: "160",
          class: "orange darken-4",
        },
        {
          text: "MŰVELET",
          value: "actions",
          width: "20",
          sortable: false,
          class: "orange darken-4",
        },
      ],
      data: [],
      dataPart: "",
      dataNumber: "",
      dataSapNumber: "",
      dataNamePart: "",
      list: [],
      listType: [],
      listFactory: [],
      listPlace: [],
      listPlanner: [],
      listPriority: [],
      listPropPriority: [],
      dMachineL: [],
      dTypeL: [],
      dFactoryL: [],
      dPlaceL: [],
      dPlannerL: [],
      dPriorityL: [],
      dPropPriorityL: [],
      panelChild: "",
      userState: "",
    };
  },
  computed: {
    dataFilter() {
      var conditions = [];

      if (this.dataPart) {
        conditions.push(this.filterDataPart);
      }
      if (this.dataNamePart) {
        conditions.push(this.filterDataNamePart);
      }
      if (this.dataNumber) {
        conditions.push(this.filterDataNumber);
      }
      if (this.dataSapNumber) {
        conditions.push(this.filterDataSapNumber);
      }
      conditions.push(this.filterSearchMachine);
      conditions.push(this.filterSearchType);
      conditions.push(this.filterSearchFactory);
      conditions.push(this.filterSearchPlace);
      conditions.push(this.filterSearchPlanner);
      conditions.push(this.filterSearchPropPriority);
      conditions.push(this.filterSearchPriority);

      if (conditions.length > 0) {
        return this.data.filter((data) => {
          return conditions.every((condition) => {
            return condition(data);
          });
        });
      }
      return this.data;
    },
  },
  mounted() {
    this.update();
    this.listdefault();
    setInterval(this.update, 5000);
  },
  methods: {
    update() {
      this.dataView();
      this.listValue();
      this.userStatus();
    },
    userStatus() {
      this.userState = localStorage.user;
    },
    dataView() {
      axios.get(urlData).then((resp) => {
        this.data = resp.data;
        //console.log(this.data);
      });
    },
    listValue() {
      axios.get(urlList).then((resp) => {
        this.list = resp.data.machine;
        this.listType = resp.data.type;
        this.listFactory = resp.data.deployFactory;
        this.listPlace = resp.data.deployPlace;
        this.listPlanner = resp.data.plannerGroupTitle;
        this.listPriority = resp.data.priority;
        this.listPropPriority = resp.data.propPriority;
      });
    },
    listdefault() {
      axios.get(urlList).then((resp) => {
        this.dMachineL = resp.data.machine;
        this.dTypeL = resp.data.type;
        this.dFactoryL = resp.data.deployFactory;
        this.dPlaceL = resp.data.deployPlace;
        this.dPlannerL = resp.data.plannerGroupTitle;
        this.dPriorityL = resp.data.priority;
        this.dPropPriorityL = resp.data.propPriority;
      });
    },
    childsPanel(value) {
      this.panelChild = value;
    },
    childsPanelOff() {
      this.panelChild = "";
    },
    filterSearchMachine(item) {
      if (item !== undefined && item !== null) {
        if (this.dMachineL.length > 0) {
          for (var i = 0; i < this.dMachineL.length; i++) {
            //   if (item.machine.indexOf(this.dMachineL[i]) >= 0) {
            if (item.machine === this.dMachineL[i]) {
              return true;
            }
          }
        }
      }
    },
    filterSearchType(item) {
      if (item !== undefined && item !== null) {
        if (this.dTypeL.length > 0) {
          for (var i = 0; i < this.dTypeL.length; i++) {
            if (item.type === this.dTypeL[i]) {
              return true;
            }
          }
        }
      }
    },
    filterSearchFactory(item) {
      if (item !== undefined && item !== null) {
        if (this.dFactoryL.length > 0) {
          for (var i = 0; i < this.dFactoryL.length; i++) {
            if (item.deployFactory === this.dFactoryL[i]) {
              return true;
            }
          }
        }
      }
    },
    filterSearchPlace(item) {
      if (item !== undefined && item !== null) {
        if (this.dPlaceL.length > 0) {
          for (var i = 0; i < this.dPlaceL.length; i++) {
            if (item.deployPlace === this.dPlaceL[i]) {
              return true;
            }
          }
        }
      }
    },
    filterSearchPlanner(item) {
      if (item !== undefined && item !== null) {
        if (this.dPlannerL.length > 0) {
          for (var i = 0; i < this.dPlannerL.length; i++) {
            if (item.plannerGroupTitle === this.dPlannerL[i]) {
              return true;
            }
          }
        }
      }
    },

    filterSearchPropPriority(item) {
      if (item !== undefined && item !== null) {
        if (this.dPropPriorityL.length > 0) {
          for (var i = 0; i < this.dPropPriorityL.length; i++) {
            if (item.propPriority === this.dPropPriorityL[i]) {
              return true;
            }
          }
        }
      }
    },

    filterSearchPriority(item) {
      if (item !== undefined && item !== null) {
        if (this.dPriorityL.length > 0) {
          for (var i = 0; i < this.dPriorityL.length; i++) {
            if (item.priority === this.dPriorityL[i]) {
              return true;
            }
          }
        }
      }
    },

    filterDataPart(item) {
      return item.part.toLowerCase().includes(this.dataPart.toLowerCase());
    },
    filterDataNamePart(item) {
      return item.txtpart
        .toLowerCase()
        .includes(this.dataNamePart.toLowerCase());
    },
    filterDataNumber(item) {
      return item.number.toString().includes(this.dataNumber);
    },
    filterDataSapNumber(item) {
      return item.numberSap.toString().includes(this.dataSapNumber);
    },

    priorityName(value) {
      if (value !== null) {
        if (value === 1) {
          return "#D50000";
        } else if (value === 2) {
          return "#FE4C04";
        } else if (value === 3) {
          return "#FFE32A";
        } else if (value === 4) {
          return "#1B5E20";
        } else if (value === "") {
          return "#263238";
        }
      } else {
        return "";
      }
    },
    jobStatusName(value) {
      if (value.length > 0) {
        var jobstatusNum = 0;
        for (var a = 0; a < value.length; a++) {
          if (value[a].jobstatus === 2) {
            jobstatusNum += 1;
          }
        }
        //console.log(jobstatusNum);
        var jobstatusValue = (jobstatusNum / value.length) * 100 + "%";
        return jobstatusValue;
      } else {
        return "";
      }
    },
    jobStatusChild(value) {
      if (value === 2) {
        return "100%";
      } else {
        return "0%";
      }
    },

    deleteItem(value) {
      const idDelete = manageUrl + "Job/" + value;
      confirm("Biztos hogy törölni akarja az alkatrészet?") &&
        axios.delete(idDelete, { headers }).then((response) => {
          console.log(response.data);
          console.clear();
          this.update();
          this.listdefault();
        });
    },
  },
};
</script>
<style>
.v-data-table-header th span {
  color: white;
  font-size: 1em;
  text-align: center;
}
@media only screen and (max-width: 400px) {
  .v-data-table-header {
    visibility: hidden;
    position: absolute;
  }
}
.v-data-table-header__icon {
  position: absolute;
  color: transparent !important;
}
.v-btn::before {
  background-color: transparent;
}
</style>
