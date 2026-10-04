@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')

<div class="product-edit-page">

    <div class="product-edit-heading">
        <div>
            <span class="product-edit-eyebrow">MANAJEMEN PRODUK</span>
            <h2>Edit Produk</h2>
            <p>Perbarui informasi produk SweetBites kamu.</p>
        </div>

        <a href="{{ url('/admin/products') }}" class="product-back-link">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
    <div class="product-alert">
        <strong>Periksa kembali data berikut:</strong>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="productEditForm"
        action="{{ route('admin.products.update', $product->id) }}"
        method="POST"
        enctype="multipart/form-data"
        data-original-image="{{ $product->gambar ? asset('storage/products/' . $product->gambar) : '' }}"
        data-original-name="{{ $product->gambar ? basename($product->gambar) : '' }}">

        @csrf
        @method('PUT')

        <div class="product-edit-card">

            <div class="product-card-heading">
                <div class="product-heading-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <h3>Informasi Produk</h3>
                    <p>Lengkapi detail produk yang akan diperbarui.</p>
                </div>
            </div>

            <div class="product-edit-grid">

                <!-- KOLOM KIRI -->
                <div class="product-edit-left">

                    <div class="product-field">
                        <label for="gambar">Upload Foto</label>

                        <div class="product-upload-box">
                            <input type="file"
                                name="gambar"
                                id="gambar"
                                accept="image/*">

                            <div class="product-upload-hint">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <span>Pilih foto produk dari perangkat kamu</span>
                            </div>
                        </div>

                        <div class="product-image-preview">

                            <img id="previewImage"
                                src="{{ $product->gambar ? asset('storage/products/' . $product->gambar) : '' }}"
                                alt="Preview produk"
                                class="product-thumb"
                                @if (!$product->gambar) hidden @endif>

                            <div id="emptyPreview"
                                class="product-thumb-placeholder"
                                @if ($product->gambar) hidden @endif>
                                <i class="bi bi-image"></i>
                            </div>

                            <div class="product-preview-info">
                                <strong id="previewName">
                                    {{ $product->gambar ? basename($product->gambar) : 'Belum ada foto' }}
                                </strong>
                                <span id="previewInfo">
                                    {{ $product->gambar ? 'Foto produk tersimpan' : 'JPG, PNG, atau WEBP' }}
                                </span>
                                <span class="product-photo-badge">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Foto Utama
                                </span>
                            </div>

                            <button type="button"
                                id="removeImage"
                                class="product-delete-photo"
                                title="Batalkan foto baru">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>

                        <small class="product-help">
                            Foto baru akan menggantikan foto lama setelah disimpan.
                        </small>
                    </div>

                    <div class="product-field">
                        <label for="kategori_id">Kategori</label>

                        <select name="kategori_id"
                            id="kategori_id"
                            class="product-input"
                            required>
                            <option value="">Pilih kategori</option>

                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('kategori_id', $product->kategori_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                            @endforeach
                        </select>

                        <div class="product-category-suggestions">
                            <span>Saran:</span>

                            @foreach ($categories as $category)
                            <button type="button"
                                class="product-category-chip"
                                data-id="{{ $category->id }}">
                                {{ $category->nama_kategori }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="product-field">
                        <label for="stok">Stok</label>

                        <div class="product-input-icon">
                            <i class="bi bi-box-seam"></i>
                            <input type="number"
                                name="stok"
                                id="stok"
                                class="product-input"
                                min="0"
                                value="{{ old('stok', $product->stok) }}"
                                required>
                        </div>

                        <small class="product-help">
                            Masukkan jumlah produk yang tersedia.
                        </small>
                    </div>

                    <div class="product-field">
                        <label for="batch_produk">Batch Produk</label>

                        <select name="batch_produk"
                            id="batch_produk"
                            class="product-input">
                            @foreach ([
                            'Pagi (06:00 WIB)',
                            'Siang (12:00 WIB)',
                            'Sore (16:00 WIB)'
                            ] as $batch)
                            <option value="{{ $batch }}"
                                {{ old('batch_produk', $product->batch_produk ?? '') == $batch ? 'selected' : '' }}>
                                {{ $batch }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- KOLOM KANAN: TANPA GAMBAR MEMANJANG -->
                <div class="product-edit-right">

                    <div class="product-field">
                        <label for="nama_kue">Nama Produk</label>

                        <input type="text"
                            name="nama_kue"
                            id="nama_kue"
                            class="product-input"
                            value="{{ old('nama_kue', $product->nama_kue) }}"
                            placeholder="Masukkan nama produk"
                            maxlength="150"
                            required>

                        <small class="product-help">
                            Gunakan nama produk yang jelas dan menarik untuk katalog.
                        </small>
                    </div>

                    <div class="product-field">
                        <label for="harga">Harga</label>

                        <div class="product-price-input">
                            <span>Rp</span>
                            <input type="number"
                                name="harga"
                                id="harga"
                                class="product-input"
                                min="0"
                                step="1"
                                value="{{ old('harga', $product->harga) }}"
                                placeholder="65000"
                                required>
                        </div>

                        <small class="product-help">
                            Harga dalam satuan Rupiah (IDR) tanpa pemisah titik.
                        </small>
                    </div>

                    <div class="product-field">
                        <label for="deskripsi">Deskripsi</label>

                        <textarea name="deskripsi"
                            id="deskripsi"
                            class="product-input product-description"
                            maxlength="300"
                            placeholder="Tuliskan deskripsi produk..."
                            required>{{ old('deskripsi', $product->deskripsi) }}</textarea>

                        <div class="product-description-footer">
                            <small>Tekan Shift + Enter untuk baris baru.</small>
                            <span><b id="descriptionCount">{{ mb_strlen(old('deskripsi', $product->deskripsi ?? '')) }}</b> / 300 karakter</span>
                        </div>
                    </div>

                </div>

            </div>

            <div class="product-edit-actions">
                <button type="submit" class="product-save-button">
                    <i class="bi bi-floppy"></i>
                    Update Produk
                </button>

                <a href="{{ url('/admin/products') }}"
                    class="product-cancel-button">
                    <i class="bi bi-x-lg"></i>
                    Batal
                </a>
            </div>

        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('gambar');
        const previewImage = document.getElementById('previewImage');
        const emptyPreview = document.getElementById('emptyPreview');
        const previewName = document.getElementById('previewName');
        const previewInfo = document.getElementById('previewInfo');
        const removeButton = document.getElementById('removeImage');
        const description = document.getElementById('deskripsi');
        const descriptionCount = document.getElementById('descriptionCount');

        const form = document.getElementById('productEditForm');

        const originalImage = form.dataset.originalImage;
        const originalName = form.dataset.originalName;

        let temporaryUrl = null;

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Pilih file gambar yang valid.');
                this.value = '';
                return;
            }

            if (temporaryUrl) URL.revokeObjectURL(temporaryUrl);
            temporaryUrl = URL.createObjectURL(file);

            previewImage.src = temporaryUrl;
            previewImage.hidden = false;
            emptyPreview.hidden = true;

            previewName.textContent = file.name;
            previewInfo.textContent =
                (file.size / (1024 * 1024)).toFixed(2) +
                ' MB • ' + file.type.split('/')[1].toUpperCase();
        });

        removeButton.addEventListener('click', function() {
            fileInput.value = '';

            if (temporaryUrl) {
                URL.revokeObjectURL(temporaryUrl);
                temporaryUrl = null;
            }

            if (originalImage) {
                previewImage.src = originalImage;
                previewImage.hidden = false;
                emptyPreview.hidden = true;
                previewName.textContent = originalName;
                previewInfo.textContent = 'Foto produk tersimpan';
            } else {
                previewImage.removeAttribute('src');
                previewImage.hidden = true;
                emptyPreview.hidden = false;
                previewName.textContent = 'Belum ada foto';
                previewInfo.textContent = 'JPG, PNG, atau WEBP';
            }
        });

        document.querySelectorAll('.product-category-chip').forEach(function(chip) {
            chip.addEventListener('click', function() {
                document.getElementById('kategori_id').value = this.dataset.id;
            });
        });

        function countDescription() {
            descriptionCount.textContent = description.value.length;
        }

        description.addEventListener('input', countDescription);
        countDescription();
    });
</script>
@endsection