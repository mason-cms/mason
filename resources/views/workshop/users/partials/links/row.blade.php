<tr>
    <td>
        <input
            name="user[links][{{ $key = \Illuminate\Support\Str::random() }}][id]"
            type="hidden"
            value="{{ $userLink->id }}"
        />

        <div class="field">
            <input
                class="input"
                name="user[links][{{ $key }}][title]"
                type="text"
                maxlength="255"
                value="{!! $userLink->title !!}"
            />
        </div>
    </td>

    <td>
        <div class="field">
            <input
                class="input"
                name="user[links][{{ $key }}][url]"
                type="url"
                placeholder="https://"
                value="{!! $userLink->url !!}"
            />
        </div>
    </td>
</tr>
