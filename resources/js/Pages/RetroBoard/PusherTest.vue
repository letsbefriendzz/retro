<template>
    <div>
        this is the pusher test page
    </div>
</template>

<script>
import Pusher from 'pusher-js';

export default {
    name: "PusherTest",
    mounted() {
        // Enable pusher logging - don't include    this in production
        Pusher.logToConsole = true;

        const pusher = new Pusher('978e85c5d158cc9b310c', {
            cluster: 'us2'
        });

        const channel = pusher.subscribe('my-channel');
        channel.bind('mock-event', function(data) {
            console.log(JSON.stringify(data));
        });
        console.log('PusherTest.vue:mounted')
    }
}
</script>

<style scoped>

</style>
