import {createStore} from "vuex";
import {isLoggedIn, logout} from "./shared/utils/auth.js";

export default {
    // const store = createStore({
        state : {
            lastSearch:{
                from: null,
                to: null,
            },
            basket:{
                items: []
            },
            isLoggedIn: false,
            user: {},
            // return {
            //     count: 0
            // }
        },
        mutations: {
            setLastSearch (state, payload) {
                state.lastSearch = payload
            },
            addToBasket (state, payload) {
                state.basket.items.push(payload)
            },
            removeFromBasket (state, payload) {
                state.basket.items = state.basket.items.filter(item => item.bookable.id != payload)
            },
            setBasket (state, payload){
                state.basket = payload
            },
            setUser (state, payload){
                state.user = payload
            },
            setLoggedIn (state, payload) {
                state.isLoggedIn = payload
            }
        },
    actions: {
            setLastSearch(context, payload) {
                context.commit('setLastSearch', payload)
                localStorage.setItem('lastSearch', JSON.stringify(payload))
            },
        loadStoredState(context){
                const lastSearch = localStorage.getItem('lastSearch')
            if (lastSearch){
                context.commit('setLastSearch', JSON.parse(lastSearch))
            }

            const basket = localStorage.getItem('basket')
            if (basket){
                context.commit('setBasket', JSON.parse(basket))

                context.commit("setLoggedIn", isLoggedIn())
            }
        },
        addToBasket({commit, state}, payload) {
                commit('addToBasket', payload)
            localStorage.setItem('basket', JSON.stringify(state.basket))
        },
        removeFromBasket({commit, state}, payload) {
            commit('removeFromBasket', payload)
            localStorage.setItem('basket', JSON.stringify(state.basket))
        },
        clearBasket({commit, state}, payload){
                commit("setBasket", {items: []})
            localStorage.setItem("basket", JSON.stringify(state.basket))
        },
        // async loadUser ({commit, dispatch}){
        //         if(isLoggedIn()){
        //             try {
        //                 const user = (await axios.get('/api/user')).data
        //                 commit("setUser", user)
        //                 commit("isLoggedIn", true)
        //             }catch (err){
        //                 dispatch("logout")
        //             }
        //         }
        // },
        async loadUser({ commit, dispatch }) {
            if (isLoggedIn()) {
                try {
                    const user = (await axios.get('/api/user')).data;
                    commit("setUser", user);
                    commit("setLoggedIn", true);
                } catch (err) {
                    // if (401 === err.response.status)
                    // {
                        dispatch("logout");
                    // }

                }
            }
        },
        logout({commit}){
                commit("setUser", {})
            commit("setLoggedIn", false)
            logout()
        }
    },
    getters: {
            itemsInBasket: (state) => state.basket.items.length,
        inBasketAlready: (state) => {
                return function (id){
                    return state.basket.items.reduce((result, item) => result || item.bookable.id === id, false)

                }
        }
    }
    // })
}
