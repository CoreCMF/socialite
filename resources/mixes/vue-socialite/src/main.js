// 引入依赖
import builderVue from 'builder-vue'
import Echo from 'laravel-echo'
// 引用
import Socialite from './components'

builderVue.Vue.use(Socialite)

let options = {
  broadcaster: window.config.broadcast.broadcaster,
  host: window.config.broadcast.host
}
window.echo = new Echo(options)

// 启动自动构建
builderVue.start()
