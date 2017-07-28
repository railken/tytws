<template>
    <div class='container-content fill'>
        <div class='paper content-spacing'>
            <h1>Dashboard</h1>
        </div>

        <div class='paper content-spacing'>
            <select class='form-control'>
                <option>Today</option>
                <option>Yesterday</option>
                <option>Current Week</option>
                <option>Previous Week</option>
                <option>Current Month</option>
                <option>Previous Month</option> 
            </select>
        </div>

        <div class='paper content-spacing'>
            Sum of total hours
        </div>

        <div class='paper content-spacing'>
            chart1:  hours x days 
        </div>

        <div class='paper content-spacing'>
            chart2: how many hours x hour of day 
        </div>

    </div>
</template>

<script>
    import { container } from '../services/container';

    export default {

        data: function() {
            return { 
                user: container.get('user'),
            }
        },
        mounted() {
        }
    }

</script>

<style>

</style>