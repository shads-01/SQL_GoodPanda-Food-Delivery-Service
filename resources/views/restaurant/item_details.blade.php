<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Item | {{ $item->item_name }}</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-sora {
            font-family: 'Sora', sans-serif;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1.5px solid #E7E5E4;
            border-radius: 1rem;
            outline: none;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .form-input:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }
    </style>
</head>

<body class="bg-[#FAFAF9]">

    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="p-8 max-w-4xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('restaurant.items') }}"
                class="text-xs font-bold text-gray-400 hover:text-orange-500 flex items-center gap-1 mb-4 transition-colors">
                <i data-feather="arrow-left" class="w-3 h-3"></i> Back to Inventory
            </a>
            <h2 class="text-4xl font-black text-gray-900 tracking-tight font-sora">
                Edit Menu Item
            </h2>
            <p class="text-gray-400 mt-2 font-medium">Refine the details and pricing for this dish.</p>
        </div>

        <form action="{{ route('restaurant.updateItem', $item->item_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-4xl shadow-sm border border-gray-100 p-8 md:p-10 space-y-6">
                <div class="flex justify-center md:flex-row gap-6 items-start">
                    <div
                        class="w-24 h-24 flex-shrink-0 bg-gray-50 rounded-2xl border-2 border-gray-50 flex items-center justify-center relative overflow-hidden shadow-inner group">
                        <img src="{{ $item->item_image }}" alt="{{ $item->item_name }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <i data-feather="image" class="w-5 h-5 text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-1.5 ml-1">Item
                            Name</label>
                        <input type="text" name="name" value="{{ $item->item_name }}" class="form-input" required>
                        @error('name')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-1.5 ml-1">Price
                            (৳)</label>
                        <input type="number" name="price" value="{{ $item->price }}" class="form-input" step="0.01"
                            required>
                        @error('price')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-1.5 ml-1">Category</label>
                        <select name="category_id" class="form-input bg-white" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}" {{ $cat->category_id == $item->category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-1.5 ml-1">Description</label>
                    <textarea name="description" rows="5"
                        class="form-input resize-none leading-relaxed">{{ $item->description }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="pt-4 flex flex-col md:flex-row gap-4">
                    <button type="submit"
                        class="flex-1 rounded-2xl bg-orange-500 text-white cursor-pointer font-black py-4 shadow-xl shadow-orange-100 hover:bg-orange-600 transition-all transform active:scale-[0.98]">
                        Save Changes
                    </button>
                    <a href="{{ route('restaurant.items') }}"
                        class="flex rounded-2xl items-center justify-center px-8 py-4 md:py-0 border border-gray-100 text-sm font-bold text-gray-400 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>
</body>

</html>