import {ApiRoutes as routes} from "../helpers/apiRoutes";
import {reactive, toRefs} from "vue";
import SensorService from "../services/sensor.service";

const state = reactive({
    sensors: []
});

export default function useSensor() {

    const fetchAll = async () => {
        state.sensors = await SensorService.list();
    }

    return {
        ...toRefs(state),
        fetchAll
    }
}


