@extends('layouts.app')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.products.index') }}" class="hover:text-red-600">Quản lý sản phẩm</a>
            <span>/</span>
            <span class="text-gray-900">Thêm mới</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Thêm sản phẩm mới</h1>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Product Code & Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Mã sản phẩm <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           id="code" 
                           name="code" 
                           value="{{ old('code') }}"
                           placeholder="VD: SP001"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('code') border-red-500 @enderror"
                           required>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên sản phẩm <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           placeholder="VD: Bút bi Thiên Long 08"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Hình ảnh sản phẩm
                </label>
                
                <!-- Image preview -->
                <div id="imagePreview" class="hidden mb-4">
                    <img src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg border-2 border-gray-200">
                    <button type="button" onclick="clearImage()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                        <i class="fas fa-times mr-1"></i> Xóa ảnh
                    </button>
                </div>

                <!-- Upload area -->
                <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-red-500 transition-colors">
                    <input type="file" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           onchange="previewImage(event)"
                           class="hidden">
                    <label for="image" class="cursor-pointer">
                        <div class="space-y-2">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="text-gray-600">
                                <span class="font-medium text-red-600 hover:text-red-700">Nhấp để chọn</span>
                                <span> hoặc kéo thả ảnh vào đây</span>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 2MB</p>
                        </div>
                    </label>
                </div>
                
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Mô tả
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          placeholder="Nhập mô tả chi tiết về sản phẩm..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('description') border-red-500 @enderror"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category, Supplier & Unit -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Danh mục <span class="text-red-600">*</span>
                    </label>
                    <select id="category_id" 
                            name="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('category_id') border-red-500 @enderror"
                            required>
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Nhà cung cấp
                    </label>
                    <select id="supplier_id" 
                            name="supplier_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('supplier_id') border-red-500 @enderror">
                        <option value="">Chọn nhà cung cấp</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                        Đơn vị tính <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           id="unit" 
                           name="unit" 
                           value="{{ old('unit') }}"
                           placeholder="VD: Hộp, Cái, Chiếc..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('unit') border-red-500 @enderror"
                           required>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Price & Stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Giá bán <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', 0) }}"
                               min="0"
                               step="1000"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('price') border-red-500 @enderror"
                               required>
                        <span class="absolute right-4 top-2.5 text-gray-500">₫</span>
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Số lượng tồn kho <span class="text-red-600">*</span>
                    </label>
                    <input type="number" 
                           id="stock_quantity" 
                           name="stock_quantity" 
                           value="{{ old('stock_quantity', 0) }}"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('stock_quantity') border-red-500 @enderror"
                           required>
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Featured -->
            <div>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" 
                           name="is_featured" 
                           value="1"
                           {{ old('is_featured') ? 'checked' : '' }}
                           class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <span class="text-sm font-medium text-gray-700">Đánh dấu là sản phẩm nổi bật</span>
                </label>
                <p class="mt-1 ml-8 text-xs text-gray-500">Sản phẩm sẽ được hiển thị ở trang chủ</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.products.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Hủy
                </a>
                
                <button type="submit" 
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-sm hover:shadow">
                    Thêm sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 3000)">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 3000)">
        {{ session('error') }}
    </div>
@endif

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');
            img.src = e.target.result;
            preview.classList.remove('hidden');
            document.getElementById('uploadArea').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function clearImage() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('uploadArea').classList.remove('hidden');
}
</script>
@endsection
