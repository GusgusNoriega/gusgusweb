<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    /**
     * Estados permitidos para una cotización.
     *
     * Importante: debe mantenerse alineado con el enum en la migración.
     */
    public const STATUSES = ['draft', 'sent', 'accepted', 'rejected', 'expired'];

    protected $table = 'quotes';

    protected $fillable = [
        'quote_number',
        'user_id',
        'created_by',
        'title',
        'description',
        'currency_id',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_amount',
        'total',
        'status',
        'valid_until',
        'estimated_start_date',
        'notes',
        'terms_conditions',
        'client_name',
        'client_ruc',
        'client_email',
        'client_phone',
        'client_address',
        'custom_background_image_id',
        'custom_last_page_image_id',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'valid_until' => 'date',
        'estimated_start_date' => 'date',
    ];

    /**
     * Boot method for the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            if (empty($quote->quote_number)) {
                $quote->quote_number = self::generateQuoteNumber();
            }
        });
    }

    /**
     * Generate a unique quote number
     */
    public static function generateQuoteNumber(): string
    {
        $prefix = 'COT';
        $year = date('Y');
        $month = date('m');
        $yearMonth = $year . $month;
        
        // Buscar la última cotización del año/mes actual con el formato correcto
        $lastQuote = self::withTrashed()
            ->where('quote_number', 'like', "{$prefix}-{$yearMonth}-%")
            ->orderByRaw('CAST(SUBSTRING(quote_number, -5) AS UNSIGNED) DESC')
            ->first();

        $sequence = 1;
        
        if ($lastQuote) {
            // Extraer la secuencia del número de cotización
            $parts = explode('-', $lastQuote->quote_number);
            if (count($parts) >= 3) {
                $lastSequence = (int) end($parts);
                $sequence = $lastSequence + 1;
            }
        }
        
        // Asegurar unicidad con un bucle de reintento
        $maxAttempts = 10;
        $attempt = 0;
        
        do {
            $quoteNumber = sprintf('%s-%s-%05d', $prefix, $yearMonth, $sequence);
            $exists = self::withTrashed()->where('quote_number', $quoteNumber)->exists();
            
            if (!$exists) {
                return $quoteNumber;
            }
            
            $sequence++;
            $attempt++;
        } while ($attempt < $maxAttempts);
        
        // Si se agotan los intentos, usar timestamp como fallback para garantizar unicidad
        return sprintf('%s-%s-%05d-%d', $prefix, $yearMonth, $sequence, time());
    }

    /**
     * Calculate totals based on items
     */
    public function calculateTotals(): self
    {
        // Asegurar que items esté cargado
        if (!$this->relationLoaded('items')) {
            $this->load('items');
        }

        $subtotal = $this->items->sum(function ($item) {
            return (float) ($item->total ?? 0);
        });

        // Asegurar valores numéricos para evitar errores de cálculo
        $discountAmount = (float) ($this->discount_amount ?? 0);
        $taxRate = (float) ($this->tax_rate ?? 0);

        $this->subtotal = $subtotal;
        $this->tax_amount = ($subtotal - $discountAmount) * ($taxRate / 100);
        $this->total = $subtotal - $discountAmount + $this->tax_amount;

        return $this;
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the client/user for this quote
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who created this quote
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the currency for this quote
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Get all items for this quote
     */
    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class, 'quote_id')->orderBy('sort_order');
    }

    /**
     * Get the custom background image
     */
    public function customBackgroundImage(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'custom_background_image_id');
    }

    /**
     * Get the custom last page image
     */
    public function customLastPageImage(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'custom_last_page_image_id');
    }

    // ==================== ACCESSORS ====================

    /**
     * Get the client name (from user or custom field)
     */
    public function getClientDisplayNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->client_name ?? 'Sin cliente';
    }

    /**
     * Get the client email (from user or custom field)
     */
    public function getClientDisplayEmailAttribute(): ?string
    {
        if ($this->user) {
            return $this->user->email;
        }
        return $this->client_email;
    }

    // ==================== SCOPES ====================

    /**
     * Scope for draft quotes
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope for sent quotes
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for accepted quotes
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope for expired quotes
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
            ->orWhere(function ($q) {
                $q->whereNotNull('valid_until')
                    ->where('valid_until', '<', now())
                    ->whereNotIn('status', ['accepted', 'rejected']);
            });
    }
}
