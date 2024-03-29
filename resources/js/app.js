require('./bootstrap');

/**
 * Vue.js - The Progressive JavaScript Framework.
 */
window.Vue = require("vue");

/**
 * Vuex state management pattern
 * For browsers that do not implement Promise (e.g. IE), use a polyfill library, such as es6-promise.
 */
import Vuex from 'vuex'
import 'es6-promise/auto'
import { ToggleButton } from 'vue-js-toggle-button'

Vue.use(Vuex);
Vue.component('ToggleButton', ToggleButton);

/**
 * Define Vuex States & mutations
 */
const store = new Vuex.Store({
    state : {
        errors: {}
    },
    mutations:{
        addError(state,payload){

            if(state.errors[payload.key] == undefined){
                state.errors[payload.key] = []
            }

            if(Array.isArray(payload.errors)){
                Array.prototype.push.apply(state.errors[payload.key],payload.errors)
            }else{
                Array.prototype.push.apply(state.errors[payload.key],[payload.errors])
            }

            console.log(state.errors);
        },
        removeError(state,key = undefined){
            if(key != undefined){

                if(state.errors[key] != undefined){
                    state.errors[payload.key] = []
                }
            }else{
                state.errors = []
            }
        }
    }
});

Vue.mixin({
    data:function(){
        return{
            get store(){
                return store
            }
        }
    },
    methods:{
        submitForm(request,callbackSuccess=(res)=>{},callbackFail=(err)=>{}){
            axios[request.method](request.url,request.data).then(res  => {
                callbackSuccess(res);
                let message = null;
                switch (request.method) {
                    case 'post':
                        message = 'added-message';
                        break;
                    case 'delete':
                        message = 'delete-message';
                        break;
                    default:
                        message = 'process completed';
                        break;
                }
                $(document).Toasts('create', {
                    title: request.toaster.success.title,
                    subtitle: request.toaster.success.subtitle,
                    body: request.toaster.success.body,
                });
                if(request.redirect!=null)
                {
                    request.redirect = request.redirect.replace(':id', res.data.data.id);
                    console.log(request.redirect);
                    setTimeout(() => {
                        window.location.href = request.redirect;
                    }, 1000);
                }
            }).catch(error => {
                let  body=request.toaster.fail.body;
                if( error.response ){
                    console.log(error.response.data);
                    body=error.response.data["message"];
                    if (error.response.data.hasOwnProperty("errors")){
                        console.log("here");
                        for(let errorOb in error.response.data["errors"]){
                            body+="<br>"+errorOb+": "+error.response.data["errors"][errorOb];
                        }
                    }
                }
                callbackFail(error);
                $(document).Toasts('create', {
                    title: request.toaster.fail.title,
                    subtitle: request.toaster.fail.subtitle,
                    body: body,
                    icon:"fa fa-times",
                    autohide:true,
                });
            });
        }
    },
    computed:{
        errors(){
            return store.state.errors
        }
    }
});

// Errors Handler
// axios.interceptors.response.use((response)=>{
//     return Promise.resolve(error);
// },(err)=>{
//     store.commit('removeError');

//     let _errors = err.response.data.errors;

//     if(_errors){
//         let keys = Object.keys(_errors);

//         keys.forEach(function(key){
//             let payload={
//                 key:key,
//                 _errors:_errors[key][0]
//             }
//             store.commit('addError', payload);
//         })
//     }
//     return Promise.reject(error);
// })
