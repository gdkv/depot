export const ApiRoutes = {
    auth: {
        login: {
            url: '/api/auth',
            method: 'POST'
        },
        register: {
            url: '/api/registration',
            method: 'POST'
        },
        user: {
            url: '/api/user',
            method: 'POST'
        }   
    },

    sensor: {
        add: {
            url: '/api/sensor',
            method: 'POST'
        },
        list: {
            url: '/api/sensor',
            method: 'GET'
        },
        edit: {
            url: '/api/sensor/{sensorId}',
            method: 'PUT'
        },
        delete: {},
        get: {}
    },

    measurements: {
        list: {
            url: '/api/measurement',
            method: 'POST'
        }
    }
}