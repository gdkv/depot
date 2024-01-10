import {ApiRoutes as routes} from "../helpers/apiRoutes";
import useCurrentUser from "../store/user";

class AuthService {
    constructor() {
        this.token = localStorage.getItem('userToken');
    }

    login(email, password){

        return fetch(routes.auth.login.url, {
            method: routes.auth.login.method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        })
        .then(response => response.json())
        .then((token) => {
            if (token.token) {
                localStorage.setItem('userToken', token.token);
            }

            return token;
        });
    }

    user(){
        // const {currentUser} = useCurrentUser();
        //
        // if (currentUser.id) {
        //     return currentUser;
        // }

        return fetch(routes.auth.user.url, {
            method: routes.auth.user.method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${this.token}`
            }
        })
            .then(response => response.json())
            .then((user) => {
                return user.response;
            });
    }

    register(user) {
        return fetch(routes.auth.registration.url, {
            method: routes.auth.registration.method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: user.email,
                password: user.password
            })
        })
            .then(response => response.json())
            .then((user) => {

                return user;
            });
    }

    logout() {
        localStorage.removeItem('user');
    }
}
export default new AuthService();
