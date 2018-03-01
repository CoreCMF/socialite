<template>
<div id="app" class="qrcode">
    <div class="main">
        <div id="QRcode"></div>
        <qrcode-item
         v-model="QRcode"
         :config="config"
         v-if="QRcode"
       />
        <div class="state">
            使用手机扫码登录
        </div>
    </div>
</div>
</template>

<script>
import echo from '../mixins/echo'
export default {
  name: 'socialite-scan',
  mixins: [echo],
  data () {
    return {
      QRcode: 'null',
      config: {
        size: 320
      }
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
    //配置广播频道和方式
    getBroadcast () {
      let broadcast = this.$store.state.main.config.broadcast
      return {
        channel: broadcast.channel,
        type: broadcast.type
      }
    },
    getEventHandlers () {
      return {
        'CoreCMF\\Socialite\\App\\Events\\LoginBroadcasting': response => {
          document.cookie = 'laravel_session=' + response.laravelSession
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
