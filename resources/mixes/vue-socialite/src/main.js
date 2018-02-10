// 引入依赖
import builderVue from 'builder-vue'
import Echo from 'laravel-echo'
// 引用
import Socialite from './components'
import BuilderVueElement from 'builder-vue-element'

builderVue.Vue.use(Socialite)
builderVue.Vue.use(BuilderVueElement)

let options = {
  broadcaster: window.config.broadcast.broadcaster,
  host: window.config.broadcast.host
}
window.echo = new Echo(options)

// 启动自动构建
builderVue.start()
