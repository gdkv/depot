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
        return {};
    }

    delete() {
        return {};
    }
}
export default new SensorService();
