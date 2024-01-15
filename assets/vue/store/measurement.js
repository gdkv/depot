import {reactive, ref, toRefs} from "vue";
import {
    trans,
    MEASUREMENTS_CO2,
    MEASUREMENTS_HUMIDITY,
    MEASUREMENTS_LUX,
    MEASUREMENTS_NOISE, MEASUREMENTS_PRESSURE,
    MEASUREMENTS_TEMPERATURE
} from "../../translator";
import MeasurementService from "../services/measurement.service";

const state = reactive({
    measurementsTypes: {
        temperature: {
            name: trans(MEASUREMENTS_TEMPERATURE),
            measures: [],
            color: 'rgba(252, 92, 125, 1)',
            isLimit: true,
            isSelected: true
        },
        humidity: {
            name: trans(MEASUREMENTS_HUMIDITY),
            measures: [],
            color: 'rgba(255, 188, 66, 1)',
            isLimit: false,
            isSelected: false
        },
        lux: {
            name: trans(MEASUREMENTS_LUX),
            measures: [],
            color: 'rgba(48, 169, 222, 1)',
            isLimit: false,
            isSelected: false
        },
        decibel: {
            name: trans(MEASUREMENTS_NOISE),
            measures: [],
            color: 'rgba(108, 73, 184, 1)',
            isLimit: true,
            isSelected: false
        },
        pressure: {
            name: trans(MEASUREMENTS_PRESSURE),
            measures: [],
            color: 'rgba(103, 213, 181, 1)',
            isLimit: false,
            isSelected: false
        },
        co2: {
            name: trans(MEASUREMENTS_CO2),
            measures: [],
            color: 'rgb(11,199,77)',
            isLimit: false,
            isSelected: false
        }
    },
    measurements: [
        {measure: 0, createdAt: '2024-01-01T00:00:00+00:00'},
        {measure: 0, createdAt: '2024-01-01T00:05:00+00:00'},
        {measure: 0, createdAt: '2024-01-01T00:10:00+00:00'}
    ]
});

export default function useMeasurement() {

    const fetchMeasurement = async (sensor, type, period) => {
        // if (!state.currentUser.id) {
        state.measurements = await MeasurementService.list(sensor, type, period);
        // console.log(state.measurements);
        // }
    }

    return {
        ...toRefs(state),
        fetchMeasurement
    }
}