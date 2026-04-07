{{-- resources/views/components/menu_item_card.blade.php --}}
{{-- Usage: @include('components.menu_item_card', ['item' => $item]) --}}

<div class="menu-item-card" onclick="openItemPopup({{ json_encode([
    'item_id'       => $item->item_id,
    'item_name'     => $item->item_name,
    'item_image'    => $item->item_image ?? null,
    'price'         => $item->price,
    'offer_price'   => $item->offer_price ?? null,
    'cuisine_names' => $item->cuisine_names ?? null,
    'description'   => $item->description ?? null,
]) }})" style="cursor:pointer;">
    <div class="mic-image">
        @if(!empty($item->item_image) && str_starts_with($item->item_image,'http'))
        <img src="{{ $item->item_image }}" alt="{{ $item->item_name }}">
        @else
        <div class="mic-image-placeholder">🍽️</div>
        @endif
        @if(!empty($item->offer_price))
        <span class="mic-badge">OFFER</span>
        @endif
    </div>
    <div class="mic-body">
        <div class="mic-name">{{ $item->item_name }}</div>
        @if(!empty($item->cuisine_names))
        <div class="mic-cuisine">{{ $item->cuisine_names }}</div>
        @endif
        <div class="mic-price">
            @if(!empty($item->offer_price))
            <span class="mic-original">৳{{ number_format($item->price,0) }}</span>
            <span class="mic-discounted">৳{{ number_format($item->offer_price,0) }}</span>
            @else
            <span class="mic-regular">৳{{ number_format($item->price,0) }}</span>
            @endif
        </div>
    </div>
</div>

<style>
    .menu-item-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        transition: transform 0.18s, box-shadow 0.18s;
        display: flex;
        flex-direction: column;
    }

    .menu-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.11);
    }

    .mic-image {
        position: relative;
        height: 140px;
        background: #FFF7ED;
        overflow: hidden;
    }

    .mic-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mic-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }

    .mic-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #F97316;
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 20px;
        letter-spacing: 0.04em;
    }

    .mic-body {
        padding: 0.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .mic-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1C1917;
        line-height: 1.3;
    }

    .mic-cuisine {
        font-size: 0.72rem;
        color: #A8A29E;
    }

    .mic-price {
        margin-top: auto;
        padding-top: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .mic-original {
        text-decoration: line-through;
        color: #A8A29E;
        font-size: 0.8rem;
    }

    .mic-discounted {
        color: #F97316;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .mic-regular {
        color: #1C1917;
        font-weight: 700;
        font-size: 0.95rem;
    }
</style>