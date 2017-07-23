<template>
    <div v-if='user'>
        Welcome back
        {{ user.username }}
        <team-list></team-list>

        <button class='btn btn-primary' v-on:click="logout()">Logout</button>
    </div>
</template>

<script>
    import { container } from '../services/container';
    export default {

        data: function() {
            return { 
                user: null,
                logout: function() {

                    container.get('services.oauth').logout();
                    window.location.href = "/login";
                }
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
                    window.location.href = "/login";
                }
            });
           
        }
    }
</script>
