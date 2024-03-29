import axios from 'axios'

export default {
    state: {
        user: null
    },

    mutations: {
        setUserData(state, userData) {
            state.user = userData
            localStorage.setItem('user', JSON.stringify(userData))
            axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`
        },
        updateUserData(state, userData) {
            state.user.user = userData
            let userLocalData = localStorage.getItem('user');
            console.log(userLocalData)
            userLocalData = JSON.parse(userLocalData)
            userLocalData.user = userData
            localStorage.setItem('user', JSON.stringify(userLocalData))
        },

        clearUserData() {
            localStorage.removeItem('user')
            location.reload()
        }
    },

    actions: {
        login({ commit }, credentials) {
            return axios
                .post('/api/login', credentials)
                .then(({ data }) => {
                    commit('setUserData', data)
                })
        },

        logout({ commit }) {
            commit('clearUserData')
        },
        RETRIEVE_ACTIVE_USER_DETAILS(context) {

            axios
                .get(`/api/user/${context.state.user.user.id}`)
                .then(response => (context.commit('updateUserData', response.data.data)))
                .catch(function (error) {

                })
        },
    },

    getters: {
        isLogged: state => !!state.user,
        getUserData(state) {
            return state.user;
        }
    }
}