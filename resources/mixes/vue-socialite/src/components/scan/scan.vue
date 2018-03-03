<template>
<div id="app" class="qrcode">
    <div class="main">
        <qrcode-item
         v-model="QRcode"
         :config="config"
         v-if="QRcode"
       />
       <div class="scanSuccess">

       </div>
        <div class="state">
            {{state}}
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
      config: {
        size: 320
      },
      state: '使用手机扫码登录'
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
          forIn(response.cookies, (value, name) => {
            Cookies.set(name, value)
          })
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
            width: 160px;
            height: 37px;
            background-color: #67C23A;
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
