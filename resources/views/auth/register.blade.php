@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')

<section class="swiss-container py-16 md:py-24">
    <div class="max-w-2xl mx-auto">
        
        <!-- Header -->
        <div class="mb-12">
            <h1 class="swiss-h2 mb-4">ĐĂNG KÝ TÀI KHOẢN</h1>
            <div class="w-16 h-1 bg-swiss-red"></div>
        </div>
        
        <div class="border-2 border-swiss-black p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Username & Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="font-bold mb-3 block tracking-wide">
                            TÊN ĐĂNG NHẬP *
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               value="{{ old('username') }}"
                               required
                               class="swiss-input @error('username') border-swiss-red @enderror">
                        @error('username')
                            <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="font-bold mb-3 block tracking-wide">
                            EMAIL *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="swiss-input @error('email') border-swiss-red @enderror">
                        @error('email')
                            <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password & Confirmation -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="font-bold mb-3 block tracking-wide">
                            MẬT KHẨU *
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

                    <div>
                        <label for="password_confirmation" class="font-bold mb-3 block tracking-wide">
                            XÁC NHẬN MẬT KHẨU *
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               class="swiss-input">
                    </div>
                </div>

                <!-- Full Name -->
                <div>
                    <label for="full_name" class="font-bold mb-3 block tracking-wide">
                        HỌ VÀ TÊN *
                    </label>
                    <input type="text" 
                           id="full_name" 
                           name="full_name" 
                           value="{{ old('full_name') }}"
                           required
                           class="swiss-input @error('full_name') border-swiss-red @enderror">
                    @error('full_name')
                        <p class="mt-2 text-swiss-red swiss-small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender & Date of Birth -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="gender" class="font-bold mb-3 block tracking-wide">
                            GIỚI TÍNH
                        </label>
                        <select id="gender" 
                                name="gender"
                                class="swiss-input">
                            <option value="">Chọn giới tính</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_of_birth" class="font-bold mb-3 block tracking-wide">
                            NGÀY SINH
                        </label>
                        <input type="date" 
                               id="date_of_birth" 
                               name="date_of_birth" 
                               value="{{ old('date_of_birth') }}"
                               class="swiss-input">
                    </div>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="font-bold mb-3 block tracking-wide">
                        SỐ ĐIỆN THOẠI
                    </label>
                    <input type="text" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="swiss-input">
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="font-bold mb-3 block tracking-wide">
                        ĐỊA CHỈ
                    </label>
                    <textarea id="address" 
                              name="address" 
                              rows="3"
                              class="swiss-input">{{ old('address') }}</textarea>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-primary w-full h-14">
                    ĐĂNG KÝ
                </button>
            </form>

            <!-- Divider -->
            <div class="my-8 border-t-2 border-swiss-gray-300"></div>
            
            <!-- Login Link -->
            <div class="text-center">
                <p class="swiss-body mb-4">Đã có tài khoản?</p>
                <a href="{{ route('login') }}" class="btn-secondary inline-block">
                    ĐĂNG NHẬP NGAY
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
