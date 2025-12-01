<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 4000)"
     
     x-transition:enter="transition-all duration-500"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition-all duration-400"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"

     :class="{
         'border-success bg-success-subtle': type === 'success',
         'border-danger bg-danger-subtle': type === 'error',
         'border-warning bg-warning-subtle': type === 'warning',
         'border-info bg-info-subtle': type === 'info',
     }"
     
     class="shadow rounded-lg position-relative mb-4 d-flex align-items-start px-5 py-3 border border-start-0"
     style="border-left-width: 4px !important;"
     role="alert">

    <div class="pt-1 me-3"> 
        <template x-if="type === 'success'">
            <svg class="h-5 w-5 text-success" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
        </template>
        <template x-if="type === 'error'">
            <svg class="h-5 w-5 text-danger" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        </template>
        <template x-if="type === 'warning'">
            <svg class="h-5 w-5 text-warning" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12A9 9 0 11 3 12a9 9 0 0118 0z" /></svg>
        </template>
        <template x-if="type === 'info'">
             <svg class="h-5 w-5 text-info" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </template>
    </div>

    <div class="flex-grow-1 text-sm font-normal leading-relaxed">
        {{ $slot }}
    </div>

    <button type="button" class="position-absolute top-0 end-0 mt-2 me-2 rounded-full p-1 hover:bg-gray-100 transition border-0 bg-transparent" @click="show = false">
        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
    </button>
</div>