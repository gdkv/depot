import {ApiRoutes as routes} from "../helpers/apiRoutes";
import {reactive, toRefs} from "vue";
import SensorService from "../services/sensor.service";

const state = reactive({
    sensors: [],
    selectedSensor: {
        id: '33caa00a-bbb0cc-333ed',
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
        console.log(state.selectedSensor);
    }

    const addSensor = async (sensor) => {
        state.sensors.push(
            await SensorService.add(sensor)
        );
    }

    const editSensor = async (sensor) => {
        const editSensor = await SensorService.edit(sensor);
        state.sensors.map((sensor) => {
            if(sensor.id === editSensor.id) {
                sensor.name = editSensor.name;
                sensor.comment = editSensor.comment;
            }
        });
    }

    const changeSensor = (sensor) => {
        state.selectedSensor = sensor;
    }

    return {
        ...toRefs(state),
        fetchAll,
        changeSensor,
        addSensor,
        editSensor
    }
}


