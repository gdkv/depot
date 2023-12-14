import {ApiRoutes as routes} from "../helpers/apiRoutes";
import {reactive, toRefs} from "vue";

const state = reactive({
    currentUser: {}
});

export default function useCurrentUser() {


    return {
        ...toRefs(state),
    }
}