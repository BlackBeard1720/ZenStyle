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
    <select name="staff_id" class="{{ $inputClass }}">
      <option value="">Unassigned</option>
      @foreach($staff as $staffMember)
        <option value="{{ $staffMember->id }}" @selected($selectedStaffId == $staffMember->id)>
          {{ $staffMember->full_name }}
        </option>
      @endforeach
    </select>
    <x-staff.form.error name="staff_id" />
  </div>

  <div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Date <span class="text-error-500">*</span>
    </label>
    <input type="date" name="appointment_date" value="{{ $appointmentDate }}" class="{{ $inputClass }}">
    <x-staff.form.error name="appointment_date" />
  </div>

  <div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Time <span class="text-error-500">*</span>
    </label>
    <input type="time" name="appointment_time" value="{{ $appointmentTime }}" class="{{ $inputClass }}">
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
            <span class="block font-medium text-gray-800 dark:text-white/90">{{ $service->service_name }}</span>
            <span class="block text-xs text-gray-500 dark:text-gray-400">
              {{ number_format($service->price) }} VND - {{ $service->duration_minutes }} minutes
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
