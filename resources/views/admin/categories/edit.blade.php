@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="edit-category-page">

    <!-- Header Halaman -->
    <div class="edit-category-header">

        <div class="edit-category-heading">

            <div class="edit-title-row">

                <h1>
                    Edit Kategori: {{ $category->nama_kategori }}
                </h1>

                <span class="category-active-badge">
                    <span></span>
                    Aktif
                </span>

            </div>

            <p>
                Sesuaikan informasi kategori produk SweetBites.
            </p>

        </div>


        <a
            href="{{ route('admin.categories.index') }}"
            class="back-category-button"
        >
            ← Daftar Kategori
        </a>

    </div>


    <!-- Card Form -->
    <div class="edit-category-card">


        <!-- Card Header -->
        <div class="edit-card-header">

            <div class="edit-card-title">

                <div class="edit-card-icon">
                    C
                </div>

                <div>

                    <h2>
                        Informasi Pokok Kategori
                    </h2>

                    <p>
                        Ubah informasi kategori produk SweetBites.
                    </p>

                </div>

            </div>


            <div class="edit-card-meta">

                <span>
                    ID: #CAT-{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}
                </span>

                <span>
                    {{ $category->products_count ?? $category->products->count() }} Produk Terkait
                </span>

            </div>

        </div>


        <!-- Form -->
        <form
            action="{{ route('admin.categories.update', $category->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="edit-category-form"
        >

            @csrf
            @method('PUT')


            <!-- Nama Kategori -->
            <div class="form-group">

                <label for="nama_kategori">
                    Nama Kategori
                    <span>*</span>
                </label>

                <div class="input-wrapper">

                    <span class="input-icon">
                        C
                    </span>

                    <input
                        type="text"
                        id="nama_kategori"
                        name="nama_kategori"
                        value="{{ old('nama_kategori', $category->nama_kategori) }}"
                        placeholder="Misal: Cupcake Artisan"
                        required
                    >

                </div>

                @error('nama_kategori')
                    <small class="form-error">
                        {{ $message }}
                    </small>
                @enderror

                <p class="form-help">
                    Nama kategori yang akan ditampilkan pada katalog SweetBites.
                </p>

            </div>


            <!-- Deskripsi -->
            <div class="form-group">

                <div class="label-row">

                    <label for="deskripsi">
                        Deskripsi
                    </label>

                    <span
                        id="descriptionCounter"
                        class="character-counter"
                    >
                        {{ strlen(old('deskripsi', $category->deskripsi ?? '')) }}
                        / 200 karakter
                    </span>

                </div>


                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    maxlength="200"
                    placeholder="Masukkan deskripsi kategori..."
                >{{ old('deskripsi', $category->deskripsi ?? '') }}</textarea>


                @error('deskripsi')
                    <small class="form-error">
                        {{ $message }}
                    </small>
                @enderror


                <p class="form-help">
                    Tulis penjelasan singkat mengenai kategori ini.
                </p>

            </div>


            <!-- Foto / Gambar -->
            <div class="form-group">

                <label>
                    Foto Kategori
                </label>


                <div class="category-image-upload">

                    <!-- Preview -->
                    <div class="category-image-preview">

                        @if($category->gambar)

                            <img
                                id="categoryImagePreview"
                                src="{{ asset('storage/' . $category->gambar) }}"
                                alt="{{ $category->nama_kategori }}"
                            >

                        @else

                            <div
                                id="categoryImagePreview"
                                class="image-placeholder"
                            >
                                <span>
                                    {{ strtoupper(substr($category->nama_kategori, 0, 1)) }}
                                </span>
                            </div>

                        @endif

                    </div>


                    <!-- Upload Info -->
                    <div class="upload-content">

                        <div class="upload-buttons">

                            <label
                                for="gambar"
                                class="change-image-button"
                            >
                                Ganti Foto
                            </label>

                            <button
                                type="button"
                                class="remove-image-button"
                                id="removeImageButton"
                            >
                                Hapus
                            </button>

                        </div>


                        <p>
                            Pilih foto baru untuk kategori.
                            Format yang disarankan: JPG, PNG, atau WebP.
                            Maksimal 2 MB.
                        </p>


                        <input
                            type="file"
                            id="gambar"
                            name="gambar"
                            accept="image/jpeg,image/png,image/webp"
                            hidden
                        >

                    </div>

                </div>

            </div>


            <!-- Status -->
            <div class="category-status-box">

                <div class="status-left">

                    <div class="status-icon">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Status Kategori
                        </strong>

                        <p>
                            Kategori ini aktif dan dapat digunakan
                            pada produk SweetBites.
                        </p>

                    </div>

                </div>


                <span class="status-active-large">
                    Aktif
                </span>

            </div>


            <!-- Bottom Actions -->
            <div class="edit-form-footer">

                <!-- Hapus -->
                <button
                    type="button"
                    class="delete-category-button"
                    onclick="deleteCategory()"
                >
                    Hapus Kategori Ini
                </button>


                <div class="form-actions">

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="cancel-button"
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="save-category-button"
                    >
                        ✓
                        Simpan Perubahan
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<!-- Form Hapus -->
<form
    id="deleteCategoryForm"
    action="{{ route('admin.categories.destroy', $category->id) }}"
    method="POST"
    style="display: none;"
>
    @csrf
    @method('DELETE')
</form>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const description =
        document.getElementById('deskripsi');

    const counter =
        document.getElementById('descriptionCounter');


    if (description && counter) {

        description.addEventListener('input', function () {

            counter.textContent =
                this.value.length + ' / 200 karakter';

        });

    }


    const imageInput =
        document.getElementById('gambar');

    const imagePreview =
        document.getElementById('categoryImagePreview');


    if (imageInput) {

        imageInput.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) {
                return;
            }


            const reader =
                new FileReader();


            reader.onload = function (event) {

                if (imagePreview.tagName === 'IMG') {

                    imagePreview.src =
                        event.target.result;

                } else {

                    imagePreview.outerHTML =
                        '<img id="categoryImagePreview" src="' +
                        event.target.result +
                        '" alt="Preview">';

                }

            };


            reader.readAsDataURL(file);

        });

    }


    const removeButton =
        document.getElementById('removeImageButton');


    if (removeButton) {

        removeButton.addEventListener('click', function () {

            if (imageInput) {
                imageInput.value = '';
            }

        });

    }

});


function deleteCategory() {

    const confirmed =
        confirm(
            'Yakin ingin menghapus kategori {{ $category->nama_kategori }}?'
        );


    if (confirmed) {

        document
            .getElementById('deleteCategoryForm')
            .submit();

    }

}

</script>
@endsection