<div class="card-content">
    <h5 class="card-title">{{ $notification->title }}</h5>
    <p class="grey-text">Diterima: {{ $notification->created_at->format('d M Y, H:i') }}</p>
    <div class="divider" style="margin: 20px 0;"></div>
    <div class="section">
        <p style="line-height: 1.6;">{{ $notification->message }}</p>
    </div>

    @if($notification->link && $notification->link !== '#')
        <div class="card-action" style="padding-top: 20px;">
            <a href="{{ $notification->link }}" class="btn-primary">
                Lihat Detail
                <i class="material-icons right">arrow_forward</i>
            </a>
        </div>
    @endif
</div>
