@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')

<section class="swiss-container py-16 md:py-24">
    <div class="max-w-md mx-auto">
        
        <!-- Header -->
        <div class="mb-12">
            <h1 class="swiss-h2 mb-4">ĐĂNG NHẬP</h1>
            <div class="w-16 h-1 bg-swiss-red"></div>
        </div>
        
        <div class="border-2 border-swiss-black p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="font-bold mb-3 block tracking-wide">
                        TÊN ĐĂNG NHẬP
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           value="{{ old('username') }}"
                           required 
                           autofocus
                           class="swiss-input @error('username') border-swiss-red @enderror">
                    @error('username')
                        <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="font-bold mb-3 block tracking-wide">
                        MẬT KHẨU
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="swiss-input @error('password') border-swiss-red @enderror">
                    @error('password')
                        <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember"
                           class="w-5 h-5 border-2 border-swiss-black text-swiss-red focus:ring-0">
                    <label for="remember" class="ml-3 font-medium">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-primary w-full h-14">
                    ĐĂNG NHẬP
                </button>
            </form>

            <!-- Divider -->
            <div class="my-8 border-t-2 border-swiss-gray-300"></div>
            
            <!-- Register Link -->
            <div class="text-center">
                <p class="swiss-body mb-4">Chưa có tài khoản?</p>
                <a href="{{ route('register') }}" class="btn-secondary inline-block">
                    ĐĂNG KÝ NGAY
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
