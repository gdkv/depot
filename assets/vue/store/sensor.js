import {ApiRoutes as routes} from "../helpers/apiRoutes";
import {reactive, toRefs} from "vue";
import SensorService from "../services/sensor.service";

const state = reactive({
    sensors: [],
    selectedSensor: {
        id: null,
        name: null,
        lastMeasurement: {
            id: null,
            createdAt: '00.00.0000 00:00:00'
        }
    }
});

export default function useSensor() {

    const fetchAll = async () => {
        state.sensors = await SensorService.list();
        state.selectedSensor = state.sensors[0];
    }

    return {
        ...toRefs(state),
        fetchAll
    }
}


