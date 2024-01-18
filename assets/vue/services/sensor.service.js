import {ApiRoutes as routes} from "../helpers/apiRoutes";

class SensorService {
    constructor() {
        this.token = localStorage.getItem('userToken');
    }

    list(){
        return fetch(routes.sensor.list.url, {
            method: routes.sensor.list.method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${this.token}`
            }
        })
        .then(response => response.json())
        .then((sensorList) => {
            return sensorList;
        });
    }

    get(sensorId) {
        return {};
    }

    add(sensor) {
        return fetch(routes.sensor.add.url, {
            method: routes.sensor.add.method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${this.token}`
            },
            body: JSON.stringify({
                name: sensor.name,
                macAddress: sensor.macAddress,
                sensorType: 'sensor.type.default',
                position: 100,
                comment: ''
            })
        })
        .then(response => response.json())
        .then((sensor) => {
            return sensor;
        });
    }

    delete() {
        return {};
    }
}
export default new SensorService();
