@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color:#fff">
<div class="container">

    <h4 class="fw-bold text-primary mb-3">
        <i class="bi bi-bell-fill"></i> Notification Settings
    </h4>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <p id="push-status" class="text-muted mb-3">
                Checking notification status...
            </p>

            <div class="d-flex gap-2 flex-wrap mb-3">
                <button id="btn-subscribe" class="btn btn-success d-none">
                    <i class="fa  fa-bell"></i> Enable Notifications
                </button>

                <button id="btn-unsubscribe" class="btn btn-danger d-none">
                    <i class="fa fa-bell-slash"></i> Disable Notifications
                </button>

                <button id="btn-resubscribe" class="btn btn-warning">
                    <i class="fa fa-refresh"></i> Clear & Re-subscribe
                </button>

                @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                <button id="btn-clear-all-admin" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Clear ALL Subscriptions (Admin)
                </button>
                @endif

                <button id="btn-test-push" class="btn btn-primary">
                    <i class="fa fa-paper-plane"></i> Send Test Push
                </button>
            </div>

            <div class="alert alert-info mt-2">
                <i class="fa fa-info-circle"></i> 
                <strong>Note:</strong> If push notifications aren't working, click "Clear & Re-subscribe" to remove old subscriptions and create a new one with the correct encryption keys.
            </div>
        </div>
    </div>

</div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const btnTestPush = document.getElementById('btn-test-push');

btnTestPush.addEventListener('click', async () => {

    // Prevent double click
    btnTestPush.disabled = true;

    // Show loading alert
    Swal.fire({
        title: 'Sending Test Notification...',
        text: 'Please wait',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const res = await fetch("{{ route('admin.push.test') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        const data = await res.json();

        Swal.fire({
            icon: 'success',
            title: 'Done',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });

    } catch (error) {
        console.error(error);

        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Could not send test notification. Please try again.'
        });
    } finally {
        btnTestPush.disabled = false;
    }
});
</script>

<script>
const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
const csrfToken = "{{ csrf_token() }}";

const btnSubscribe = document.getElementById('btn-subscribe');
const btnUnsubscribe = document.getElementById('btn-unsubscribe');
const btnResubscribe = document.getElementById('btn-resubscribe');
const btnClearAllAdmin = document.getElementById('btn-clear-all-admin');
const statusText = document.getElementById('push-status');

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');
    const rawData = atob(base64);
    return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
}

function setEnabledUI() {
    btnSubscribe.classList.add('d-none');
    btnUnsubscribe.classList.remove('d-none');
    statusText.innerHTML = `<i class="fa fa-check-circle text-success"></i> Push notifications are enabled.`;
}

function setDisabledUI() {
    btnSubscribe.classList.remove('d-none');
    btnUnsubscribe.classList.add('d-none');
    statusText.innerHTML = `<i class="fa fa-times-circle text-danger"></i> Push notifications are disabled.`;
}

/* 🔎 INIT STATE */
document.addEventListener('DOMContentLoaded', async () => {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        statusText.innerHTML = 'Push notifications not supported.';
        return;
    }

    const reg = await navigator.serviceWorker.ready;
    const sub = await reg.pushManager.getSubscription();
    sub ? setEnabledUI() : setDisabledUI();
});

/* ✅ SUBSCRIBE */
btnSubscribe.addEventListener('click', async () => {
    try {
        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            throw new Error('Permission denied');
        }

        const reg = await navigator.serviceWorker.ready;

        // 🔥 ALWAYS clean old subscription
        const oldSub = await reg.pushManager.getSubscription();
        if (oldSub) {
            await oldSub.unsubscribe();
        }

        const newSub = await reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
        });

        await fetch("{{ route('push.subscribe') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(newSub)
        });

        setEnabledUI();

        Swal.fire({
            icon: 'success',
            title: 'Enabled',
            text: 'Notifications are now active',
            timer: 2000,
            showConfirmButton: false
        });

    } catch (err) {
        console.error(err);
        Swal.fire('Error', err.message || 'Subscription failed', 'error');
    }
});

/* ❌ UNSUBSCRIBE */
btnUnsubscribe.addEventListener('click', async () => {
    try {
        const reg = await navigator.serviceWorker.ready;
        const sub = await reg.pushManager.getSubscription();

        if (sub) {
            await fetch("{{ route('push.unsubscribe') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ endpoint: sub.endpoint })
            });

            await sub.unsubscribe();
        }

        setDisabledUI();

        Swal.fire({
            icon: 'success',
            title: 'Disabled',
            text: 'Notifications turned off',
            timer: 2000,
            showConfirmButton: false
        });

    } catch (err) {
        console.error(err);
        Swal.fire('Error', 'Unsubscribe failed', 'error');
    }
});

/* 🔄 CLEAR ALL & RESUBSCRIBE */
btnResubscribe.addEventListener('click', async () => {
    console.log('Resubscribe button clicked');
    
    try {
        // Show confirmation
        const result = await Swal.fire({
            icon: 'warning',
            title: 'Clear & Re-subscribe?',
            text: 'This will remove all your push subscriptions and create a new one with fresh encryption keys.',
            showCancelButton: true,
            confirmButtonText: 'Yes, do it!',
            cancelButtonText: 'Cancel'
        });

        if (!result.isConfirmed) {
            console.log('User cancelled');
            return;
        }

        btnResubscribe.disabled = true;
        btnResubscribe.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';

        console.log('Getting service worker...');
        const reg = await navigator.serviceWorker.ready;
        console.log('Service worker ready:', reg);

        // First, unsubscribe from browser
        const oldSub = await reg.pushManager.getSubscription();
        console.log('Old subscription:', oldSub);
        if (oldSub) {
            await oldSub.unsubscribe();
            console.log('Unsubscribed from browser');
        }

        // Clear server-side subscriptions
        console.log('Clearing server subscriptions...');
        const clearResponse = await fetch("{{ route('push.clearAll') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });
        console.log('Clear response:', clearResponse.status);

        if (!clearResponse.ok) {
            throw new Error('Failed to clear subscriptions on server');
        }

        // Now subscribe with fresh keys
        console.log('Requesting notification permission...');
        const permission = await Notification.requestPermission();
        console.log('Permission:', permission);
        if (permission !== 'granted') {
            throw new Error('Notification permission denied');
        }

        console.log('Subscribing to push...');
        const newSub = await reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
        });
        console.log('New subscription:', newSub);

        const subscribeResponse = await fetch("{{ route('push.subscribe') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(newSub)
        });
        console.log('Subscribe response:', subscribeResponse.status);

        if (!subscribeResponse.ok) {
            throw new Error('Failed to subscribe on server');
        }

        setEnabledUI();

        Swal.fire({
            icon: 'success',
            title: 'Re-subscribed!',
            text: 'You have been re-subscribed with fresh encryption keys',
            timer: 3000,
            showConfirmButton: false
        });

    } catch (err) {
        console.error('Resubscribe error:', err);
        Swal.fire('Error', err.message || 'Re-subscribe failed. Check console for details.', 'error');
    } finally {
        btnResubscribe.disabled = false;
        btnResubscribe.innerHTML = '<i class="fa fa-refresh"></i> Clear & Re-subscribe';
    }
});

/* 🗑️ ADMIN CLEAR ALL SUBSCRIPTIONS */
if (btnClearAllAdmin) {
    btnClearAllAdmin.addEventListener('click', async () => {
        const result = await Swal.fire({
            title: 'Clear ALL Push Subscriptions?',
            text: 'This will remove ALL push subscriptions from the database. All users will need to re-subscribe. This is useful when VAPID keys have changed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, clear all!',
            cancelButtonText: 'Cancel'
        });

        if (!result.isConfirmed) return;

        btnClearAllAdmin.disabled = true;
        btnClearAllAdmin.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Clearing...';

        try {
            const response = await fetch("{{ route('admin.push.clearAll') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cleared!',
                    text: data.message,
                    timer: 3000
                });
            } else {
                throw new Error(data.message || 'Failed to clear');
            }
        } catch (err) {
            console.error('Clear all error:', err);
            Swal.fire('Error', err.message || 'Failed to clear subscriptions', 'error');
        } finally {
            btnClearAllAdmin.disabled = false;
            btnClearAllAdmin.innerHTML = '<i class="fa fa-trash"></i> Clear ALL Subscriptions (Admin)';
        }
    });
}
</script>


@endsection
