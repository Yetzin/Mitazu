// require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('navegacion', require('./components/navegacion').default);

Vue.directive('click-outside', {
    bind: function(el, binding, vnode) {
        this.event = function(event) {
            if (!(el == event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', this.event)
    },
    unbind: function(el) {
        document.body.removeEventListener('click', this.event)
    }
});

const app = new Vue({
    el: '#app'
});
