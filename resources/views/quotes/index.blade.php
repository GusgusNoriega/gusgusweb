@extends('layouts.app')

@section('title', 'Cotizaciones')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-[var(--c-text)]">Cotizaciones</h1>
      <p class="text-[var(--c-muted)] mt-1">Gestiona todas las cotizaciones del sistema</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('quotes.settings') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[var(--c-elev)] text-[var(--c-text)] border border-[var(--c-border)] rounded-xl hover:bg-[var(--c-surface)] transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Configuración
      </a>
      <button id="btn-create-quote" class="inline-flex items-center gap-2 px-4 py-2 bg-[var(--c-primary)] text-[var(--c-primary-ink)] rounded-xl hover:opacity-95 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Nueva Cotización
      </button>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
    <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-[var(--c-muted)]">Total</p>
          <p id="stat-total" class="text-2xl font-bold text-[var(--c-text)]">0</p>
        </div>
        <div class="size-10 rounded-xl bg-[var(--c-elev)] flex items-center justify-center">
          <svg class="w-5 h-5 text-[var(--c-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-[var(--c-muted)]">Borradores</p>
          <p id="stat-draft" class="text-2xl font-bold text-yellow-500">0</p>
        </div>
        <div class="size-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
          <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-[var(--c-muted)]">Enviadas</p>
          <p id="stat-sent" class="text-2xl font-bold text-blue-500">0</p>
        </div>
        <div class="size-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
          <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-[var(--c-muted)]">Aceptadas</p>
          <p id="stat-accepted" class="text-2xl font-bold text-green-500">0</p>
        </div>
        <div class="size-10 rounded-xl bg-green-500/10 flex items-center justify-center">
          <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-[var(--c-muted)]">Rechazadas</p>
          <p id="stat-rejected" class="text-2xl font-bold text-red-500">0</p>
        </div>
        <div class="size-10 rounded-xl bg-red-500/10 flex items-center justify-center">
          <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters & Table -->
  <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] p-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
      <h2 class="text-lg font-semibold text-[var(--c-text)]">Listado de Cotizaciones</h2>
      <div class="flex flex-wrap items-center gap-2">
        <input type="text" id="search-quotes" placeholder="Buscar..." class="px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg text-sm w-48">
        <select id="filter-status" class="px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg text-sm">
          <option value="">Todos los estados</option>
          <option value="draft">Borrador</option>
          <option value="sent">Enviada</option>
          <option value="accepted">Aceptada</option>
          <option value="rejected">Rechazada</option>
          <option value="expired">Expirada</option>
        </select>
        <button id="btn-refresh-quotes" class="p-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg hover:bg-[var(--c-surface)] transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Quotes Table -->
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-[var(--c-border)]">
            <th class="text-left py-3 px-4 text-sm font-medium text-[var(--c-muted)]">Número</th>
            <th class="text-left py-3 px-4 text-sm font-medium text-[var(--c-muted)]">Título</th>
            <th class="text-left py-3 px-4 text-sm font-medium text-[var(--c-muted)]">Cliente</th>
            <th class="text-right py-3 px-4 text-sm font-medium text-[var(--c-muted)]">Total</th>
            <th class="text-center py-3 px-4 text-sm font-medium text-[var(--c-muted)]">Estado</th>
            <th class="text-left py-3 px-4 text-sm font-medium text-[var(--c-muted)]">Fecha</th>
            <th class="text-center py-3 px-4 text-sm font-medium text-[var(--c-muted)]">Acciones</th>
          </tr>
        </thead>
        <tbody id="quotes-list">
          <!-- Quotes will be loaded here -->
        </tbody>
      </table>
    </div>

    <!-- Empty State -->
    <div id="quotes-empty" class="hidden text-center py-12">
      <svg class="w-16 h-16 mx-auto text-[var(--c-muted)] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
      </svg>
      <p class="text-[var(--c-muted)]">No hay cotizaciones</p>
      <button id="btn-create-quote-empty" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-[var(--c-primary)] text-[var(--c-primary-ink)] rounded-xl hover:opacity-95 transition">
        Crear primera cotización
      </button>
    </div>

    <!-- Pagination -->
    <div id="quotes-pagination" class="flex justify-between items-center mt-6">
      <!-- Pagination will be loaded here -->
    </div>
  </div>
</div>

<!-- Create/Edit Quote Modal -->
<div id="quote-modal" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
  <div class="relative mx-auto mt-4 w-full max-w-4xl max-h-[95vh] overflow-y-auto">
    <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] overflow-hidden">
      <div class="px-6 py-4 border-b border-[var(--c-border)] flex items-center justify-between">
        <h3 id="quote-modal-title" class="text-lg font-semibold text-[var(--c-text)]">Nueva Cotización</h3>
        <button id="btn-close-modal" class="p-2 hover:bg-[var(--c-elev)] rounded-lg transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      <form id="quote-form" class="p-6 space-y-6">
        <input type="hidden" id="quote-id" name="id">
        
        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="md:col-span-2">
            <label for="quote-title" class="block text-sm font-medium text-[var(--c-text)] mb-1">Título *</label>
            <input type="text" id="quote-title" name="title" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent" required>
          </div>
          <div class="md:col-span-2">
            <label for="quote-description" class="block text-sm font-medium text-[var(--c-text)] mb-1">Descripción</label>
            <textarea id="quote-description" name="description" rows="2" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent"></textarea>
          </div>
        </div>

        <!-- Client Info -->
        <div class="border-t border-[var(--c-border)] pt-4">
          <h4 class="text-sm font-semibold text-[var(--c-text)] mb-3">Información del Cliente</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="quote-user-id" class="block text-sm font-medium text-[var(--c-text)] mb-1">Usuario del Sistema</label>
              <select id="quote-user-id" name="user_id" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
                <option value="">-- Sin usuario --</option>
              </select>
            </div>
            <div>
              <label for="quote-client-name" class="block text-sm font-medium text-[var(--c-text)] mb-1">Nombre del Cliente</label>
              <input type="text" id="quote-client-name" name="client_name" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
            </div>
            <div>
              <label for="quote-client-email" class="block text-sm font-medium text-[var(--c-text)] mb-1">Email del Cliente</label>
              <input type="email" id="quote-client-email" name="client_email" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
            </div>
            <div>
              <label for="quote-client-phone" class="block text-sm font-medium text-[var(--c-text)] mb-1">Teléfono</label>
              <input type="text" id="quote-client-phone" name="client_phone" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
            </div>
            <div class="md:col-span-2">
              <label for="quote-client-address" class="block text-sm font-medium text-[var(--c-text)] mb-1">Dirección</label>
              <textarea id="quote-client-address" name="client_address" rows="2" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent"></textarea>
            </div>
          </div>
        </div>

        <!-- Financial Info -->
        <div class="border-t border-[var(--c-border)] pt-4">
          <h4 class="text-sm font-semibold text-[var(--c-text)] mb-3">Información Financiera</h4>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label for="quote-currency-id" class="block text-sm font-medium text-[var(--c-text)] mb-1">Moneda</label>
              <select id="quote-currency-id" name="currency_id" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
                <option value="">-- Seleccionar --</option>
              </select>
            </div>
            <div>
              <label for="quote-tax-rate" class="block text-sm font-medium text-[var(--c-text)] mb-1">Tasa de Impuesto (%)</label>
              <input type="number" id="quote-tax-rate" name="tax_rate" step="0.01" min="0" max="100" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
            </div>
            <div>
              <label for="quote-valid-until" class="block text-sm font-medium text-[var(--c-text)] mb-1">Válida hasta</label>
              <input type="date" id="quote-valid-until" name="valid_until" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
            </div>
          </div>
        </div>

        <!-- Items Section -->
        <div class="border-t border-[var(--c-border)] pt-4">
          <div class="flex items-center justify-between mb-3">
            <h4 class="text-sm font-semibold text-[var(--c-text)]">Items de la Cotización</h4>
            <button type="button" id="btn-add-item" class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-[var(--c-primary)] text-[var(--c-primary-ink)] rounded-lg hover:opacity-95 transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              Agregar Item
            </button>
          </div>
          <div id="items-container" class="space-y-3">
            <!-- Items will be added here -->
          </div>
          <div id="items-empty" class="text-center py-8 text-[var(--c-muted)]">
            <p>No hay items agregados</p>
          </div>
        </div>

        <!-- Totals -->
        <div class="border-t border-[var(--c-border)] pt-4">
          <div class="flex justify-end">
            <div class="w-64 space-y-2">
              <div class="flex justify-between text-sm">
                <span class="text-[var(--c-muted)]">Subtotal:</span>
                <span id="quote-subtotal" class="font-medium">$0.00</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-[var(--c-muted)]">Descuento:</span>
                <span id="quote-discount" class="font-medium">-$0.00</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-[var(--c-muted)]">Impuesto:</span>
                <span id="quote-tax" class="font-medium">$0.00</span>
              </div>
              <div class="flex justify-between text-lg font-bold border-t border-[var(--c-border)] pt-2">
                <span>Total:</span>
                <span id="quote-total" class="text-[var(--c-primary)]">$0.00</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Notes & Terms -->
        <div class="border-t border-[var(--c-border)] pt-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="quote-notes" class="block text-sm font-medium text-[var(--c-text)] mb-1">Notas</label>
              <textarea id="quote-notes" name="notes" rows="3" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent"></textarea>
            </div>
            <div>
              <label for="quote-terms" class="block text-sm font-medium text-[var(--c-text)] mb-1">Términos y Condiciones</label>
              <textarea id="quote-terms" name="terms_conditions" rows="3" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent"></textarea>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-4 border-t border-[var(--c-border)]">
          <button type="button" id="btn-cancel-quote" class="px-4 py-2 text-[var(--c-muted)] hover:text-[var(--c-text)] transition">Cancelar</button>
          <button type="submit" class="px-4 py-2 bg-[var(--c-primary)] text-[var(--c-primary-ink)] rounded-lg hover:opacity-95 transition">Guardar Cotización</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Item Template (hidden) -->
<template id="item-template">
  <div class="item-row bg-[var(--c-elev)] rounded-xl p-4 border border-[var(--c-border)]">
    <div class="grid grid-cols-12 gap-3 items-start">
      <div class="col-span-12 md:col-span-4">
        <input type="text" name="item_name[]" placeholder="Nombre del item *" class="w-full px-3 py-2 bg-[var(--c-surface)] border border-[var(--c-border)] rounded-lg text-sm" required>
        <input type="text" name="item_description[]" placeholder="Descripción (opcional)" class="w-full px-3 py-2 bg-[var(--c-surface)] border border-[var(--c-border)] rounded-lg text-sm mt-2">
      </div>
      <div class="col-span-4 md:col-span-2">
        <input type="number" name="item_quantity[]" placeholder="Cant." step="0.01" min="0.01" value="1" class="w-full px-3 py-2 bg-[var(--c-surface)] border border-[var(--c-border)] rounded-lg text-sm item-quantity" required>
        <input type="text" name="item_unit[]" placeholder="Unidad" class="w-full px-3 py-2 bg-[var(--c-surface)] border border-[var(--c-border)] rounded-lg text-sm mt-2">
      </div>
      <div class="col-span-4 md:col-span-2">
        <input type="number" name="item_unit_price[]" placeholder="P. Unit." step="0.01" min="0" class="w-full px-3 py-2 bg-[var(--c-surface)] border border-[var(--c-border)] rounded-lg text-sm item-price" required>
        <input type="number" name="item_discount[]" placeholder="Desc. %" step="0.01" min="0" max="100" value="0" class="w-full px-3 py-2 bg-[var(--c-surface)] border border-[var(--c-border)] rounded-lg text-sm mt-2 item-discount">
      </div>
      <div class="col-span-3 md:col-span-3 flex items-center">
        <span class="item-total text-lg font-bold text-[var(--c-text)]">$0.00</span>
      </div>
      <div class="col-span-1 flex items-center justify-end">
        <button type="button" class="btn-remove-item p-2 text-red-500 hover:bg-red-500/10 rounded-lg transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const API_BASE = '/api';
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const API_TOKEN = document.querySelector('meta[name="api-token"]')?.getAttribute('content') || null;

  let currentPage = 1;
  let usersCache = [];
  let currenciesCache = [];
  let quoteTotals = { subtotal: 0, discount: 0, tax: 0, total: 0 };

  // Verificar token
  if (!API_TOKEN) {
    showError('Autenticación requerida', 'No se encontró un token de acceso válido.');
    return;
  }

  // Load initial data
  loadQuotes();
  loadUsers();
  loadCurrencies();
  loadStats();

  // Event listeners
  document.getElementById('btn-create-quote').addEventListener('click', () => openQuoteModal());
  document.getElementById('btn-create-quote-empty')?.addEventListener('click', () => openQuoteModal());
  document.getElementById('btn-refresh-quotes').addEventListener('click', () => loadQuotes());
  document.getElementById('search-quotes').addEventListener('input', debounce(() => loadQuotes(), 300));
  document.getElementById('filter-status').addEventListener('change', () => loadQuotes());
  document.getElementById('quote-form').addEventListener('submit', saveQuote);
  document.getElementById('btn-cancel-quote').addEventListener('click', closeQuoteModal);
  document.getElementById('btn-close-modal').addEventListener('click', closeQuoteModal);
  document.getElementById('btn-add-item').addEventListener('click', addItem);
  
  // Recalculate on tax change
  document.getElementById('quote-tax-rate').addEventListener('input', calculateTotals);

  // Functions
  async function loadQuotes(page = 1) {
    currentPage = page;
    const search = document.getElementById('search-quotes').value;
    const status = document.getElementById('filter-status').value;
    
    let url = `${API_BASE}/quotes?page=${page}&per_page=10`;
    if (search) url += `&search=${encodeURIComponent(search)}`;
    if (status) url += `&status=${status}`;

    try {
      const response = await fetch(url, {
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        renderQuotes(data.data);
        renderPagination(data.data);
      } else {
        showApiError('Error al cargar cotizaciones', data);
      }
    } catch (error) {
      showError('Error de conexión', 'No se pudieron cargar las cotizaciones.');
    }
  }

  async function loadStats() {
    try {
      // Load all quotes to count by status
      const response = await fetch(`${API_BASE}/quotes?per_page=1000`, {
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        const quotes = data.data.data;
        document.getElementById('stat-total').textContent = quotes.length;
        document.getElementById('stat-draft').textContent = quotes.filter(q => q.status === 'draft').length;
        document.getElementById('stat-sent').textContent = quotes.filter(q => q.status === 'sent').length;
        document.getElementById('stat-accepted').textContent = quotes.filter(q => q.status === 'accepted').length;
        document.getElementById('stat-rejected').textContent = quotes.filter(q => q.status === 'rejected').length;
      }
    } catch (error) {
      console.error('Error loading stats:', error);
    }
  }

  async function loadUsers() {
    try {
      const response = await fetch(`${API_BASE}/users?per_page=100`, {
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        usersCache = data.data.data;
        const select = document.getElementById('quote-user-id');
        select.innerHTML = '<option value="">-- Sin usuario --</option>';
        usersCache.forEach(user => {
          select.innerHTML += `<option value="${user.id}">${user.name} (${user.email})</option>`;
        });
      }
    } catch (error) {
      console.error('Error loading users:', error);
    }
  }

  async function loadCurrencies() {
    try {
      const response = await fetch(`${API_BASE}/currencies`, {
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        currenciesCache = data.data.data || data.data;
        const select = document.getElementById('quote-currency-id');
        select.innerHTML = '<option value="">-- Seleccionar --</option>';
        currenciesCache.forEach(currency => {
          select.innerHTML += `<option value="${currency.id}">${currency.code} - ${currency.name}</option>`;
        });
      }
    } catch (error) {
      console.error('Error loading currencies:', error);
    }
  }

  function renderQuotes(quotesData) {
    const container = document.getElementById('quotes-list');
    const emptyState = document.getElementById('quotes-empty');
    container.innerHTML = '';

    if (!quotesData.data || quotesData.data.length === 0) {
      emptyState.classList.remove('hidden');
      return;
    }

    emptyState.classList.add('hidden');

    quotesData.data.forEach(quote => {
      const tr = document.createElement('tr');
      tr.className = 'border-b border-[var(--c-border)] hover:bg-[var(--c-elev)]/50 transition';
      
      const statusBadge = getStatusBadge(quote.status);
      const clientName = quote.user ? quote.user.name : (quote.client_name || 'Sin cliente');
      const currencySymbol = quote.currency?.symbol || '$';

      tr.innerHTML = `
        <td class="py-3 px-4">
          <span class="font-mono text-sm font-medium text-[var(--c-primary)]">${quote.quote_number}</span>
        </td>
        <td class="py-3 px-4">
          <div class="font-medium text-[var(--c-text)]">${quote.title}</div>
          ${quote.description ? `<div class="text-xs text-[var(--c-muted)] truncate max-w-xs">${quote.description}</div>` : ''}
        </td>
        <td class="py-3 px-4 text-[var(--c-muted)]">${clientName}</td>
        <td class="py-3 px-4 text-right font-medium">${currencySymbol}${parseFloat(quote.total).toFixed(2)}</td>
        <td class="py-3 px-4 text-center">${statusBadge}</td>
        <td class="py-3 px-4 text-[var(--c-muted)] text-sm">${formatDate(quote.created_at)}</td>
        <td class="py-3 px-4">
          <div class="flex items-center justify-center gap-1">
            <button class="btn-view-quote p-2 hover:bg-[var(--c-elev)] rounded-lg transition" data-id="${quote.id}" title="Ver">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
            <button class="btn-edit-quote p-2 hover:bg-[var(--c-elev)] rounded-lg transition" data-id="${quote.id}" title="Editar">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>
            <button class="btn-download-pdf p-2 hover:bg-[var(--c-elev)] rounded-lg transition text-blue-500" data-id="${quote.id}" title="Descargar PDF">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </button>
            <button class="btn-duplicate-quote p-2 hover:bg-[var(--c-elev)] rounded-lg transition text-green-500" data-id="${quote.id}" title="Duplicar">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
              </svg>
            </button>
            <button class="btn-delete-quote p-2 hover:bg-red-500/10 rounded-lg transition text-red-500" data-id="${quote.id}" title="Eliminar">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </div>
        </td>
      `;
      container.appendChild(tr);
    });

    // Add event listeners
    container.querySelectorAll('.btn-view-quote').forEach(btn => {
      btn.addEventListener('click', (e) => viewQuote(e.currentTarget.dataset.id));
    });
    container.querySelectorAll('.btn-edit-quote').forEach(btn => {
      btn.addEventListener('click', (e) => editQuote(e.currentTarget.dataset.id));
    });
    container.querySelectorAll('.btn-download-pdf').forEach(btn => {
      btn.addEventListener('click', (e) => downloadPdf(e.currentTarget.dataset.id));
    });
    container.querySelectorAll('.btn-duplicate-quote').forEach(btn => {
      btn.addEventListener('click', (e) => duplicateQuote(e.currentTarget.dataset.id));
    });
    container.querySelectorAll('.btn-delete-quote').forEach(btn => {
      btn.addEventListener('click', (e) => deleteQuote(e.currentTarget.dataset.id));
    });
  }

  function getStatusBadge(status) {
    const badges = {
      draft: '<span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-500">Borrador</span>',
      sent: '<span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-500">Enviada</span>',
      accepted: '<span class="px-2 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-500">Aceptada</span>',
      rejected: '<span class="px-2 py-1 text-xs font-medium rounded-full bg-red-500/10 text-red-500">Rechazada</span>',
      expired: '<span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-500/10 text-gray-500">Expirada</span>'
    };
    return badges[status] || status;
  }

  function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
  }

  function renderPagination(quotesData) {
    const container = document.getElementById('quotes-pagination');
    container.innerHTML = '';

    if (quotesData.last_page <= 1) return;

    const prevBtn = document.createElement('button');
    prevBtn.textContent = 'Anterior';
    prevBtn.className = 'px-3 py-2 rounded-lg bg-[var(--c-elev)] text-[var(--c-text)] hover:bg-[var(--c-elev)]/80 disabled:opacity-50';
    prevBtn.disabled = !quotesData.prev_page_url;
    prevBtn.addEventListener('click', () => loadQuotes(quotesData.current_page - 1));

    const nextBtn = document.createElement('button');
    nextBtn.textContent = 'Siguiente';
    nextBtn.className = 'px-3 py-2 rounded-lg bg-[var(--c-elev)] text-[var(--c-text)] hover:bg-[var(--c-elev)]/80 disabled:opacity-50';
    nextBtn.disabled = !quotesData.next_page_url;
    nextBtn.addEventListener('click', () => loadQuotes(quotesData.current_page + 1));

    const pageInfo = document.createElement('div');
    pageInfo.textContent = `Página ${quotesData.current_page} de ${quotesData.last_page}`;
    pageInfo.className = 'text-sm text-[var(--c-muted)]';

    container.appendChild(prevBtn);
    container.appendChild(pageInfo);
    container.appendChild(nextBtn);
  }

  function openQuoteModal(quoteData = null) {
    const modal = document.getElementById('quote-modal');
    const title = document.getElementById('quote-modal-title');
    const form = document.getElementById('quote-form');
    form.reset();
    
    document.getElementById('items-container').innerHTML = '';
    document.getElementById('items-empty').classList.remove('hidden');
    updateTotalsDisplay();

    if (quoteData) {
      title.textContent = 'Editar Cotización';
      document.getElementById('quote-id').value = quoteData.id;
      document.getElementById('quote-title').value = quoteData.title || '';
      document.getElementById('quote-description').value = quoteData.description || '';
      document.getElementById('quote-user-id').value = quoteData.user_id || '';
      document.getElementById('quote-client-name').value = quoteData.client_name || '';
      document.getElementById('quote-client-email').value = quoteData.client_email || '';
      document.getElementById('quote-client-phone').value = quoteData.client_phone || '';
      document.getElementById('quote-client-address').value = quoteData.client_address || '';
      document.getElementById('quote-currency-id').value = quoteData.currency_id || '';
      document.getElementById('quote-tax-rate').value = quoteData.tax_rate || 0;
      document.getElementById('quote-valid-until').value = quoteData.valid_until ? quoteData.valid_until.split('T')[0] : '';
      document.getElementById('quote-notes').value = quoteData.notes || '';
      document.getElementById('quote-terms').value = quoteData.terms_conditions || '';

      // Load items
      if (quoteData.items && quoteData.items.length > 0) {
        document.getElementById('items-empty').classList.add('hidden');
        quoteData.items.forEach(item => {
          addItem(item);
        });
      }
    } else {
      title.textContent = 'Nueva Cotización';
      document.getElementById('quote-id').value = '';
    }

    modal.classList.remove('hidden');
  }

  function closeQuoteModal() {
    document.getElementById('quote-modal').classList.add('hidden');
  }

  function addItem(itemData = null) {
    const container = document.getElementById('items-container');
    const template = document.getElementById('item-template');
    const clone = template.content.cloneNode(true);
    const row = clone.querySelector('.item-row');

    document.getElementById('items-empty').classList.add('hidden');

    if (itemData && itemData.name) {
      row.querySelector('[name="item_name[]"]').value = itemData.name;
      row.querySelector('[name="item_description[]"]').value = itemData.description || '';
      row.querySelector('[name="item_quantity[]"]').value = itemData.quantity || 1;
      row.querySelector('[name="item_unit[]"]').value = itemData.unit || '';
      row.querySelector('[name="item_unit_price[]"]').value = itemData.unit_price || 0;
      row.querySelector('[name="item_discount[]"]').value = itemData.discount_percent || 0;
      updateItemTotal(row);
    }

    // Event listeners for item
    row.querySelector('.btn-remove-item').addEventListener('click', () => {
      row.remove();
      if (container.children.length === 0) {
        document.getElementById('items-empty').classList.remove('hidden');
      }
      calculateTotals();
    });

    row.querySelectorAll('.item-quantity, .item-price, .item-discount').forEach(input => {
      input.addEventListener('input', () => {
        updateItemTotal(row);
        calculateTotals();
      });
    });

    container.appendChild(clone);
    calculateTotals();
  }

  function updateItemTotal(row) {
    const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
    const price = parseFloat(row.querySelector('.item-price').value) || 0;
    const discount = parseFloat(row.querySelector('.item-discount').value) || 0;
    
    const subtotal = quantity * price;
    const discountAmount = subtotal * (discount / 100);
    const total = subtotal - discountAmount;
    
    row.querySelector('.item-total').textContent = '$' + total.toFixed(2);
  }

  function calculateTotals() {
    const container = document.getElementById('items-container');
    const rows = container.querySelectorAll('.item-row');
    let subtotal = 0;
    let totalDiscount = 0;

    rows.forEach(row => {
      const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
      const price = parseFloat(row.querySelector('.item-price').value) || 0;
      const discount = parseFloat(row.querySelector('.item-discount').value) || 0;
      
      const itemSubtotal = quantity * price;
      const itemDiscount = itemSubtotal * (discount / 100);
      
      subtotal += itemSubtotal;
      totalDiscount += itemDiscount;
    });

    const taxRate = parseFloat(document.getElementById('quote-tax-rate').value) || 0;
    const taxableAmount = subtotal - totalDiscount;
    const tax = taxableAmount * (taxRate / 100);
    const total = taxableAmount + tax;

    quoteTotals = { subtotal, discount: totalDiscount, tax, total };
    updateTotalsDisplay();
  }

  function updateTotalsDisplay() {
    document.getElementById('quote-subtotal').textContent = '$' + quoteTotals.subtotal.toFixed(2);
    document.getElementById('quote-discount').textContent = '-$' + quoteTotals.discount.toFixed(2);
    document.getElementById('quote-tax').textContent = '$' + quoteTotals.tax.toFixed(2);
    document.getElementById('quote-total').textContent = '$' + quoteTotals.total.toFixed(2);
  }

  async function saveQuote(e) {
    e.preventDefault();

    const id = document.getElementById('quote-id').value;
    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_BASE}/quotes/${id}` : `${API_BASE}/quotes`;

    // Collect items
    const items = [];
    const container = document.getElementById('items-container');
    const rows = container.querySelectorAll('.item-row');
    
    rows.forEach((row, index) => {
      items.push({
        name: row.querySelector('[name="item_name[]"]').value,
        description: row.querySelector('[name="item_description[]"]').value,
        quantity: parseFloat(row.querySelector('[name="item_quantity[]"]').value) || 1,
        unit: row.querySelector('[name="item_unit[]"]').value,
        unit_price: parseFloat(row.querySelector('[name="item_unit_price[]"]').value) || 0,
        discount_percent: parseFloat(row.querySelector('[name="item_discount[]"]').value) || 0,
        sort_order: index
      });
    });

    const formData = {
      title: document.getElementById('quote-title').value,
      description: document.getElementById('quote-description').value,
      user_id: document.getElementById('quote-user-id').value || null,
      client_name: document.getElementById('quote-client-name').value,
      client_email: document.getElementById('quote-client-email').value,
      client_phone: document.getElementById('quote-client-phone').value,
      client_address: document.getElementById('quote-client-address').value,
      currency_id: document.getElementById('quote-currency-id').value || null,
      tax_rate: parseFloat(document.getElementById('quote-tax-rate').value) || 0,
      valid_until: document.getElementById('quote-valid-until').value || null,
      notes: document.getElementById('quote-notes').value,
      terms_conditions: document.getElementById('quote-terms').value,
      items: items
    };

    try {
      const response = await fetch(url, {
        method: method,
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (response.ok && data.success) {
        closeQuoteModal();
        loadQuotes();
        loadStats();
        window.dispatchEvent(new CustomEvent('api:response', { detail: data }));
      } else {
        showApiError('Error al guardar cotización', data);
      }
    } catch (error) {
      showError('Error de conexión', 'No se pudo guardar la cotización.');
    }
  }

  async function viewQuote(id) {
    // Open in preview mode - use web route with session auth
    window.open(`/admin/quotes/${id}/pdf/preview`, '_blank');
  }

  async function editQuote(id) {
    try {
      const response = await fetch(`${API_BASE}/quotes/${id}`, {
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        openQuoteModal(data.data);
      } else {
        showApiError('Error al cargar cotización', data);
      }
    } catch (error) {
      showError('Error de conexión', 'No se pudo cargar la cotización.');
    }
  }

  function downloadPdf(id) {
    // Use web route with session auth instead of API
    window.open(`/admin/quotes/${id}/pdf/download`, '_blank');
  }

  async function duplicateQuote(id) {
    if (!confirm('¿Deseas duplicar esta cotización?')) return;

    try {
      const response = await fetch(`${API_BASE}/quotes/${id}/duplicate`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        loadQuotes();
        loadStats();
        window.dispatchEvent(new CustomEvent('api:response', { detail: data }));
      } else {
        showApiError('Error al duplicar cotización', data);
      }
    } catch (error) {
      showError('Error de conexión', 'No se pudo duplicar la cotización.');
    }
  }

  async function deleteQuote(id) {
    if (!confirm('¿Estás seguro de eliminar esta cotización?')) return;

    try {
      const response = await fetch(`${API_BASE}/quotes/${id}`, {
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        loadQuotes();
        loadStats();
        window.dispatchEvent(new CustomEvent('api:response', { detail: data }));
      } else {
        showApiError('Error al eliminar cotización', data);
      }
    } catch (error) {
      showError('Error de conexión', 'No se pudo eliminar la cotización.');
    }
  }

  function showError(title, message) {
    window.dispatchEvent(new CustomEvent('api:response', {
      detail: { success: false, message: message }
    }));
  }

  function showApiError(title, apiResponse) {
    window.dispatchEvent(new CustomEvent('api:response', {
      detail: {
        success: false,
        message: apiResponse.message || 'Error desconocido',
        errors: apiResponse.errors || null
      }
    }));
  }

  function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }
});
</script>
@endsection