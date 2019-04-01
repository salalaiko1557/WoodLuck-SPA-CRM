<template>
  <div>
    <v-btn
    outline
    small
    fab
    color="teal"
    @click.stop="drawer = !drawer">
        <v-icon>list</v-icon>
    </v-btn>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="mini"
      absolute
      dark
      temporary
    >
      <v-list class="pa-1">
        <v-list-tile v-if="mini" @click.stop="mini = !mini">
          <v-list-tile-action>
            <v-icon>chevron_right</v-icon>
          </v-list-tile-action>
        </v-list-tile>

        <v-list-tile avatar tag="div">
          <v-list-tile-avatar>
            <img src="https://picsum.photos/100/100?random">
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title>{{username.logged_user}}</v-list-tile-title>
          </v-list-tile-content>

          <v-list-tile-action>
            <v-btn icon @click.stop="mini = !mini">
              <v-icon>chevron_left</v-icon>
            </v-btn>
          </v-list-tile-action>
        </v-list-tile>
      </v-list>

      <v-list class="pt-0" dense>
        <v-divider light></v-divider>

        <v-list-tile
          v-for="item in menu"
          :key="item.id"
          @click="$router.push({path: item.slug})"
        >
          <v-list-tile-action>
            <v-icon> arrow_forward_ios </v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>{{ item.name }}</v-list-tile-title>
          </v-list-tile-content>

        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        drawer: null,
        items: [
          { title: 'Home', icon: 'dashboard', link: '/home' },
          { title: 'About', icon: 'question_answer', link: '/mystery' }
        ],
        mini: false,
        right: null
      }
    },
    props:['username', 'menu'],
  }
</script>
