<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item | {{ $restaurant->name ?? 'Restaurant' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-sora {
            font-family: 'Sora', sans-serif;
        }

        /* Fallback for browsers that don't support tailwind's appearance-none */
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
    </style>
</head>

<body class="bg-[#FAFAF9] text-gray-800">

    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="p-4 md:p-8 max-w-4xl mx-auto">

        <div class="mb-10">
            <a href="{{ route('restaurant.items') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-orange-600 mb-4 transition-colors bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                <i data-feather="arrow-left" class="w-3.5 h-3.5"></i> Back to Menu
            </a>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight font-sora">
                Add New Dish
            </h2>
            <p class="text-gray-500 mt-2 font-medium">Create a delicious new addition to your menu.</p>
        </div>

        <form action="{{ route('restaurant.storeItem') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-10 space-y-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Item Name</label>
                        <input type="text" name="name" class="w-full px-4 py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all placeholder-gray-400" placeholder="e.g. Spicy Miso Ramen" required>
                        @error('name')<p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1"><i data-feather="alert-circle" class="w-3 h-3"></i>{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Price (৳)</label>
                        <div class="relative">
                            <input type="number" name="price" class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all" placeholder="0.00" step="0.01" required>
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold select-none text-base">৳</span>
                        </div>
                        @error('price')<p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1"><i data-feather="alert-circle" class="w-3 h-3"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Category</label>
                        <div class="relative">
                            <select name="category_id" class="w-full pl-4 pr-12 py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all appearance-none cursor-pointer" required>
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                            <i data-feather="chevron-down" class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                        @error('category_id')<p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1"><i data-feather="alert-circle" class="w-3 h-3"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Cuisine Type</label>
                        <div class="relative">
                            <select name="cuisine_id" class="w-full pl-4 pr-12 py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all appearance-none cursor-pointer" required>
                                <option value="" disabled selected>Select Cuisine</option>
                                @foreach($cuisines as $c)
                                <option value="{{ $c->cuisine_id }}">{{ $c->cuisine_name }}</option>
                                @endforeach
                            </select>
                            <i data-feather="chevron-down" class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                        @error('cuisine_id')<p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1"><i data-feather="alert-circle" class="w-3 h-3"></i>{{ $message }}</p>@enderror
                    </div>

                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all resize-none placeholder-gray-400" placeholder="What makes this dish special? Add ingredients, flavors, and allergens..."></textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1"><i data-feather="alert-circle" class="w-3 h-3"></i>{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Item Photo</label>
                    <div class="w-full h-48 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 group hover:bg-orange-50 hover:border-orange-300 hover:text-orange-500 transition-all relative overflow-hidden cursor-pointer">
                        <i data-feather="image" class="w-10 h-10 mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="text-xs font-bold uppercase tracking-widest">Click to Upload Photo</span>
                        <input type="file" name="item_image" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" onchange="previewImage(this)" required>
                        <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover hidden pointer-events-none">
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100">
                    <button type="submit" class="w-full bg-orange-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-orange-500/30 hover:bg-orange-600 hover:shadow-orange-500/50 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                        <i data-feather="check-circle" class="w-5 h-5"></i> Publish to Menu
                    </button>
                </div>

            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace({
                'stroke-width': 2.5
            });
        });

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>