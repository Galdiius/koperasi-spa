<template>
    <v-card
            class="mt-4 mx-auto"
            max-width="400"
            shaped
          >
            <v-sheet
              class="v-sheet--offset mx-auto"
              color="cyan"
              elevation="12"
              max-width="calc(100% - 32px)"
            >
              <v-sparkline
                :labels="labels"
                :value="value"
                color="white"
                line-width="2"
                padding="16"
              ></v-sparkline>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Penambahan anggota
              </div>
              <div class="subheading font-weight-light grey--text">
                Performa penambahan anggota
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon
                class="mr-2"
                small
              >
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Penambahan anggota baru 30 menit lalu</span>
            </v-card-text>
          </v-card>
</template>
<script>
export default {
    data(){
    return {
      labels: [
        'jan',
        'feb',
        'mar',
        'apr',
        'mei',
        'jun',
        'jul',
        'aug',
        'sep',
        'okt',
        'nov',
        'des'
      ],
      value: [
        0,
        1,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0
      ],
    }
  },
}
</script>
<style scoped>
.v-sheet--offset {
    top: -24px;
    position: relative;
  }
</style>