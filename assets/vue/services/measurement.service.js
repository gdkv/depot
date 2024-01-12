import {ApiRoutes as routes} from "../helpers/apiRoutes";

class MeasurementService {

    constructor() {
        this.token = localStorage.getItem('userToken');
    }

    list(sensor, type, period){
        return fetch(routes.measurements.list.url, {
            method: routes.measurements.list.method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${this.token}`
            },
            body: JSON.stringify({
                sensor: sensor,
                type: type,
                period: period
            })
        })
        .then(response => response.json())
        .then((itemList) => {
            return itemList;
        });
    }

}

export default new MeasurementService();
