const WebServiceURL = route('apns')
const pushID = 'web.nz.tankful'

export default function init() {
    if ('safari' in window && 'pushNotification' in window.safari) {
        console.log('Check permission');
        let permissionData = window.safari.pushNotification.permission(pushID);
        console.log(permissionData);
        checkRemotePermission(permissionData)
    }
}

async function checkRemotePermission (permissionData) {
    console.log(permissionData.permission);

    if (permissionData.permission === 'default') {
        // This is a new web service URL and its validity is unknown.

        // Fetch user data, then ask for permission to send notifications
        axios.get(route('api.auth.user.show'))
        .then(response => response.data)
        .then(response => {
            let userData = {
                userId: String(response.data.id)
            }

            window.safari.pushNotification.requestPermission(
                WebServiceURL,          // The web service URL.
                pushID,                 // The Website Push ID.
                userData,               // Data that you choose to send to your server to help you identify the user.
                checkRemotePermission   // The callback function.
            );
        })
    }
    else if (permissionData.permission === 'denied') {
        // The user said no.
    }
    else if (permissionData.permission === 'granted') {
        // The web service URL is a valid push provider, and the user said yes.
        // permissionData.deviceToken is now available to use.
        console.log(permissionData);
    }
};
