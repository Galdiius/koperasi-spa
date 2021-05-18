<template>
    <v-app>
        <v-app-bar app color="" v-show="this.$route.name != 'login'">
            <v-app-bar-nav-icon @click.stop="sidebarMenu = !sidebarMenu"></v-app-bar-nav-icon>
            <v-spacer></v-spacer>
            <v-btn @click="toggleTheme" color="primary" class="mr-2">
                <v-icon color="white">{{buttonText()}}</v-icon>
            </v-btn>
        </v-app-bar>
        
        <NavigationDrawer :sidebarMenu="sidebarMenu"/>

        <v-content>
            <v-container fluid>
                <v-row class="fill-height">
                    <v-col>
                        <transition name="fade">
                            <router-view></router-view>
                        </transition>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
        <v-footer fixed height="20px" v-show="this.$route.name != 'login'">
        </v-footer>
    </v-app>
</template>
<script>
import NavigationDrawer from './layouts/NavigationDrawer'
export default {
    data : () => ({
        sidebarMenu: true,
        
    }),
    components : {
        NavigationDrawer
    },
    methods: {
        toggleTheme() {
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;      
        },
        buttonText() {
            return !this.$vuetify.theme.dark ? 'mdi-weather-night' : 'mdi-white-balance-sunny'
        },
    }
}
</script>
<style>
html{
    overflow: auto;
}
.app-drawer{
    box-shadow: 0px 10px 10px 10px black !important;
}
.v-list__group__header__prepend-icon .v-icon {
    color: white !important;
}
.v-list-item__icon v-list-group__header__prepend-icon i{
    color: white;
}
</style>