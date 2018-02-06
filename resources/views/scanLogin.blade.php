
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LaravelVue</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ config('website.icon') }}">
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- 渲染插件Css -->
@if (!empty($resources['css']))
  @foreach ($resources['css'] as $css)
  <link href={{ $css }} rel=stylesheet>
  @endforeach
@endif
<script>
    window.config = {
        csrfToken:'{{ csrf_token() }}',
        userId: {{ empty(Auth::id())? 0: Auth::id()  }},
@if (!empty($resources['config']))
@foreach ($resources['config'] as $key => $config)
      {{ $key }}: {!! json_encode($config) !!},
@endforeach
@endif
    }
</script>
</head>
<body>
    <div id=app class="scanQrcode">
        <div class="main">
            <div id="qrcode" class="qrcode"></div>
            <div class="state">
                使用手机扫码登录
            </div>
        </div>
    </div>
    <script type=text/javascript src={{ asset('/js/vue.js') }}></script>
    <script type=text/javascript src={{ asset('/js/qrcode.js') }}></script>
    <script type="text/javascript">
        var Main = {
            data() {
              return {
                sessionId: "{{ $sessionId }}",
                QRcode: "{{ $QRcode }}"
              };
            },
            mounted() {
                this.init()
            },
            methods: {
              init() {
                  new QRCode(document.getElementById("qrcode"), this.QRcode);
              }
            }
          };
        var Ctor = Vue.extend(Main)
        new Ctor().$mount('#app')
    </script>
    <!-- 渲染插件Js Begin -->
@if (!empty($resources['js']))
  @foreach ($resources['js'] as $js)
  <script type=text/javascript src={{ $js }}></script>
  @endforeach
@endif
    <!-- 渲染插件Js End -->
</body>
</html>
