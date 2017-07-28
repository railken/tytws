<template>
    <main v-if='user' class='full-height'>
        <component-header></component-header>
            
        <div class='fluid main'>
            <component-team-list></component-team-list>
            <div class='container-content fill'>
                <router-view></router-view>
            </div>
        </div>
    </main>
</template>

<script>
    import { container } from '../services/container';
    export default {

        data: function() {
            return { 
                user: null
            }
        },
        mounted() {
            var self = this;
            container.get('services.oauth').loadUser({
                success: function(response) {
                    container.set('user', response.data.resource);
                    self.user = container.get('user');
                },
                error: function() {
                    container.get('router').push({ name: 'login'});
                }
            });
           
        }
    }

    require('./layout.css');
    require('spinkit/css/spinners/1-rotating-plane.css');
</script>


<style>

</style>