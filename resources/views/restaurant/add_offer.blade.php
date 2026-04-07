<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="max-w-2xl mx-auto p-8 bg-white mt-10 rounded shadow">

<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

<div class="max-w-3xl mx-auto p-8 bg-white mt-10 rounded shadow">

    <h2 class="text-xl font-bold mb-6">Create New Offer</h2>

    @if ($errors->any())
        <div class="bg-red-50 text-red-500 p-4 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('restaurant.store_offer') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Offer Title -->
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Offer Title</label>
            <input name="offer_title" type="text" class="w-full border p-3 rounded bg-gray-50 focus:bg-white" placeholder="e.g., Summer Special Discount" required>
        </div>

        <!-- Target Configuration -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Applies To (Target)</label>
                <select name="target_type" id="targetTypeSelect" class="w-full border p-3 rounded bg-gray-50 focus:bg-white" required>
                    <option value="item">Specific Item</option>
                    <option value="category">Menu Category</option>
                    <option value="restaurant">Entire Restaurant</option>
                </select>
            </div>

            <!-- Item Dropdown -->
            <div id="targetItemContainer">
                <label class="block font-semibold mb-1 text-gray-700">Select Item</label>
                <select name="target_item_id" id="targetItemSelect" class="w-full border p-3 rounded bg-gray-50 focus:bg-white">
                    <option value="">-- Choose Item --</option>
                    @foreach($items as $item)
                        <option value="{{ $item->item_id }}">{{ $item->item_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Dropdown -->
            <div id="targetCategoryContainer" class="hidden">
                <label class="block font-semibold mb-1 text-gray-700">Select Category</label>
                <select name="target_category_id" id="targetCategorySelect" class="w-full border p-3 rounded bg-gray-50 focus:bg-white">
                    <option value="">-- Choose Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Discount Configuration -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-100 pt-5">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Discount Type</label>
                <select name="discount_type" id="discountTypeSelect" class="w-full border p-3 rounded bg-gray-50 focus:bg-white" required>
                    <option value="percentage">Percentage (%)</option>
                    <option value="flat">Flat Amount ($)</option>
                    <option value="free_delivery">Free Delivery</option>
                </select>
            </div>

            <div id="discountValueContainer">
                <label class="block font-semibold mb-1 text-gray-700">Discount Value</label>
                <input name="discount_value" id="discountValueInput" type="number" step="0.01" min="0.01" class="w-full border p-3 rounded bg-gray-50 focus:bg-white" placeholder="e.g., 15 or 5.00">
            </div>
        </div>

        <!-- Min Order & Dates -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-100 pt-5">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Min Order Amount <span class="font-normal text-gray-400 text-sm">(Optional)</span></label>
                <input name="min_order_amount" type="number" step="0.01" min="1" class="w-full border p-3 rounded bg-gray-50 focus:bg-white" placeholder="e.g., 50.00">
            </div>
            
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Start Date & Time</label>
                <input name="start_date" type="datetime-local" class="w-full border p-3 rounded bg-gray-50 focus:bg-white" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-gray-700">End Date & Time</label>
                <input name="end_date" type="datetime-local" class="w-full border p-3 rounded bg-gray-50 focus:bg-white" required>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 font-bold text-white px-6 py-4 rounded-xl transition-colors shadow-lg shadow-orange-200">
                Create Offer
            </button>
        </div>

    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const targetTypeSelect = document.getElementById('targetTypeSelect');
        const itemContainer = document.getElementById('targetItemContainer');
        const categoryContainer = document.getElementById('targetCategoryContainer');
        
        const discountTypeSelect = document.getElementById('discountTypeSelect');
        const discountValueContainer = document.getElementById('discountValueContainer');
        const discountValueInput = document.getElementById('discountValueInput');

        // Target Logic
        targetTypeSelect.addEventListener('change', function() {
            itemContainer.classList.add('hidden');
            categoryContainer.classList.add('hidden');
            
            if (this.value === 'item') {
                itemContainer.classList.remove('hidden');
            } else if (this.value === 'category') {
                categoryContainer.classList.remove('hidden');
            }
        });

        // Discount Logic
        discountTypeSelect.addEventListener('change', function() {
            if (this.value === 'free_delivery') {
                discountValueContainer.classList.add('hidden');
                discountValueInput.value = '';
                discountValueInput.required = false;
            } else {
                discountValueContainer.classList.remove('hidden');
                discountValueInput.required = true;
                if(this.value === 'percentage') {
                    discountValueInput.max = 100;
                    discountValueInput.placeholder = 'e.g., 20 (%)';
                } else {
                    discountValueInput.removeAttribute('max');
                    discountValueInput.placeholder = 'e.g., 5.00 ($)';
                }
            }
        });
        
        // Trigger initial state
        discountTypeSelect.dispatchEvent(new Event('change'));
    });
</script>

</body>
</html>