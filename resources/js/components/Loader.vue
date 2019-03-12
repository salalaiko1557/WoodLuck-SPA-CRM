
<template>
 <div class="text-xs-center">
    <v-dialog
      v-model="loader"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="primary"
        dark
      >
        <v-card-text>
          Будь ласка, зачекайте
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>




<script>
  export default {
    data () {
      return {
        loader: true
      }
    },

    watch: {
      dialog (val) {
        if (!val) return

        setTimeout(() => (this.loader = false), 99999)
      }
    }
  }
</script>
