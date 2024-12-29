import { createStore } from 'vuex';

export default createStore({
  state: () => ({
    user: null, 
  }),
  mutations: {
    setUser(state, userData) {
      state.user = userData; // Mutation to update user data
    },
    clearUser(state) {
      state.user = null; // Mutation to clear user data
    },
  },
  actions: {
    updateUser({ commit }, userData) {
      commit('setUser', userData); // Action to commit mutation
    },
    logout({ commit }) {
      commit('clearUser'); // Action to clear user data on logout
    },
  },
  getters: {
    token: (state) => state.user ? state.user.token : null,
    isAuthenticated(state) {
      return !!state.user; // Check if the user is authenticated
    },
    getUser(state) {
      return state.user; // Getter to access user data
    },
  },
});