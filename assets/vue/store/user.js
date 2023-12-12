import {ApiRoutes as routes} from "../helpers/apiRoutes";
import {reactive, toRefs} from "vue";

const state = reactive({
    token: '',
    currentUser: {}
});

export default function useCurrentUser() {

    const auth = async (email, password) => {
        state.token = await (await fetch(routes.auth.login.url, {
            method: routes.auth.login.method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        })).json()
    }

    return {
        ...toRefs(state),
        auth
    }
}