import {ApiRoutes as routes} from "../helpers/apiRoutes";

class AuthService {
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
                localStorage.setItem('userToken', JSON.stringify(token.token));
            }

            return token;
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
