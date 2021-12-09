import axios from 'axios'
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const apiEndpoint = "http://127.0.0.1:8000/api/v1"

export const Mutations = {
  set_loading: "set_loading",
  set_errors: "set_errors",
}

export default new Vuex.Store({
  state: {
    loading: false,
    errors: []
  },
  mutations: {
    [Mutations.set_loading] (state) {
      state.loading = !state.loading 
    },
    [Mutations.set_errors] (state, errors = []) {
      state.errors = errors
    }
  },
  actions: {
    send_feedback_to_endpoint(ctx, feedback) {
      return new Promise((resolve, reject) => {
        ctx.commit(Mutations.set_errors)
        ctx.commit(Mutations.set_loading)
        axios.post(`${apiEndpoint}/feedback`, feedback)
          .then(res => {
            if (Object.keys(res.data).includes('errors')) {
              ctx.commit(Mutations.set_errors, res.data.errors)
              reject(res.data.errors)
            }
            if (Object.keys(res.data).includes('message')) {
              resolve(res.data.message)
            }
          })
          .catch(err => {
            reject(err)
          })
          .finally(() => {
            ctx.commit(Mutations.set_loading)
          })
      }) 
    }
  },
  modules: {
  }
})
