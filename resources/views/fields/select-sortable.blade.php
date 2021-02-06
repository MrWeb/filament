@extends('filament::layouts.field-group')

@pushonce('js:livewire-sortable')
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
@endpushonce

@section('field')
    <div class="space-y-4">
        <x-filament::select
            :id="$field->id"
            :error-key="$field->errorKey"
            :extra-attributes="$field->attributes"
            wire:change="{{ $field->addMethod }}($event.target.value)"
        >
            <option value="">{{ __($field->placeholder) }}</option>

            @foreach ($field->options as $value => $label)
                <option
                    value="{{ $value }}"
                    @if (in_array($value, (array) $field->value)) disabled @endif
                >
                    {{ $label }}
                </option>
            @endforeach
        </x-filament::select>

        @if ($field->value)
            <ol
                class="rounded shadow-sm border border-gray-300 divide-y divide-gray-300"
                @if ($field->sortMethod) wire:sortable="{{ $field->sortMethod }}" @endif
            >
                @foreach ((array) $field->value as $key => $id)
                    <li
                        class="w-full px-3 py-2 flex items-center justify-between space-x-6"
                        @if ($field->sortMethod)
                            wire:key="value-{{ $key }}"
                            wire:sortable.item="{{ $id }}"
                        @endif
                    >
                        <div class="flex-grow flex items-center space-x-3">
                            @if ($field->sortMethod)
                                <button
                                    class="flex-shrink-0 text-gray-300 hover:text-gray-600 transition-colors duration-200 flex cursor-move"
                                    wire:sortable.handle
                                >
                                    <x-heroicon-o-menu-alt-4 class="w-4 h-4" aria-hidden="true" />

                                    <span class="sr-only">{{ __('filament::relation.sort') }}</span>
                                </button>
                            @endif

                            <div class="flex-grow overflow-x-auto">
                                <span class="text-sm leading-tight">{{ isset($field->options[$id]) ? $field->options[$id] : $id }}</span>
                            </div>
                        </div>

                        @if ($field->deleteMethod)
                            <button
                                type="button"
                                class="flex-shrink-0 text-gray-500 hover:text-red-600 transition-colors duration-200 flex"
                                wire:click="{{ $field->deleteMethod }}('{{ $key }}')"
                            >
                                <x-heroicon-o-x class="w-4 h-4" />

                                <span class="sr-only">{{ __('filament::relation.delete') }}</span>
                            </button>
                        @endif
                    </li>
                @endforeach
            </ol>
        @endif
    </div>
@overwrite
