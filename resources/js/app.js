require('./bootstrap');

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

window.Echo.channel('requisitions')
    .listen('.requisition.created', (e) => {
        console.log('New Requisition:', e);

        // Example UI notification
        alert('New Requisition Created!');
    });

