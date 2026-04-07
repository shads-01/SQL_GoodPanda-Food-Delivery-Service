<!DOCTYPE html>
<html>

<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    @include('restaurant.navbar')

    <div class="max-w-2xl mx-auto p-8 bg-white mt-10 rounded shadow">

        <h2 class="text-xl font-bold mb-4">Add Item</h2>

        <form action="{{ route('restaurant.storeItem') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <input name="name" class="w-full border p-3 rounded" placeholder="Item Name">

            <input name="price" class="w-full border p-3 rounded" placeholder="Price">

            <!-- <select name="category" class="w-full border p-3 rounded">
        <option>Appetizer</option>
        <option>Main Course</option>
        <option>Dessert</option>
        <option>Beverages</option>
    </select> -->
            <select name="category_id" class="w-full border p-3 rounded">
                <option value="" disabled selected>Select a category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}">
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>

            <textarea name="description" class="w-full border p-3 rounded" placeholder="Description"></textarea>


            <!-- Item image upload option -->
            <div class="text-left mt-2 pb-2 border-b border-orange-100">
                <label class="text-sm text-gray-600 block mb-1">Item Image</label>
                <div class="relative flex items-center justify-center w-full">
                    <label for="item-image-input" id="dropzone-label"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-orange-300 cursor-pointer bg-orange-50/70 hover:bg-orange-100 hover:border-orange-400 transition-all overflow-hidden relative">
                        <div id="dropzone-text" class="flex flex-col items-center justify-center pt-4 pb-4">
                            <i data-feather="image" class="w-8 h-8 mb-2 text-orange-400"></i>
                            <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-orange-500">Click to
                                    pload</span></p>
                            <p class="text-[6px] text-gray-400">PNG, JPG or JPEG (MAX. 2MB)</p>
                        </div>


                        <input id="item-image-input" type="file" name="item_image" class="hidden" accept="image/*" />
                    </label>
                </div>
                <p id="file-name-display" class="mt-2 text-xs text-center text-gray-500 hidden"></p>
            </div>

            <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded">
                Save
            </button>
        </form>

    </div>

    <script>
        const fileInput = document.getElementById('item-image-input');
        const dropzoneText = document.getElementById('dropzone-text');
        const fileNameDisplay = document.getElementById('file-name-display');

        if (fileInput) {
            fileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    // Display the file name below
                    fileNameDisplay.textContent = `Selected: ${file.name}`;
                    fileNameDisplay.classList.remove('hidden');
                    dropzoneText.classList.add('hidden');
                } else {
                    // Reset if no file is selected
                    fileNameDisplay.textContent = '';
                    fileNameDisplay.classList.add('hidden');
                    dropzoneText.classList.remove('hidden');
                }
            });
        }
    </script>
</body>

</html>