@extends('layouts.app')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.products.index') }}" class="hover:text-red-600">Quản lý sản phẩm</a>
            <span>/</span>
            <span class="text-gray-900">Chỉnh sửa</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Chỉnh sửa sản phẩm</h1>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Product Code & Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Mã sản phẩm <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           id="code" 
                           name="code" 
                           value="{{ old('code', $product->code) }}"
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
                           value="{{ old('name', $product->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Mô tả
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('description') border-red-500 @enderror"
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Hình ảnh sản phẩm
                </label>
                
                @if($product->image)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Hình ảnh hiện tại:</p>
                        <div class="relative inline-block">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                            <label class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity cursor-pointer rounded-lg">
                                <span class="text-white text-sm font-medium">Thay đổi</span>
                                <input type="file" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                            </label>
                        </div>
                    </div>
                @endif
                
                <div class="mt-2">
                    <label for="image" class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="font-medium text-red-600">Click để tải ảnh lên</span> hoặc kéo thả
                            </p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF tối đa 2MB</p>
                        </div>
                        <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>
                
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-sm text-gray-600 mb-2">Xem trước:</p>
                    <img id="preview" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                </div>
                
                @error('image')
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
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
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
                           value="{{ old('unit', $product->unit) }}"
                           placeholder="VD: Hộp, Cái, Chiếc..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('unit') border-red-500 @enderror"
                           required>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Giá bán <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $product->price) }}"
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tồn kho hiện tại
                    </label>
                    <div class="flex items-center h-11 px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                        <span class="text-gray-900 font-medium">{{ $product->stock_quantity }} {{ $product->unit }}</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        * Để cập nhật tồn kho, vui lòng sử dụng chức năng "Nhập kho" ở danh sách sản phẩm
                    </p>
                </div>
            </div>

            <!-- Status & Featured -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="text-sm font-medium text-gray-700">Hiển thị sản phẩm</span>
                    </label>
                    <p class="mt-1 ml-8 text-xs text-gray-500">Sản phẩm sẽ được hiển thị trên website</p>
                </div>

                <div>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               name="is_featured" 
                               value="1"
                               {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="text-sm font-medium text-gray-700">Sản phẩm nổi bật</span>
                    </label>
                    <p class="mt-1 ml-8 text-xs text-gray-500">Hiển thị ở trang chủ</p>
                </div>
            </div>

            <!-- Product Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Thông tin sản phẩm</h3>
                        <div class="mt-2 text-sm text-blue-700 space-y-1">
                            <p><strong>Slug:</strong> {{ $product->slug }}</p>
                            <p><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Cập nhật lần cuối:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.products.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Hủy
                </a>
                
                <button type="submit" 
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-sm hover:shadow">
                    Cập nhật sản phẩm
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Product Section -->
    <div class="mt-6 bg-white rounded-lg shadow-sm border border-red-200">
        <div class="p-6">
            <h3 class="text-lg font-bold text-red-900 mb-2">Xóa sản phẩm</h3>
            <p class="text-sm text-gray-600 mb-4">
                Sau khi xóa, sản phẩm sẽ không thể khôi phục. Vui lòng cân nhắc kỹ trước khi thực hiện.
            </p>
            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?\n\nHành động này không thể hoàn tác!');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                    Xóa sản phẩm vĩnh viễn
                </button>
            </form>
        </div>
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
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
