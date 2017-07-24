<template>
   
    <header class='fluid'>

        <div>
            Track your timey wimey stuff
        </div>
        <div class='fill'>

        </div>
        <div class='header-sync-container'>

            <!--<i class="fa fa-refresh rotate-1" aria-hidden="true"></i>
            <span class='text-sm'>SYNCING</span>-->

            <i class="fa fa-refresh" aria-hidden="true"></i>
            <span class='text-sm'>IN SYNC</span>
        </div>
        <div>
            &nbsp;&nbsp;
        </div>
        <div class='header-container-user'>
            {{ user.username }}
        </div>
        <div>
            &nbsp;&nbsp;
        </div>
        <span v-on:click="logout()"><i class='fa fa-sign-out'></i></span>

    </header>
        
</template>

<script>
    import { container } from '../services/container';
    export default {

        data: function() {
            return { 
                user: container.get('user'),
                logout: function() {

                    container.get('services.oauth').logout();

                    container.get('router').push({ name: 'login'});
                }
                
            }
        },
        mounted() {
        }
    }
</script>

<style>
    
    header {
        background: #505061;
        color: white;
        padding: 15px;
        border-bottom: solid 1px #3d3d47;
        box-shadow: 0 1px 2px rgba(0,0,0,0.15);   
        z-index: 3;
        position: relative;
        position: fixed;
        width: 100%;
        top: 0;
    }
</style>