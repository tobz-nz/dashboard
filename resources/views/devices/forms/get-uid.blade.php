<form class="grid justify-center" action="{{ route('setup.store') }}" method="post">
    @csrf()

    <p>Setup your new Tankful Water Monitor. Start by scanning the QR code on the bottom of your device.</p>

    <video id="qr" class="block border" width="200" autoplay></video>

    @push('scripts')
    {{-- <script type="module">
        var video = document.querySelector("#qr");

        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({video: true})
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function(err0r) {
                console.log("Something went wrong!");
            });
        }
    </script> --}}
    @endpush()

    <div class="input-group --inline">
        <div class="input-group">
            <label for="uid">Or type in the code manually</label>
            <input type="text" id="uid" name="uid" value="{{ old('uid') }}" placeholder="e.g. 123fgh456" required>
            @if ($errors->has('uid'))
                <div class="input--error">{{ $errors->first('uid') }}</div>
            @endif
        </div>

        <button type="submit" class="inline-flex justify-center items-center">
            <svg class="" width="20" height="20" role="image">
                <use href="{{ asset('images/icons.svg#arrow-right') }}"></use>
            </svg>
        </button>
    </div>
</form>
