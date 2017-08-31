# corecmf

## Structure

```     
src/
```

## Install

Via Composer

```bash
$ composer require corecmf/socialite
```

## Usage
安装完成后需要在config/app.php中注册服务提供者到providers数组：
```
CoreCMF\Socialite\SocialiteServiceProvider::class,
```
##install   
直接浏览器访问项目地址安装   
例: http://corecmf.dev/
```
php artisan corecmf:socialite:install
```
