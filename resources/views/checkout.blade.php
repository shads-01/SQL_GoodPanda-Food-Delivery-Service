<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | GoodPanda</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 p-6 md:p-12">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <h1 class="text-3xl font-black mb-8 border-b pb-4 text-orange-500">Checkout</h1>
        
        @if (session('error'))
            <div class="bg-red-100 text-red-600 p-4 rounded-xl mb-6 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.placeOrder', $restaurantId) }}" method="POST">
            @csrf
            
            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
            <input type="hidden" name="discount" value="{{ $discount }}">
            <input type="hidden" name="delivery" value="{{ $delivery }}">
            <input type="hidden" name="total" value="{{ $total }}">
            <input type="hidden" name="offer_id" value="{{ $offerId }}">

            <!-- Order Summary -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2"><i data-feather="shopping-bag" class="w-5 h-5 text-gray-400"></i> Order Summary</h2>
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <ul class="space-y-4 mb-4 border-b border-gray-200 pb-4">
                        @foreach($cartItems as $item)
                        <li class="flex justify-between items-center text-sm">
                            <span class="font-medium text-gray-700"><span class="font-bold text-gray-900 bg-white px-2 py-1 rounded shadow-sm border">{{ $item->quantity }}x</span> &nbsp; {{ $item->item_name }}</span>
                            <span class="font-bold text-gray-900">${{ number_format($item->unit_price * $item->quantity, 2) }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-gray-800">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Delivery Fee</span>
                            <span class="font-bold text-gray-800">${{ number_format($delivery, 2) }}</span>
                        </div>
                        @if($discount > 0)
                        <div class="flex justify-between text-orange-500">
                            <span>Discount</span>
                            <span class="font-bold">-${{ number_format($discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between pt-4 border-t border-gray-200 mt-2 text-xl">
                            <span class="font-black text-gray-800 uppercase tracking-wide">Total</span>
                            <span class="font-black text-orange-500">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Address -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2"><i data-feather="map-pin" class="w-5 h-5 text-gray-400"></i> Delivery Address</h2>
                @if(count($addresses) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($addresses as $address)
                        <label class="flex items-start p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-orange-50/50 transition-colors has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 relative">
                            <input type="radio" name="address_id" value="{{ $address->address_id }}" class="mt-1 text-orange-500 focus:ring-orange-500" required {{ $loop->first ? 'checked' : '' }}>
                            <div class="ml-3">
                                <p class="font-bold text-gray-800 mb-1 tracking-tight">{{ $address->label }}</p>
                                <p class="text-xs text-gray-500 leading-relaxed">{{ $address->address_line }}, <br>{{ $address->city }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-orange-50 text-orange-800 rounded-xl border border-orange-100">
                        <p class="font-bold">No saved addresses found.</p>
                        <p class="text-sm mt-1">Please add an address in your profile before placing an order.</p>
                    </div>
                @endif
            </div>

            <!-- Payment Method -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2"><i data-feather="credit-card" class="w-5 h-5 text-gray-400"></i> Payment Method</h2>
                <select name="payment_method" class="w-full p-4 border border-gray-200 rounded-xl font-medium focus:ring-orange-500 focus:border-orange-500 bg-gray-50 cursor-pointer text-gray-700" required>
                    <option value="" disabled selected>Select a payment method</option>
                    <option value="cash">Cash on Delivery</option>
                    <option value="card">Credit/Debit Card</option>
                    <option value="bkash">bKash</option>
                    <option value="nagad">Nagad</option>
                </select>
            </div>

            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full bg-orange-500 text-white font-black py-4 rounded-xl hover:bg-orange-600 transition-colors shadow-lg shadow-orange-200 disabled:opacity-50 tracking-wider text-lg" {{ count($addresses) == 0 ? 'disabled' : '' }}>
                    Place Order (${{ number_format($total, 2) }})
                </button>
                <a href="{{ route('restaurant.details', $restaurantId) }}" class="block text-center mt-2 text-gray-500 font-bold hover:text-orange-500 transition-colors">
                    Back to Menu
                </a>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>
</body>
</html>
