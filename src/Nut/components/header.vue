<template>
   
    <header class=' fluid fluid-vcenter'>
        <div class='container fluid fluid-vcenter '>
            <div class='header-content fluid fluid-vcenter'>
                <router-link to="/">
                    <i class='fa fa-home'></i>Track your timey wimey stuff
                </router-link>
                <div class='fill'>

                </div>
                <div class='header-sync-container'>

                    <!--<i class="fa fa-refresh rotate-1" aria-hidden="true"></i>
                    <span class='text-sm'>SYNCING</span>-->

                    <!--<i class="fa fa-refresh" aria-hidden="true"></i>
                    <span class='text-sm'>IN SYNC</span>-->
                </div>
                <div>
                    &nbsp;&nbsp;
                </div>
                <div>
                    <img v-bind:src='user.avatar' width='25' height='25' id='user-avatar'>
                </div>
                <div>
                    &nbsp;&nbsp;
                </div>
                <div class='fluid fluid-stretch dropdown'>
                    <div class='fluid fluid-vcenter fill' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="user-action">
                 
                        <i class='fa fa-caret-down'></i>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-team-actions">

                        <a href="javascript:;" class="dropdown-item">Signed in as {{ user.username }}</a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:;" class="dropdown-item">Settings</a>
                        <a href="javascript:;" class="dropdown-item" v-on:click="logout()">Sign out</a>
                    </div>
                </div>
            </div>
        </div>

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
        border-bottom: solid 1px #3d3d47;
        box-shadow: 0 1px 2px rgba(0,0,0,0.15);   
        z-index: 3;
        position: relative;
        position: fixed;
        width: 100%;
        top: 0;
        height: 51px;
        left: 0;
    }

    .header-content {
        width: 100%;
        padding: 0 25px;
    }

    #user-action {
        opacity: 0.7;
    }

    #user-action:hover {
        opacity: 1.0;
    }
    
    #user-avatar {
        border-radius: 100%;
        border:1px solid #3a3a43;
    }
</style>