import {ApiRoutes as routes} from "../helpers/apiRoutes";
import {reactive, toRefs} from "vue";
import SensorService from "../services/sensor.service";

const state = reactive({
    sensors: [],
    selectedSensor: {
        id: null,
        position: 100,
        active: false,
        name: '',
        slug: '',
        zone: null,
        type: 'sensor.type.default',
        macAddress: '00-00-00-00-00-00',
        offsetMeasurement: {
            temperature: [],
            humidity: [],
            pressure: [],
            decibel: [],
            lux: []
        },
        lastMeasurement: {
            id: null,
            createdAt: '00.00.0000 00:00:00',
            createdAtArray: {
                type: 'days',
                value: 100
            }
        },
        comment: '',
        detailUrl: ''
    }
});

export default function useSensor() {

    const fetchAll = async () => {
        state.sensors = await SensorService.list();
        state.selectedSensor = state.sensors[0];
    }

    const addSensor = async (sensor) => {
        state.sensors.push(
            await SensorService.add(sensor)
        );
    }

    const changeSensor = (sensor) => {
        state.selectedSensor = sensor;
    }

    return {
        ...toRefs(state),
        fetchAll,
        changeSensor,
        addSensor
    }
}


