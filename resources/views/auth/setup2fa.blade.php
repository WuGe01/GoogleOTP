@extends('layouts.app')

@section('content')
<div class="container">
    <h2>設定兩步驟驗證</h2>
    <p>請掃描以下 QR 碼，然後輸入你的 Google Authenticator 生成的驗證碼進行驗證。</p>
    <div>
        {!! $QRImage !!}
    </div>
</div>
@endsection
