@php
  $selectedServices = old(
      'service_ids',
      isset($appointment)
          ? $appointment->appointmentServices->pluck('service_id')->map(fn ($id) => (string) $id)->all()
          : []
  );

  $selectedStaffId = old(
      'staff_id',
      isset($appointment)
          ? optional($appointment->appointmentServices->firstWhere('staff_id', '!=', null))->staff_id
          : ''
  );

  $appointmentTime = old(
      'appointment_time',
      isset($appointment) && $appointment->appointment_time
          ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')
          : ''
  );

  $appointmentDate = old(
      'appointment_date',
      isset($appointment) && $appointment->appointment_date
          ? $appointment->appointment_date->format('Y-m-d')
          : ''
  );

  $inputClass = 'dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 border-gray-300 focus:border-brand-300 dark:border-gray-700 dark:focus:border-brand-800';
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
  <div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Client <span class="text-error-500">*</span>
    </label>
    <select name="client_id" class="{{ $inputClass }}">
      <option value="">Select client</option>
      @foreach($clients as $client)
        <option value="{{ $client->id }}" @selected(old('client_id', $appointment->client_id ?? '') == $client->id)>
          {{ $client->full_name }} - {{ $client->phone }}
        </option>
      @endforeach
    </select>
    <x-staff.form.error name="client_id" />
  </div>

  <div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Staff</label>
    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
      <select
        name="staff_id"
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
        :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
        @change="isOptionSelected = true"
      >
        <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Unassigned</option>
        @foreach($staff as $staffMember)
          <option value="{{ $staffMember->id }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($selectedStaffId == $staffMember->id)>
            {{ $staffMember->full_name }}
          </option>
        @endforeach
      </select>
      <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
    </div>
    <x-staff.form.error name="staff_id" />
  </div>

  <div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Date <span class="text-error-500">*</span>
    </label>
    <div class="relative">
      <input
        type="date"
        name="appointment_date"
        value="{{ $appointmentDate }}"
        min="{{ now()->toDateString() }}"
        placeholder="Select date"
        onclick="this.showPicker()"
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
      />
      <span class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400">
        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z" fill=""/>
        </svg>
      </span>
    </div>
    <x-staff.form.error name="appointment_date" />
  </div>

  <div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Time <span class="text-error-500">*</span>
    </label>
    <div class="relative">
      <input
        type="time"
        name="appointment_time"
        value="{{ $appointmentTime }}"
        placeholder="12:00 AM"
        onclick="this.showPicker()"
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
      />
      <span class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400">
        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04175 9.99984C3.04175 6.15686 6.1571 3.0415 10.0001 3.0415C13.8431 3.0415 16.9584 6.15686 16.9584 9.99984C16.9584 13.8428 13.8431 16.9582 10.0001 16.9582C6.1571 16.9582 3.04175 13.8428 3.04175 9.99984ZM10.0001 1.5415C5.32867 1.5415 1.54175 5.32843 1.54175 9.99984C1.54175 14.6712 5.32867 18.4582 10.0001 18.4582C14.6715 18.4582 18.4584 14.6712 18.4584 9.99984C18.4584 5.32843 14.6715 1.5415 10.0001 1.5415ZM9.99998 10.7498C9.58577 10.7498 9.24998 10.4141 9.24998 9.99984V5.4165C9.24998 5.00229 9.58577 4.6665 9.99998 4.6665C10.4142 4.6665 10.75 5.00229 10.75 5.4165V9.24984H13.3334C13.7476 9.24984 14.0834 9.58562 14.0834 9.99984C14.0834 10.4141 13.7476 10.7498 13.3334 10.7498H10.0001H9.99998Z" fill=""/>
        </svg>
      </span>
    </div>
    <x-staff.form.error name="appointment_time" />
  </div>

  @isset($appointment)
    <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Status <span class="text-error-500">*</span>
      </label>
      <select name="status" class="{{ $inputClass }}">
        @foreach(['pending' => 'Pending', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled', 'completed'] as $value => $label)
          <option value="{{ $value }}" @selected(old('status', $appointment->status) === $value)>{{ $label }}</option>
        @endforeach
      </select>
      <x-staff.form.error name="status" />
    </div>
  @endisset

  <div class="@isset($appointment) lg:col-span-1 @else lg:col-span-2 @endisset">
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Services <span class="text-error-500">*</span>
    </label>
    <div class="grid grid-cols-1 gap-3 rounded-lg border border-gray-200 p-4 dark:border-gray-700 sm:grid-cols-2">
      @foreach($services as $service)
        <label class="flex items-start gap-3 rounded-lg border border-gray-100 p-3 text-sm dark:border-gray-800">
          <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" @checked(in_array((string) $service->id, $selectedServices, true)) class="mt-1 size-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
          <span>
            <span class="block font-medium text-gray-800 dark:text-white/90">{{ $service->name }}</span>
            <span class="block text-xs text-gray-500 dark:text-gray-400">
              {{ number_format($service->price) }} VND - {{ $service->duration }} minutes
            </span>
          </span>
        </label>
      @endforeach
    </div>
    <x-staff.form.error name="service_ids" />
    <x-staff.form.error name="service_ids.*" />
  </div>

  <div class="lg:col-span-2">
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Notes</label>
    <textarea name="notes" rows="4" class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 border-gray-300 focus:border-brand-300 dark:border-gray-700 dark:focus:border-brand-800" placeholder="Appointment notes">{{ old('notes', $appointment->notes ?? '') }}</textarea>
    <x-staff.form.error name="notes" />
  </div>
</div>
