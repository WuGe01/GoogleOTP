# 參考資料
https://github.com/antonioribeiro/google2fa-laravel?tab=readme-ov-file

# 基本作業
npm install
npm run dev

# 需要套件
composer require laravel/ui (可用可不用)
php artisan ui bootstrap --auth (可用可不用)
composer require pragmarx/google2fa-laravel (必須 主套件)
php artisan vendor:publish --provider="PragmaRX\Google2FA\ServiceProvider" (註冊方法)
composer require bacon/bacon-qr-code (必須 生成QRcode 工具)

# 創建處理用的middleware
php artisan make:middleware TwoFactorAuthentication
簡易說明，基本上這就是檢查 是否有通過OTP 如果有通過OTP 會 使用 session('2fa') 記錄起來
沒有的話就會導到 route('2fa.verify') 重新輸入
同時需要 app/http/Kernel.php 註冊 這個 middleware(中間層) 才能使用

# 流程說明 
### 使用者註冊的時候
我這邊是使用 App\Http\Controllers\Auth\RegisterController
產生一個 $user->google2fa_secret = Google2FA::generateSecretKey(); 基本上就是 GOOGLEOTP的密碼
之後導到 setup2fa 這邊 App\Http\Controllers\GoogleController 的 show 生成QRcode 讓使用者掃描

### 註冊後的使用者登入
就會去檢查 是否有OTP 登入


