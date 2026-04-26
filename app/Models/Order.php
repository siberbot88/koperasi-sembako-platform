<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    /**
     * Order statuses flow:
     * pending -> processing -> ready -> completed
     * pending -> processing -> shipped -> completed
     * pending|processing -> cancelled
     */
    const STATUS_PENDING    = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_READY      = 'ready';       // pickup
    const STATUS_SHIPPED    = 'shipped';      // delivery
    const STATUS_COMPLETED  = 'completed';
    const STATUS_CANCELLED  = 'cancelled';

    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PROCESSING,
        self::STATUS_READY,
        self::STATUS_SHIPPED,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    /**
     * Courier catalog: prefix, resi format, base shipping rate (Rp)
     */
    const COURIERS = [
        'JNE'          => ['prefix' => 'JNE', 'length' => 12, 'chars' => 'ALPHANUM', 'base_rate' => 15000, 'logo' => 'https://www.google.com/s2/favicons?domain=jne.co.id&sz=128'],
        'J&T'          => ['prefix' => 'JP',  'length' => 12, 'chars' => 'NUM',      'base_rate' => 12000, 'logo' => 'https://www.google.com/s2/favicons?domain=jet.co.id&sz=128'],
        'SiCepat'      => ['prefix' => 'SC',  'length' => 12, 'chars' => 'ALPHANUM', 'base_rate' => 11000, 'logo' => 'https://www.google.com/s2/favicons?domain=sicepat.com&sz=128'],
        'Anteraja'     => ['prefix' => 'AN',  'length' => 12, 'chars' => 'ALPHANUM', 'base_rate' => 13000, 'logo' => 'https://www.google.com/s2/favicons?domain=anteraja.id&sz=128'],
        'SAP'          => ['prefix' => 'SAP', 'length' => 12, 'chars' => 'NUM',      'base_rate' => 14000, 'logo' => 'https://www.google.com/s2/favicons?domain=sap-express.id&sz=128'],
        'Pos Indonesia'=> ['prefix' => 'POS', 'length' => 13, 'chars' => 'NUM',      'base_rate' => 9000,  'logo' => 'https://www.google.com/s2/favicons?domain=posindonesia.co.id&sz=128'],
        'GoSend'       => ['prefix' => 'GOS', 'length' => 10, 'chars' => 'NUM',      'base_rate' => 18000, 'logo' => 'https://www.google.com/s2/favicons?domain=gojek.com&sz=128'],
        'GrabExpress'  => ['prefix' => 'GRB', 'length' => 10, 'chars' => 'NUM',      'base_rate' => 17000, 'logo' => 'https://www.google.com/s2/favicons?domain=grab.com&sz=128'],
        'Lalamove'     => ['prefix' => 'LLM', 'length' => 10, 'chars' => 'NUM',      'base_rate' => 20000, 'logo' => 'https://www.google.com/s2/favicons?domain=lalamove.com&sz=128'],
        'Ninja Xpress' => ['prefix' => 'NX',  'length' => 12, 'chars' => 'ALPHANUM', 'base_rate' => 11000, 'logo' => 'https://www.google.com/s2/favicons?domain=ninjaxpress.co&sz=128'],
        'Lion Parcel'  => ['prefix' => 'LP',  'length' => 12, 'chars' => 'ALPHANUM', 'base_rate' => 13000, 'logo' => 'https://www.google.com/s2/favicons?domain=lionparcel.com&sz=128'],
        'Wahana'       => ['prefix' => 'WHN', 'length' => 12, 'chars' => 'NUM',      'base_rate' => 10000, 'logo' => 'https://www.google.com/s2/favicons?domain=wahana.com&sz=128'],
    ];

    protected $fillable = [
        'order_number',
        'user_id',
        'store_id',
        'items',             // EMBEDDED snapshot: array of product snapshots
        'shipping_address',  // EMBEDDED snapshot of address at checkout time
        'fulfillment_type',  // pickup | delivery
        'status',
        'subtotal',
        'discount_amount',
        'shipping_cost',
        'total_amount',
        'coupon_snapshot',   // EMBEDDED: { code, type, value }
        'notes',
        'shipment',          // EMBEDDED: { courier, tracking_number, estimated_delivery, tracking_events }
        'cancellation',      // EMBEDDED: { requested_at, reason, status, rejected_reason }
        'status_history',    // EMBEDDED: [{ status, changed_at, note }]
        'paid_at',
        'completed_at',
        'cancelled_at',
        'cancel_reason',
        'points_awarded',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'shipping_address' => 'array',
            'coupon_snapshot' => 'array',
            'shipment' => 'array',
            'cancellation' => 'array',
            'status_history' => 'array',
            'subtotal' => 'integer',
            'discount_amount' => 'integer',
            'shipping_cost' => 'integer',
            'total_amount' => 'integer',
            'paid_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'points_awarded' => 'integer',
        ];
    }

    // ── Relationships (references) ──

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    // ── Scopes ──

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeForSeller($query, string $storeId)
    {
        return $query->where('store_id', $storeId);
    }

    // ── Helpers ──

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }

    public function pushStatusHistory(string $newStatus, ?string $note = null): void
    {
        $history = $this->status_history ?? [];
        $history[] = [
            'status' => $newStatus,
            'changed_at' => now()->toISOString(),
            'note' => $note,
        ];

        $this->status_history = $history;
        $this->status = $newStatus;
    }

    /**
     * Generate a unique order number: KS-YYYYMMDD-XXXXX
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'KS-' . now()->format('Ymd') . '-';
        $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

        return $prefix . $random;
    }
}
