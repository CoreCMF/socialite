<template>
<div id="app" class="qrcode">
    <div class="main">
        <div
          v-if="state"
          class="scanSuccess"
        >
            <i class="fa fa-check-circle"></i>
            <span>扫描成功</span>
        </div>
        <qrcode-item
         v-else
         v-model="QRcode"
         :config="config"
       />
        <div class="state">
            使用手机扫码登录
        </div>
    </div>
</div>
</template>

<script>
import Cookies from 'js-cookie'
import echo from '../mixins/echo'
import { forIn } from 'lodash'
export default {
  name: 'socialite-scan',
  mixins: [echo],
  data () {
    return {
      QRcode: 'null',
      redirect: null,
      config: {
        size: 320
      },
      state: false
    }
  },
  computed: {
    apiUrl () {
      return this.$route.meta.apiUrl
    }
  },
  methods: {
    initData () {
      let apiUrl = this.apiUrl
      let thenFunction = (Response) => {
        this.QRcode = Response.data.config.QRcode
        this.redirect = Response.data.config.redirect
      }
      this.$store.dispatch('getData', {apiUrl, thenFunction})
    },
    getBroadcast () {
      let broadcast = this.$store.state.mainData.config.broadcast
      return {
        channel: broadcast.channel,
        type: broadcast.type
      }
    },
    getEventHandlers () {
      return {
        'CoreCMF\\Socialite\\App\\Events\\LoginBroadcasting': response => {
          if (response.uuid) {
            forIn(response.cookies, (value, name) => {
              Cookies.set(name, value)
            })
            location.href = this.redirect
          } else {
            this.state = true
          }
        }
      }
    }
  },
  mounted () {
    this.initData()
  }
}
</script>
<style lang="scss">
body{
  margin: 0;
}
.qrcode {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	background-color: #909399;
	position: absolute;
	width: 100%;
	height: 100%;
    >.main {
    	border-radius: 4px;
    	background-color: #FFF;
    	padding: 15px;
        .scanSuccess{
            width: 320px;
            height: 320px;
            color: #67C23A;
            background-color: #fff;
            display: flex;
        	flex-direction: column;
        	justify-content: center;
        	align-items: center;
            i{
                font-size: 75px;
                color: #67C23A;
                margin: 15px;
            }
            span{
                font-size: 27px;
            }
        }
        >.state {
        	margin-top: 15px;
        	border-radius: 4px;
        	background-color: #F56C6C;
        	color: #FFF;
        	padding: 20px;
        	border: 1px solid #E4E7ED;
        	text-align: center
        }
    }

}
</style>
