<div class="form-row"
    x-data="{
        value: @entangle($attributes->wire('model')),
        isFocused() { return document.activeElement !== this.$refs.input },
        init() {
            ClassicEditor
                .create(this.$refs.input)
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        this.value = editor.getData();
                    });

                    $watch('value', value => {
                        if (value !== editor.getData()) {
                            editor.setData(value);
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }"
    x-init="init()"
>
    @if($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <div class="ckeditor-container" wire:ignore>
        <textarea
            x-ref="input"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            rows="{{ $rows }}"
        >{{ $value }}</textarea>
    </div>

    @error($attributes->wire('model')->value())
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>
