<div class="flex flex-col gap-6">
    <x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
        <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
            <div class="flex flex-wrap gap-4 items-center w-full`">
                <x-filament::input.wrapper class="flex-grow" placeholder="Enter a video URL...">
                    <x-filament::input type="text" wire:model.lazy="{{ $getStatePath() }}" />
                </x-filament::input.wrapper>

                <x-filament::button wire:click="{{ $fetchVideo() }}" class="flex-shrink-0">
                    Fetch Video
                </x-filament::button>
            </div>
        </div>
    </x-dynamic-component>
    <div class="mt-4">
        {!! $getIFrame() !!}
    </div>
</div>
