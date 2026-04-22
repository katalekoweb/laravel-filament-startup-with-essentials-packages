<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $id = 'currency-' . rand(10000, 99999);
    @endphp

    <div x-data="{
        state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }},
        init() {
            let inputValue = document.getElementById('{{ $id }}')
            $('#{{ $id }}').maskMoney({
                suffix: ' {{ currencyName() }}',
                thousands: '.',
                decimal: ',',
            });
    
            inputValue.addEventListener('keyup', (event) => {
                this.state = event.target.value
            });
    
        },
    }">
        <!-- Interact with the `state` property in Alpine.js -->
        <input x-model="state" id="{{ $id }}" style="padding: 8px; border-radius: 8px; border: 1px solid #ddd; width: 100%" class=" border p-1 px-3 bg-gray-300 dark:bg-gray-900 dark:border-gray-500 dark:text-white rounded-md border-gray-200 shadow-sm w-full" />

    </div>

</x-dynamic-component>