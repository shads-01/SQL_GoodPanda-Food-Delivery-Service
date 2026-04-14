<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Offer | {{ $restaurant->name ?? 'Restaurant' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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
            --ink-ghost: rgba(26,22,18,0.06);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            min-height: 100vh;
        }

        .font-display { font-family: 'Playfair Display', serif; }

        .page-header-title {
            font-size: 1.5rem;
            font-family: 'Sora', sans-serif;
        }

        @media (min-width: 768px) {
            .page-header-title {
                font-size: 1.5rem;
            }
        }

        /* ─── Background texture ─── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(ellipse 80% 60% at 10% -10%, rgba(232,93,47,0.06) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 95% 90%, rgba(201,151,58,0.06) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .page-wrap { 
            position: relative; 
            z-index: 1; 
            width: 60%; 
            margin: 0 auto; 
        }

        /* ─── Card ─── */
        .form-card {
            background: #fff;
            border: 1px solid var(--mist);
            border-radius: 24px;
            box-shadow: 0 2px 4px rgba(26,22,18,0.04), 0 12px 40px rgba(26,22,18,0.06);
        }

        /* ─── Section label ─── */
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
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

        /* ─── Inputs ─── */
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
            -webkit-appearance: none;
        }
        .field-input::placeholder { color: #b8b0a4; }
        .field-input:focus {
            border-color: var(--ember);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(232,93,47,0.1);
        }

        .select-wrap { position: relative; }
        .select-wrap select { padding-right: 44px; cursor: pointer; }
        .select-wrap .chevron {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #b8b0a4;
            pointer-events: none;
        }

        .prefix-wrap { position: relative; }
        .prefix-wrap input { padding-left: 44px; }
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

        /* ─── Submit button ─── */
        .btn-launch {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 16px;
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
            box-shadow: 0 4px 20px rgba(26,22,18,0.18);
        }
        .btn-launch::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--ember) 0%, var(--ember-deep) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn-launch:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(26,22,18,0.22); }
        .btn-launch:hover::after { opacity: 1; }
        .btn-launch span, .btn-launch i { position: relative; z-index: 1; }

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
        .back-link:hover { color: var(--ember); border-color: var(--ember); }

        /* ─── Error block ─── */
        .error-block {
            background: #fff5f3;
            border: 1px solid #fad5cc;
            border-radius: 16px;
            padding: 16px 20px;
        }

        /* ─── Discount type pills ─── */
        .type-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .type-pill {
            display: none;
        }
        .type-pill + label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            border: 1.5px solid var(--mist);
            background: var(--cream);
            color: var(--ink-faint);
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
        }
        .type-pill:checked + label {
            background: var(--ink);
            color: #fff;
            border-color: var(--ink);
        }

        /* ─── Disabled overlay ─── */
        .field-disabled { opacity: 0.38; pointer-events: none; }

        /* ─── Animate in ─── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeUp 0.45s ease both; }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.12s; }
        .delay-3 { animation-delay: 0.19s; }
        .delay-4 { animation-delay: 0.26s; }
        .delay-5 { animation-delay: 0.33s; }

        select { appearance: none; -webkit-appearance: none; -moz-appearance: none; }
    </style>
</head>

<body>
    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="page-wrap max-w-3xl mx-auto px-4 md:px-8 py-10 pb-20">

        {{-- Header --}}
        <div class="mb-10 animate-in">
            <a href="{{ route('restaurant.items') }}" class="back-link mb-6">
                <i data-feather="arrow-left" class="w-3.5 h-3.5"></i> Menu
            </a>
            <div class="mt-6 flex items-end justify-between">
                <div>
                    <p class="section-eyebrow">Promotions</p>
                    <h1 class="font-black text-[#1a1612] leading-none">
                        Create New Offer
                    </h1>
                </div>
                <div class="hidden md:block text-[120px] leading-none select-none" style="opacity:0.07; font-family:'Playfair Display',serif; font-weight:900; color:var(--ink); margin-bottom:-8px;">%</div>
            </div>
        </div>

        {{-- Alerts & Errors --}}
        @if(session('error'))
        <div class="error-block mb-8 animate-in delay-1">
            <div class="flex items-center gap-2 text-[#c44a20] font-semibold text-sm mb-1">
                <i data-feather="alert-octagon" class="w-4 h-4"></i> Error
            </div>
            <p class="text-xs text-[#c44a20]/80 font-medium">{{ session('error') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="error-block mb-8 animate-in delay-1">
            <div class="flex items-center gap-2 text-[#c44a20] font-semibold text-sm mb-2">
                <i data-feather="alert-circle" class="w-4 h-4"></i> Please fix the following
            </div>
            <ul class="space-y-1 text-xs text-[#c44a20]/80 font-medium list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('restaurant.store_offer') }}" method="POST">
            @csrf
            <div class="form-card p-8 md:p-10 space-y-10 animate-in delay-2">

                {{-- ── Section 1: Basics ── --}}
                <div class="space-y-6">
                    <p class="section-eyebrow">Offer Details</p>

                    <div>
                        <label class="field-label">Offer Title</label>
                        <input type="text" name="offer_title" value="{{ old('offer_title') }}"
                            class="field-input" placeholder="e.g. Weekend Feast Discount" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Discount Type</label>
                            <div class="select-wrap">
                                <select name="discount_type" id="discount_type"
                                    class="field-input" required onchange="toggleDiscountValue()">
                                    <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="flat" {{ old('discount_type') == 'flat' ? 'selected' : '' }}>Flat Amount (৳)</option>
                                    <option value="free_delivery" {{ old('discount_type') == 'free_delivery' ? 'selected' : '' }}>Free Delivery</option>
                                </select>
                                <i data-feather="chevron-down" class="w-4 h-4 chevron"></i>
                            </div>
                        </div>

                        <div id="discount_value_container">
                            <label class="field-label">Discount Value</label>
                            <input type="number" name="discount_value" id="discount_value"
                                value="{{ old('discount_value') }}"
                                class="field-input" placeholder="0" step="0.01">
                        </div>
                    </div>
                </div>

                {{-- ── Section 2: Target ── --}}
                <div class="space-y-6">
                    <p class="section-eyebrow">Offer Scope</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Target Type</label>
                            <div class="select-wrap">
                                <select name="target_type" id="target_type"
                                    class="field-input" required onchange="toggleTargetFields()">
                                    <option value="restaurant" {{ old('target_type') == 'restaurant' ? 'selected' : '' }}>Entire Restaurant</option>
                                    <option value="category" {{ old('target_type') == 'category' ? 'selected' : '' }}>Specific Category</option>
                                    <option value="item" {{ old('target_type') == 'item' ? 'selected' : '' }}>Specific Item</option>
                                </select>
                                <i data-feather="chevron-down" class="w-4 h-4 chevron"></i>
                            </div>
                        </div>

                        <div id="target_category_container" class="hidden">
                            <label class="field-label">Category</label>
                            <div class="select-wrap">
                                <select name="target_category_id" class="field-input">
                                    <option value="" disabled selected>Choose a category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->category_id }}" {{ old('target_category_id') == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                                <i data-feather="chevron-down" class="w-4 h-4 chevron"></i>
                            </div>
                        </div>

                        <div id="target_item_container" class="hidden">
                            <label class="field-label">Item</label>
                            <div class="select-wrap">
                                <select name="target_item_id" class="field-input">
                                    <option value="" disabled selected>Choose an item</option>
                                    @foreach($items as $item)
                                    <option value="{{ $item->item_id }}" {{ old('target_item_id') == $item->item_id ? 'selected' : '' }}>{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                                <i data-feather="chevron-down" class="w-4 h-4 chevron"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="field-label">Min. Order Amount <span class="normal-case font-normal tracking-normal text-[#b8b0a4]">— optional</span></label>
                        <div class="prefix-wrap">
                            <span class="prefix">৳</span>
                            <input type="number" name="min_order_amount"
                                value="{{ old('min_order_amount') }}"
                                class="field-input" placeholder="0.00" step="0.01">
                        </div>
                    </div>
                </div>

                {{-- ── Section 3: Validity ── --}}
                <div class="space-y-6">
                    <p class="section-eyebrow">Active Period</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Starts</label>
                            <input type="datetime-local" name="start_date"
                                value="{{ old('start_date') }}"
                                class="field-input" required>
                        </div>
                        <div>
                            <label class="field-label">Ends</label>
                            <input type="datetime-local" name="end_date"
                                value="{{ old('end_date') }}"
                                class="field-input" required>
                        </div>
                    </div>
                </div>

                {{-- ── Submit ── --}}
                <button type="submit" class="btn-launch mt-12">
                    <i data-feather="zap" class="w-4 h-4"></i>
                    <span>Launch Offer</span>
                </button>

            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace({ 'stroke-width': 2 });
            toggleDiscountValue();
            toggleTargetFields();
        });

        function toggleDiscountValue() {
            const type = document.getElementById('discount_type').value;
            const container = document.getElementById('discount_value_container');
            const input = document.getElementById('discount_value');
            if (type === 'free_delivery') {
                container.classList.add('field-disabled');
                input.disabled = true;
                input.value = '';
                input.required = false;
            } else {
                container.classList.remove('field-disabled');
                input.disabled = false;
                input.required = true;
            }
        }

        function toggleTargetFields() {
            const type = document.getElementById('target_type').value;
            document.getElementById('target_category_container').classList.add('hidden');
            document.getElementById('target_item_container').classList.add('hidden');
            if (type === 'category') {
                document.getElementById('target_category_container').classList.remove('hidden');
            } else if (type === 'item') {
                document.getElementById('target_item_container').classList.remove('hidden');
            }
        }
    </script>
</body>
</html>