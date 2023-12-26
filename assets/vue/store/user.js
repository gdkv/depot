import {ApiRoutes as routes} from "../helpers/apiRoutes";
import {reactive, toRefs} from "vue";
import SensorService from "../services/sensor.service";
import AuthService from "../services/auth.service";

const state = reactive({
    currentUser: {
        id: null,
        email: '',
        name: ''
    }
});

export default function useCurrentUser() {

    const fetch = async () => {
        state.currentUser = await AuthService.user();
    }

    return {
        ...toRefs(state),
        fetch
    }
}