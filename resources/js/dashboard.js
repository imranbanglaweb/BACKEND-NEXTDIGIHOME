import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY || process.env.MIX_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1',
    forceTLS: false,
    encrypted: true,
    disableStats: true,
});

function updateDashboardCards(data) {
    $('#cardTotal').text(data.total);
    $('#cardPending').text(data.pending);
    $('#cardApproved').text(data.approved);
    $('#cardRejected').text(data.rejected);
    $('#cardCompleted').text(data.completed);
}

function prependTimeline(item) {
    let html = `
        <div class="mb-3">
            <div class="small text-muted">${new Date(item.travel_date).toLocaleString()} by ${item.requested_by_name}</div>
            <div class="fw-bold">${item.status_text}</div>
        </div>`;
    $('#timelineContainer').prepend(html);
}

function addLatestRequisitionRow(item) {
    let row = `
    <tr>
        <td>${item.id}</td>
        <td>${item.requested_by_name}</td>
        <td>${(new Date(item.travel_date)).toLocaleDateString()}</td>
        <td>
            <span class="badge ${item.status==3 ? 'bg-success' : (item.status==4 ? 'bg-danger' : 'bg-warning')}">
                ${item.status_text}
            </span>
        </td>
    </tr>`;
    $('#latestTableBody').prepend(row);
}

// Listen to events
window.Echo.channel('dashboard')
    .listen('RequisitionCreated', (e) => {
        prependTimeline(e);
        addLatestRequisitionRow(e);
        toastr.info('New requisition created');
        if (typeof fetchNotifications === 'function') {
            fetchNotifications();
        }
    })
    .listen('RequisitionStatusUpdated', (e) => {
        prependTimeline(e);
        toastr.info('Requisition status updated');
    });

// Listen for RequisitionCreated event on the dashboard channel
window.Echo.channel('dashboard')
    .listen('RequisitionCreated', (e) => {
        if (window.Swal) {
            Swal.fire({
                icon: 'info',
                title: 'New Requisition Created',
                text: `By: ${e.requested_by_name}\nDate: ${e.travel_date}`,
                timer: 4000,
                showConfirmButton: false
            });
        } else {
            alert('New Requisition Created by ' + e.requested_by_name);
        }
        if (typeof fetchNotifications === 'function') {
            fetchNotifications();
        }
    });

// Service Worker Registration for Push Notifications
if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', async () => {
        try {
            // Register service worker from public folder
            const registration = await navigator.serviceWorker.register('/service-worker.js');
            console.log('Service Worker registered:', registration.scope);

            // Request notification permission
            if (Notification.permission !== 'granted') {
                const permission = await Notification.requestPermission();
                console.log('Notification permission:', permission);
                
                if (permission === 'granted') {
                    await subscribeToPush(registration);
                }
            } else {
                await subscribeToPush(registration);
            }
        } catch (error) {
            console.error('Service Worker registration failed:', error);
        }
    });
}

async function subscribeToPush(registration) {
    try {
        // Get VAPID public key from server or use hardcoded one
        const vapidPublicKey = document.querySelector('meta[name="vapid-public-key"]')?.content 
            || 'BH713nXU9JhRgVkli85ccpcAKlNIkEMfJFz1vPtCTHR7DgaBObtDyYAgsK72nQteTcEA-zKRoBTVvpDC9Z9vsG0';
        
        // Convert VAPID key to Uint8Array
        const applicationServerKey = urlBase64ToUint8Array(vapidPublicKey);
        
        // Subscribe to push
        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: applicationServerKey
        });
        
        console.log('Push subscription:', subscription);
        
        // Send subscription to server
        await fetch('/api/push/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(subscription)
        });
        
        console.log('Push subscription sent to server');
    } catch (error) {
        console.error('Push subscription failed:', error);
    }
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');
    
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    
    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
