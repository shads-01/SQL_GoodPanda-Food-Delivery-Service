<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item | {{ $restaurant->name ?? 'Restaurant' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --ink: #1a1612;
            --paper: #f5f0e8;
            --cream: #faf7f2;
            --ember: #e85d2f;
            --ember-deep: #c44a20;
            --gold: #c9973a;
            --mist: #ede8df;
            --ink-faint: #3d3730;
            --ink-ghost: rgba(26, 22, 18, 0.06);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            min-height: 100vh;
        }

        .font-display {
            font-family: 'Sora';
        }

        .page-header-title {
            font-size: 1.5rem;
            font-family: 'Sora', sans-serif;
        }

        @media (min-width: 768px) {
            .page-header-title {
                font-size: 1.5rem;
            }
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(ellipse 80% 60% at 90% -10%, rgba(201, 151, 58, 0.07) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 5% 95%, rgba(232, 93, 47, 0.06) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .page-wrap {
            position: relative;
            z-index: 1;
            width: 60%;
            margin: 0 auto;
        }

        .form-card {
            background: #fff;
            border: 1px solid var(--mist);
            border-radius: 24px;
            box-shadow: 0 2px 4px rgba(26, 22, 18, 0.04), 0 12px 40px rgba(26, 22, 18, 0.06);
        }

        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            /* Increased from 10px */
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ember);
            margin-bottom: 20px;
        }

        .section-eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--ember);
            border-radius: 2px;
        }

        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-faint);
            margin-bottom: 8px;
        }

        .field-input {
            width: 100%;
            padding: 14px 18px;
            background: var(--cream);
            border: 1.5px solid var(--mist);
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }

        .field-input::placeholder {
            color: #b8b0a4;
        }

        .field-input:focus {
            border-color: var(--ember);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(232, 93, 47, 0.1);
        }

        textarea.field-input {
            resize: none;
            line-height: 1.6;
        }

        .select-wrap {
            position: relative;
        }

        .select-wrap select {
            padding-right: 44px;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
        }

        .select-wrap .chevron {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #b8b0a4;
            pointer-events: none;
        }

        .prefix-wrap {
            position: relative;
        }

        .prefix-wrap input {
            padding-left: 44px;
        }

        .prefix-wrap .prefix {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 700;
            font-size: 15px;
            color: var(--ink-faint);
            user-select: none;
        }

        /* ─── Error inline ─── */
        .field-error {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 6px;
            font-size: 11px;
            font-weight: 600;
            color: var(--ember-deep);
        }

        /* ─── Photo upload ─── */
        .upload-zone {
            position: relative;
            width: 100%;
            height: 220px;
            border-radius: 18px;
            border: 2px dashed var(--mist);
            background: var(--cream);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            overflow: hidden;
            transition: border-color 0.25s, background 0.25s;
        }

        .upload-zone:hover {
            border-color: var(--ember);
            background: rgba(232, 93, 47, 0.04);
        }

        .upload-zone:hover .upload-icon {
            transform: scale(1.1) translateY(-3px);
            color: var(--ember);
        }

        .upload-zone:hover .upload-hint {
            color: var(--ember);
        }

        .upload-icon {
            transition: transform 0.3s, color 0.25s;
            color: #c8c0b4;
            margin-bottom: 12px;
        }

        .upload-text {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-faint);
        }

        .upload-hint {
            font-size: 11px;
            color: #b8b0a4;
            margin-top: 4px;
            transition: color 0.25s;
        }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-zone img#imagePreview {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
        }

        .upload-overlay {
            position: absolute;
            inset: 0;
            background: rgba(26, 22, 18, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .upload-zone.has-image .upload-overlay {
            display: flex;
        }

        .upload-zone.has-image:hover .upload-overlay {
            opacity: 1;
        }

        /* ─── Submit ─── */
        .btn-publish {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 17px;
            background: var(--ink);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(26, 22, 18, 0.18);
        }

        .btn-publish::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--ember) 0%, var(--ember-deep) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-publish:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(26, 22, 18, 0.22);
        }

        .btn-publish:hover::after {
            opacity: 1;
        }

        .btn-publish span,
        .btn-publish i {
            position: relative;
            z-index: 1;
        }

        /* ─── Back link ─── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-faint);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 10px;
            border: 1.5px solid var(--mist);
            background: #fff;
            transition: color 0.2s, border-color 0.2s;
        }

        .back-link:hover {
            color: var(--ember);
            border-color: var(--ember);
        }

        /* ─── Animate in ─── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeUp 0.45s ease both;
        }

        .delay-1 {
            animation-delay: 0.05s;
        }

        .delay-2 {
            animation-delay: 0.12s;
        }

        .delay-3 {
            animation-delay: 0.19s;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
    </style>
</head>

<body>
    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="page-wrap px-4 md:px-8 py-10 pb-20">

        {{-- Header --}}
        <div class="mb-10 animate-in">
            <a href="{{ route('restaurant.items') }}" class="back-link mb-6">
                <i data-feather="arrow-left" class="w-3.5 h-3.5"></i> Menu
            </a>
            <div class="mt-6 flex items-end justify-between">
                <div>
                    <p class="section-eyebrow">Menu Management</p>
                    <h1 class="text-7xl md:text-8xl font-black text-[#1a1612] leading-none">
                        Add New Dish
                    </h1>
                </div>
                <div class="hidden md:block text-[150px] leading-none select-none"
                    style="opacity:0.065; font-family:'Sora'; font-weight:900; color:var(--ink); margin-bottom:-6px;">✦
                </div>
            </div>
        </div>

        <form action="{{ route('restaurant.storeItem') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-card p-8 md:p-10 space-y-10 animate-in delay-1">

                {{-- ── Section 1: Core Info ── --}}
                <div class="space-y-6">
                    <p class="section-eyebrow">Item Info</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Item Name</label>
                            <input type="text" name="name" class="field-input" placeholder="e.g. Spicy Miso Ramen"
                                required>
                            @error('name')
                                <p class="field-error"><i data-feather="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Price</label>
                            <div class="prefix-wrap">
                                <span class="prefix">৳</span>
                                <input type="number" name="price" class="field-input" placeholder="0.00" step="0.01"
                                    required>
                            </div>
                            @error('price')
                                <p class="field-error"><i data-feather="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Category</label>
                            <div class="select-wrap">
                                <select name="category_id" class="field-input" required>
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                                <i data-feather="chevron-down" class="w-4 h-4 chevron"></i>
                            </div>
                            @error('category_id')
                                <p class="field-error"><i data-feather="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Cuisine Type</label>
                            <div class="select-wrap">
                                <select name="cuisine_id" class="field-input" required>
                                    <option value="" disabled selected>Select Cuisine</option>
                                    @foreach($cuisines as $c)
                                        <option value="{{ $c->cuisine_id }}">{{ $c->cuisine_name }}</option>
                                    @endforeach
                                </select>
                                <i data-feather="chevron-down" class="w-4 h-4 chevron"></i>
                            </div>
                            @error('cuisine_id')
                                <p class="field-error"><i data-feather="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── Section 2: Description ── --}}
                <div>
                    <p class="section-eyebrow">Description</p>
                    <textarea name="description" rows="4" class="field-input"
                        placeholder="What makes this dish special? Ingredients, flavors, allergens…"></textarea>
                    @error('description')
                        <p class="field-error"><i data-feather="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Section 3: Photo ── --}}
                <div>
                    <p class="section-eyebrow">Photo</p>
                    <label class="field-label">Item Photo</label>
                    <div class="upload-zone" id="uploadZone">
                        <i data-feather="camera" class="w-10 h-10 upload-icon"></i>
                        <p class="upload-text">Click to Upload Photo</p>
                        <p class="upload-hint">JPG, PNG or WEBP · Max 5MB</p>
                        <input type="file" name="item_image" accept="image/*" required onchange="previewImage(this)">
                        <img id="imagePreview" class="hidden" alt="">
                        <div class="upload-overlay">
                            <i data-feather="refresh-cw" class="w-4 h-4"></i>
                            <span>Change Photo</span>
                        </div>
                    </div>
                </div>

                {{-- ── Submit ── --}}
                <button type="submit" class="btn-publish mt-10">
                    <i data-feather="check-circle" class="w-4 h-4"></i>
                    <span>Publish to Menu</span>
                </button>

            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace({ 'stroke-width': 2 });
        });

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var preview = document.getElementById('imagePreview');
                    var zone = document.getElementById('uploadZone');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    zone.classList.add('has-image');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>